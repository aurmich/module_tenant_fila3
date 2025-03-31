# Modulo Xot

## Installazione

### Requisiti
- Laravel 10.x
- PHP 8.2 o superiore
- Composer

### Installazione via Git Subtree
```bash
# Aggiungere il repository remoto
git remote add -f xot https://github.com/crud-lab/xot.git

# Aggiungere il modulo come subtree
git subtree add --prefix Modules/Xot xot main --squash
```

## Configurazione

### Registrazione del Service Provider
Aggiungere il service provider in `config/app.php`:

```php
'providers' => [
    // ...
    Modules\Xot\Providers\XotServiceProvider::class,
],
```

### Pubblicazione delle Risorse
```bash
php artisan vendor:publish --provider="Modules\Xot\Providers\XotServiceProvider"
```

## Struttura del Modulo

### Directory Principali
```
Modules/Xot/
├── Config/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Models/
├── Providers/
├── Resources/
│   ├── assets/
│   ├── lang/
│   └── views/
├── Routes/
└── Services/
```

### Componenti Principali

#### Models
- `XotModel`: Model base con funzionalità comuni
- `XotUser`: Gestione utenti
- `XotProfile`: Profili utente

#### Controllers
- `XotController`: Controller base con funzionalità CRUD
- `XotAuthController`: Gestione autenticazione
- `XotProfileController`: Gestione profili

#### Services
- `XotService`: Servizi comuni
- `XotAuthService`: Servizi di autenticazione
- `XotProfileService`: Servizi per i profili

## Utilizzo

### Estensione dei Models
```php
use Modules\Xot\Models\XotModel;

class Patient extends XotModel
{
    protected $table = 'patients';
    
    // Aggiungere relazioni e metodi specifici
}
```

### Utilizzo dei Controllers
```php
use Modules\Xot\Http\Controllers\XotController;

class PatientController extends XotController
{
    protected $model = Patient::class;
    
    // Aggiungere metodi specifici
}
```

### Utilizzo dei Services
```php
use Modules\Xot\Services\XotService;

class PatientService extends XotService
{
    public function __construct()
    {
        parent::__construct(Patient::class);
    }
    
    // Aggiungere metodi specifici
}
```

## Funzionalità Principali

### Gestione Utenti
- Registrazione
- Login/Logout
- Recupero password
- Verifica email

### Gestione Profili
- Creazione profilo
- Modifica profilo
- Upload avatar
- Preferenze utente

### CRUD Base
- Lista record
- Creazione record
- Modifica record
- Eliminazione record
- Filtri e ricerca

### API
- Endpoint RESTful
- Autenticazione API
- Rate limiting
- Validazione richieste

## Personalizzazione

### Temi
```php
// Configurazione tema
config('xot.theme', 'default');

// Utilizzo tema nelle view
@include('xot::themes.default.layouts.app')
```

### Lingue
```php
// Aggiungere traduzioni
__('xot::messages.welcome');

// Personalizzare messaggi
return [
    'welcome' => 'Benvenuto in SaluteOra',
];
```

### Middleware
```php
// Registrazione middleware
Route::middleware(['xot.auth', 'xot.profile'])->group(function () {
    // Route protette
});
```

## Note
- Il modulo fornisce una base solida per lo sviluppo
- Personalizzare le funzionalità secondo le necessità
- Mantenere la compatibilità con le versioni future
- Documentare le personalizzazioni
- Testare le modifiche 