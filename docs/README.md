# Modulo Tenant

## Panoramica
Il modulo Tenant gestisce il multi-tenancy dell'applicazione, fornendo un sistema completo per la gestione di tenant multipli, isolamento dei dati e configurazioni specifiche per ogni tenant.

### Versione HEAD


### Versione Incoming

## Collegamenti correlati
- [README.md documentazione generale](../../../docs/README.md)
- [README.md toolkit bashscripts](../../../bashscripts/docs/README.md)
- [README.md modulo GDPR](../Gdpr/docs/README.md)
- [README.md modulo User](../User/docs/README.md)
- [README.md modulo Lang](../Lang/docs/README.md)
- [README.md modulo Activity](../Activity/docs/README.md)
- [README.md modulo Media](../Media/docs/README.md)
- [README.md modulo Notify](../Notify/docs/README.md)
- [README.md modulo Tenant](../Tenant/docs/README.md)
- [README.md modulo UI](../UI/docs/README.md)
- [README.md modulo Xot](../Xot/docs/README.md)
- [Collegamenti documentazione centrale](../../../docs/collegamenti-documentazione.md)


---

## Collegamenti Principali

### Documentazione Core
- [Struttura del Modulo](./structure.md)
- [Modelli Tenant](./models/tenant.md)
- [Traits](./traits/README.md)
- [Middleware](./middleware.md)
- [Best Practices](./BEST-PRACTICES.md)

### Integrazioni
- [Integrazione con User](../User/docs/README.md)
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con Lang](../Lang/docs/README.md)

### Best Practices
- [Convenzioni Tenant](./tenant-conventions.md)
- [Gestione Database](./database-management.md)
- [PHPStan Fixes](./phpstan-fixes.md)

### Testing e Qualità
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)
- [Testing Best Practices](./testing-best-practices.md)

## Struttura del Modulo

```
Modules/Tenant/
├── app/
│   ├── Models/
│   │   ├── Tenant.php
│   │   └── TenantUser.php
│   ├── Providers/
│   │   ├── TenantServiceProvider.php
│   │   └── TenantBaseServiceProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── TenantResource.php
│   │   ├── Widgets/
│   │   │   └── TenantStatsWidget.php
│   │   └── Pages/
│   │       └── TenantManager.php
│   └── Http/
│       └── Controllers/
│           └── TenantController.php
├── config/
│   └── tenant.php
├── database/
│   └── migrations/
│       ├── create_tenants_table.php
│       └── create_tenant_users_table.php
└── resources/
    └── views/
        └── tenant/
            ├── dashboard.blade.php
            └── settings.blade.php
```

## Gestione Tenant

### 1. Modello Tenant
```php
// app/Models/Tenant.php
namespace App\Models;

use Modules\Tenant\Models\XotBaseTenant;
use Modules\Lang\Facades\Lang;

class Tenant extends XotBaseTenant
{
    protected $fillable = [
        'name',
        'domain',
        'database',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    public function getDisplayNameAttribute(): string
    {
        return Lang::get('tenant.name', ['name' => $this->name]);
    }
}
```

### 2. Trait HasTenant
```php
// ❌ NON FARE QUESTO
class User extends Model
{
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}

// ✅ FARE QUESTO
use Modules\Tenant\Traits\HasTenant;

class User extends XotBaseModel
{
    use HasTenant;

    protected $fillable = [
        'name',
        'email',
        'tenant_id'
    ];
}
```

### 3. Middleware Tenant
```php
// ❌ NON FARE QUESTO
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// ✅ FARE QUESTO
Route::middleware(['auth', 'tenant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

## Best Practices

### 1. Database
- Utilizzare connessioni separate
- Implementare migrazioni tenant
- Gestire backup tenant
- Isolare i dati

### 2. Autenticazione
```php
// ❌ NON FARE QUESTO
if (auth()->attempt($credentials)) {
    return redirect()->intended();
}

// ✅ FARE QUESTO
if (Tenant::current()->authenticate($credentials)) {
    return redirect()->intended();
}
```

### 3. Configurazione
```php
// ❌ NON FARE QUESTO
config(['app.name' => 'My App']);

// ✅ FARE QUESTO
Tenant::current()->configure([
    'app.name' => 'My App'
]);
```

## Dipendenze Principali

### Moduli
- **User**: Gestione utenti tenant
- **Xot**: Tenant base
- **Lang**: Traduzioni tenant

### Pacchetti
- Laravel Framework
- Filament
- Livewire
- Spatie Permission

## Roadmap

### Prossime Feature
1. Nuovi tipi tenant
2. Miglioramento isolamento
3. Ottimizzazione performance

### Miglioramenti Pianificati
1. Refactoring tenant
2. Miglioramento UI
3. Ottimizzazione query

## Contribuire

### Setup Sviluppo
1. Clona il repository
2. Installa le dipendenze
3. Configura l'ambiente
4. Esegui i test

### Convenzioni di Codice
- Seguire PSR-12
- Utilizzare type hints
- Documentare il codice
- Scrivere test unitari

### Processo di Pull Request
1. Crea un branch feature
2. Implementa le modifiche
3. Aggiungi i test
4. Aggiorna la documentazione
5. Crea la PR

## Troubleshooting

### Problemi Comuni
1. Connessione database
2. Isolamento dati
3. Errori configurazione

### Soluzioni
1. Verifica configurazione
2. Controlla log
3. Consulta documentazione

## Riferimenti

### Documentazione
- [Laravel Multi-Tenancy](https://laravel.com/docs/12.x/multi-tenancy)
- [Filament](https://filamentphp.com/docs)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Xot Module](../Xot/docs/README.md)
- [Lang Module](../Lang/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Sistema tenant
- Isolamento dati
- Configurazione tenant

#### Changed
- Miglioramento performance
- Ottimizzazione query
- Refactoring codice

#### Fixed
- Bug tenant
- Problemi isolamento
### Versione HEAD

- Errori configurazione 

### Versione Incoming

- Errori configurazione 
## Collegamenti
- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo Cms](../../Cms/docs/README.md)
- [Modulo Lang](../../Lang/docs/README.md) 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)


---

## Proprietà fondamentali del ServiceProvider (Laraxot/PTVX)

Tutti i provider dei moduli che estendono XotBaseServiceProvider **devono** dichiarare:
- `protected string $module_dir = __DIR__;`
- `protected string $module_ns = __NAMESPACE__;`
- `public string $name = 'Tenant';`

Queste proprietà sono necessarie per:
- La risoluzione automatica dei path delle risorse
- Il corretto namespace per autoloading e publish
- L'identificazione del modulo nelle operazioni di asset publish

### Esempio
```php
class TenantServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    public string $name = 'Tenant';
}
```

**Motivazione:**  
- Se mancano queste proprietà, alcune risorse potrebbero non essere caricate correttamente.
- La dichiarazione esplicita garantisce portabilità, manutenibilità e coerenza tra tutti i moduli.

**Approfondimenti:**  
- Vedi anche [../../../../docs/PROVIDER_OVERVIEW.md](../../../../docs/PROVIDER_OVERVIEW.md)

## Regola per i file .sh (script shell)

Tutti i file `.sh` (script shell) devono essere posizionati esclusivamente in una sottocartella dedicata chiamata `bashscripts` (ad esempio `docs/bashscripts/`).
Non devono mai trovarsi direttamente nella root di `docs/` o in altre sottocartelle generiche.

**Motivazione:**
- Ordine e reperibilità: tutti gli script shell sono facilmente individuabili e gestibili.
- Sicurezza: si evita l'esecuzione accidentale di script non previsti.
- Coerenza cross-modulo e tra root/moduli.

**Esempio di struttura corretta:**
```
docs/
└── bashscripts/
    ├── deploy.sh
    ├── clear_cache.sh
    └── backup_db.sh
```

**Checklist aggiornata:**
- [x] Nessun file .sh fuori da bashscripts/
- [x] Documentazione aggiornata
- [x] Struttura coerente in tutti i moduli

