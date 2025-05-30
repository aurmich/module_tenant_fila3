# Modulo Tenant - Modular Monolith

## Architettura Modular Monolith: Best Practices 2025

Questa sezione integra i principi dell'articolo "Architecting Laravel the Right Way: Modular Monoliths Done Right" (Mohamad Shahkhajeh, 2025) e le migliori pratiche moderne per la progettazione di moduli Laravel realmente indipendenti e manutenibili.

### 1. Cos'è un Modular Monolith?
Un monolite modulare è un'unica applicazione con moduli interni **ben separati**, ognuno con il proprio dominio, interfacce minime esposte e logica interna nascosta. Si distribuisce una sola app, ma ogni modulo è isolato e pronto per evolvere (anche verso microservizi, se necessario).

### 2. Struttura a Livelli (Hexagonal/DDD)
Ogni modulo segue una struttura ispirata all'architettura esagonale:

```
Modules/Tenant
├── Domain         # Logica di dominio pura (entità, value object, regole)
├── Application    # Casi d'uso (es. CreateTenant, UpdateTenant)
├── Infrastructure # Accesso a DB, servizi esterni, repository
├── UI             # Controller, Livewire, API, Filament
```

**Nessun livello deve "sanguinare" nell'altro!**

### 3. Regole d'Oro della Modularità
- Ogni modulo ha uno scopo chiaro (es. Tenant, User, Billing)
- Gli internals sono nascosti: esporre solo contracts/eventi
- Dipendere da astrazioni, mai da dettagli di altri moduli
- Usare service provider per registrare servizi e binding
- Comunicare tra moduli solo tramite eventi o contracts

### 4. Shared Kernel (Nucleo condiviso)
- Solo logica davvero condivisa (es. Currency, UserRole)
- Deve essere piccolo, stabile, astratto
- Evitare di trasformarlo in un "junk drawer"

### 5. Testing
- La logica di dominio e i casi d'uso devono essere testabili in puro PHP, senza bootstrap di Laravel
- Esempio:
```php
$tenantCreator = new CreateTenant($tenantRepository);
$tenantCreator->handle($request);
```

### 6. Transizione Graduale
- Non serve riscrivere tutto: isolare un dominio alla volta
- Creare la struttura a livelli, spostare la logica, registrare provider, bindare interfacce
- Ripetere per ogni modulo

### 7. Vantaggi
- Deploy veloce, debug semplice, meno complessità
- Ogni team può "possedere" un modulo
- Pronto per evolvere verso microservizi solo se serve

### 8. Esempio di struttura modulo
```
Modules/Tenant
├── Domain
│   ├── Tenant.php
│   ├── TenantStatus.php
├── Application
│   ├── CreateTenant.php
│   ├── UpdateTenant.php
├── Infrastructure
│   ├── TenantRepository.php
├── UI
│   ├── TenantController.php
```

### 9. Comunicazione tra moduli
- **Eventi**: preferire event-driven (es. event(new TenantCreated($tenant)))
- **Contracts**: esporre solo interfacce pubbliche
- **Mai** chiamate statiche dirette tra moduli

### 10. Riferimenti e collegamenti
- [structure.md](structure.md) — Dettaglio struttura cartelle e PSR-4
- [module_tenant.md](module_tenant.md) — Dettaglio dominio Tenant
- [risoluzione_conflitti.md](risoluzione_conflitti.md) — Gestione conflitti tra moduli
- [../User/docs/structure.md](../../User/docs/structure.md) — Esempio struttura modulo User
- [../Xot/docs/structure.md](../../Xot/docs/structure.md) — Regole generali modular monolith

---

## Introduzione

Il modulo Tenant implementa un sistema di multi-tenancy seguendo l'approccio Modular Monolith, che combina i vantaggi dell'architettura modulare con la semplicità di un'applicazione monolitica.

## Architettura

### Principi Fondamentali

1. **Isolamento dei Moduli**
   - Ogni modulo è un'unità indipendente con le proprie:
     - Migrazioni
     - Modelli
     - Controller
     - Viste
     - Test
     - Configurazioni

2. **Comunicazione tra Moduli**
   - Eventi e Listener per comunicazione asincrona
   - Service Provider per registrazione dei servizi
   - Contracts per definire interfacce tra moduli

3. **Gestione delle Dipendenze**
   - Dipendenze esplicite tra moduli
   - Uso di interfacce per il disaccoppiamento
   - Iniezione delle dipendenze tramite Service Container

### Struttura del Modulo

```
Tenant/
├── Actions/           # Azioni di business logic
├── Console/          # Comandi Artisan
├── Contracts/        # Interfacce pubbliche
├── Database/         # Migrazioni e seeders
├── Events/           # Eventi del modulo
├── Exceptions/       # Eccezioni personalizzate
├── Http/             # Controller e Middleware
├── Listeners/        # Listener per gli eventi
├── Models/           # Modelli del modulo
├── Providers/        # Service Provider
├── Resources/        # Assets e viste
├── Routes/           # Definizione delle rotte
├── Services/         # Servizi del modulo
└── Tests/            # Test unitari e di integrazione
```

## Best Practices (aggiornate 2025)

### 1. Isolamento
- Ogni modulo deve essere il più possibile indipendente
- Evitare dipendenze circolari tra moduli
- Utilizzare eventi per la comunicazione tra moduli
- Definire interfacce chiare per l'interazione tra moduli
- **Non accedere mai direttamente agli internals di altri moduli**

### 2. Gestione delle Dipendenze
- Usare service provider per registrare binding e servizi
- Dipendere sempre da contracts/interfacce, mai da classi concrete di altri moduli
- Comunicare tramite eventi o contracts

### 3. Eventi e Listener
- Preferire eventi per la comunicazione asincrona tra moduli
- Ogni modulo può ascoltare eventi di altri moduli tramite listener

### 4. Contracts e Interfacce
- Esporre solo ciò che è necessario tramite contracts
- Nascondere la logica interna del modulo

### 5. Shared Kernel
- Mantenere il kernel condiviso piccolo e stabile
- Usare solo per costanti, enum, value object comuni

### 6. Testing
- Testare la logica di dominio e i casi d'uso in puro PHP
- Usare test di integrazione per la comunicazione tra moduli

### 7. Transizione e Manutenzione
- Migrare gradualmente verso la struttura a livelli
- Documentare ogni passaggio e aggiornamento

---

## Integrazione con Altri Moduli

### 1. Service Provider

```php
class TenantServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registrazione dei servizi
    }

    public function boot()
    {
        // Caricamento delle configurazioni
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }
}
```

### 2. Eventi tra Moduli

```php
// Nel modulo Tenant
event(new TenantCreated($tenant));

// Nel modulo User
Event::listen(TenantCreated::class, function ($event) {
    // Gestione della creazione del tenant
});
```

## Testing

### 1. Test Unitari

```php
class TenantTest extends TestCase
{
    public function test_can_create_tenant()
    {
        $tenant = Tenant::factory()->create();
        $this->assertInstanceOf(Tenant::class, $tenant);
    }
}
```

### 2. Test di Integrazione

```php
class TenantIntegrationTest extends TestCase
{
    public function test_tenant_creation_triggers_events()
    {
        Event::fake();
        
        $tenant = Tenant::factory()->create();
        
        Event::assertDispatched(TenantCreated::class);
    }
}
```

## Deployment

### 1. Migrazioni

- Le migrazioni sono caricate automaticamente dal Service Provider
- Utilizzare il comando `php artisan migrate` per applicare le migrazioni

### 2. Configurazione

```php
// config/tenant.php
return [
    'default' => env('TENANT_CONNECTION', 'tenant'),
    'connections' => [
        'tenant' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
        ],
    ],
];
```

## Manutenzione

### 1. Aggiornamenti

- Mantenere le dipendenze aggiornate
- Testare gli aggiornamenti in ambiente di sviluppo
- Documentare le modifiche breaking

### 2. Debugging

- Utilizzare il logging per tracciare le operazioni
- Implementare monitoraggio delle performance
- Gestire correttamente le eccezioni

## Collegamenti Correlati

- [Struttura del Modulo](structure.md)
- [Gestione dei Pacchetti](packages.md)
- [Risoluzione dei Conflitti](risoluzione_conflitti.md)
- [Roadmap](roadmap.md)
- [Documentazione Filament](filament_resources.md)

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

## Collegamenti sulla risoluzione dei conflitti

- [Risoluzione conflitti nel modulo Tenant](risoluzione_conflitti.md)
- [Linee guida globali per la risoluzione dei conflitti git](../../../docs/risoluzione_conflitti_git.md)

