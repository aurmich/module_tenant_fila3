# Implementazione Core SaluteOra

## Panoramica
L'implementazione core di SaluteOra è basata sui moduli Laraxot e fornisce la base per tutte le funzionalità del sistema.

## Moduli Base

### XOT Core
- **Installazione**: `git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash`
- **Configurazione**: `php artisan vendor:publish --tag=xot-config`
- **Dipendenze**: Laravel 11.x, PHP 8.2+, Filament 3.x
- **Namespace**: `Modules\Xot`

### Multi-tenant
- **Installazione**: `git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev --squash`
- **Configurazione**: `php artisan vendor:publish --tag=tenant-config`
- **Dipendenze**: XOT Core
- **Namespace**: `Modules\Tenant`

### Autenticazione
- **Installazione**: `git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev --squash`
- **Configurazione**: `php artisan vendor:publish --tag=user-config`
- **Dipendenze**: XOT Core, Tenant
- **Namespace**: `Modules\User`

### Multilanguage
- **Installazione**: `git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev --squash`
- **Configurazione**: `php artisan vendor:publish --tag=lang-config`
- **Dipendenze**: XOT Core
- **Namespace**: `Modules\Lang`

## Architettura

### Layers
```
┌───────────────┐
│  Applicazione │ Moduli specifici (Patient, Dental, etc.)
├───────────────┤
│  Framework    │ Laravel + Filament
├───────────────┤
│  Core Modules │ XOT, Tenant, User, Lang
├───────────────┤
│  Database     │ MySQL / PostgreSQL
└───────────────┘
```

### Flusso Dati
```
Request → Middleware → Controller → Service → Repository → Model → Database
   ↑                                                            │
   └────────────────────────────────────────────────────────────┘
```

### Componenti Core

#### Models
```php
// Esempio di model tenant-aware
namespace Modules\Patient\Models;

use Modules\Xot\Models\BaseModel;
use Modules\Tenant\Traits\BelongsToTenant;

class Patient extends BaseModel {
    use BelongsToTenant;
    
    protected $fillable = ['name', 'surname', 'email', 'phone', 'isee_value'];
}
```

#### Controllers
```php
// Esempio di controller resource
namespace Modules\Patient\Http\Controllers;

use Modules\Xot\Http\Controllers\BaseController;
use Modules\Patient\Models\Patient;

class PatientController extends BaseController {
    public function index() {
        // Già filtrato per tenant
        $patients = Patient::paginate(15);
        return view('patient::index', compact('patients'));
    }
}
```

#### Middleware
```php
// Esempio di middleware tenant
namespace Modules\Tenant\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Tenant\Services\TenantManager;

class IdentifyTenant {
    public function handle(Request $request, Closure $next) {
        app(TenantManager::class)->identifyTenant();
        return $next($request);
    }
}
```

## Configurazione

### Multi-tenant
```php
// config/tenant.php
return [
    'middleware_group' => ['web', 'auth'],
    'tenant_model' => \Modules\Tenant\Models\Tenant::class,
    'user_model' => \Modules\User\Models\User::class,
    'domain_identification' => true,
    'subdomain_format' => '{tenant}.saluteora.it',
    'path_identification' => false,
    'path_parameter' => 'tenant',
];
```

### Autenticazione
```php
// config/auth.php
return [
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'tenant' => [
            'driver' => 'session',
            'provider' => 'tenant_users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \Modules\User\Models\User::class,
        ],
        'tenant_users' => [
            'driver' => 'eloquent',
            'model' => \Modules\User\Models\TenantUser::class,
        ],
    ],
];
```

## Database

### Tabelle Core
- `tenants`: Configurazione multi-tenant
- `users`: Utenti di sistema
- `tenant_users`: Utenti per tenant
- `permissions`: Permessi
- `roles`: Ruoli
- `model_has_roles`: Pivot ruoli-modelli
- `model_has_permissions`: Pivot permessi-modelli
- `role_has_permissions`: Pivot ruoli-permessi
- `audit_logs`: Log di attività

### Schema Tenant
```
┌─────────────┐       ┌───────────┐       ┌───────────────┐
│   tenants   │   1:n │   users   │   n:n │     roles     │
├─────────────┤       ├───────────┤       ├───────────────┤
│ id          │       │ id        │       │ id            │
│ name        │       │ name      │       │ name          │
│ domain      │◄──┐   │ email     │       │ guard_name    │
│ settings    │   │   │ password  │◄─┐    │ tenant_id     │
└─────────────┘   │   └───────────┘  │    └───────────────┘
                  │                  │            │
                  │   ┌────────────┐ │            │
                  └───┤tenant_users├─┘            │
                      ├────────────┤              │
                      │tenant_id   │              │
                      │user_id     │              ▼
                      └────────────┘     ┌───────────────┐
                                         │  permissions  │
                                         ├───────────────┤
                                         │ id            │
                                         │ name          │
                                         │ guard_name    │
                                         │ tenant_id     │
                                         └───────────────┘
```

## Performance

### Ottimizzazioni
- Query scoping automatico per tenant
- Cache configurabile per tenant
- Lazy loading relazioni
- Eager loading quando necessario
- Index sulle colonne tenant_id

### Metriche
- Response time < 200ms
- Query time < 50ms
- Cache hit ratio > 80%
- Memory usage < 128MB

## Sicurezza

### Misure Implementate
- Autenticazione multi-fattore per admin
- Isolamento dati tra tenant
- Autorizzazione granulare
- Audit logging automatico
- Token-based API authentication
- Rate limiting per tenant
- CORS configurabile
- Cookie secure e HttpOnly

### Struttura Permessi
```
┌─ Tenant ─┐
│  ├─ Admin
│  │  └─ [All Permissions]
│  ├─ Manager
│  │  ├─ patients.*
│  │  ├─ appointments.*
│  │  └─ reports.view
│  ├─ Doctor
│  │  ├─ patients.view
│  │  ├─ patients.edit
│  │  ├─ appointments.view
│  │  ├─ appointments.create
│  │  └─ appointments.edit
│  └─ Assistant
│     ├─ patients.view
│     ├─ appointments.view
│     └─ appointments.create
└─────────┘
``` 