# Struttura Standard Moduli SaluteOra

## Directory Structure
```
ModuleName/
├── Config/          # Configurazioni del modulo
│   ├── config.php   # Configurazione principale
│   └── permissions.php # Permessi del modulo
├── Console/         # Comandi Artisan
│   └── Commands/    # Comandi personalizzati
├── Database/        # Migrazioni e seeders
│   ├── Migrations/  # Migrazioni database
│   └── Seeders/    # Seeder per dati di test
├── Entities/        # Modelli e relazioni
│   ├── Models/     # Modelli Eloquent
│   └── Traits/     # Traits riutilizzabili
├── Http/           # Controllers e middleware
│   ├── Controllers/ # Controllers
│   ├── Requests/   # Form requests
│   ├── Resources/  # API resources
│   └── Middleware/ # Middleware
├── Providers/      # Service providers
│   └── ModuleServiceProvider.php
├── Resources/      # Views, assets e traduzioni
│   ├── views/     # Blade views
│   ├── js/        # JavaScript
│   ├── css/       # Stili
│   └── lang/      # Traduzioni
├── Routes/         # Definizione rotte
│   ├── api.php    # API routes
│   └── web.php    # Web routes
├── Services/       # Logica di business
│   └── Contracts/ # Interfaces
└── Tests/          # Test unitari e feature
    ├── Unit/      # Test unitari
    └── Feature/   # Test funzionali
```

## File Principali

### Config/config.php
```php
return [
    'name' => 'ModuleName',
    'version' => '1.0.0',
    'providers' => [
        ModuleServiceProvider::class,
    ],
    'aliases' => [
        'ModuleName' => ModuleNameFacade::class,
    ],
];
```

### Providers/ModuleServiceProvider.php
```php
class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutes();
        $this->loadViews();
        $this->loadMigrations();
        $this->loadTranslations();
    }
}
```

### Routes/web.php
```php
Route::group([
    'prefix' => 'module-name',
    'middleware' => ['web', 'auth'],
], function () {
    // Routes
});
```

## Convenzioni

### Naming
- Classi: PascalCase
- Metodi: camelCase
- Variabili: camelCase
- Costanti: UPPER_CASE
- File: kebab-case

### Namespace
```php
namespace Modules\ModuleName;
```

### Service Provider
- Registrare in `config/app.php`
- Caricare assets in `boot()`
- Registrare routes in `map()`

### Views
- Usare componenti Blade
- Organizzare in sottocartelle
- Seguire BEM per CSS
- Usare traduzioni

### Testing
- Test per ogni feature
- Test per ogni model
- Test per ogni service
- Coverage minimo 80% 