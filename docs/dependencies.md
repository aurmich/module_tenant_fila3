# Gestione delle Dipendenze nel Modulo Tenant

## Introduzione

La gestione delle dipendenze è un aspetto fondamentale nell'architettura Modular Monolith. Questo documento descrive come gestire efficacemente le dipendenze nel modulo Tenant, mantenendo un'architettura pulita e manutenibile.

## Service Provider

### 1. Struttura Base

```php
namespace Modules\Tenant\Providers;

use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->registerCommands();
        $this->registerBindings();
    }

    public function boot(): void
    {
        $this->loadMigrations();
        $this->loadRoutes();
        $this->loadViews();
        $this->loadTranslations();
    }

    private function registerConfig(): void
    {
        $this->publishes([
            __DIR__.'/../Config/tenant.php' => config_path('tenant.php'),
        ], 'config');
        
        $this->mergeConfigFrom(
            __DIR__.'/../Config/tenant.php', 'tenant'
        );
    }

    private function registerCommands(): void
    {
        $this->commands([
            Commands\CreateTenant::class,
            Commands\DeleteTenant::class,
        ]);
    }

    private function registerBindings(): void
    {
        $this->app->bind(
            TenantRepositoryInterface::class,
            TenantRepository::class
        );

        $this->app->bind(
            TenantServiceInterface::class,
            TenantService::class
        );
    }
}
```

### 2. Registrazione delle Dipendenze

```php
namespace Modules\Tenant\Providers;

use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    protected $bindings = [
        // Repository
        TenantRepositoryInterface::class => TenantRepository::class,
        
        // Services
        TenantServiceInterface::class => TenantService::class,
        
        // Actions
        CreateTenantActionInterface::class => CreateTenantAction::class,
        UpdateTenantActionInterface::class => UpdateTenantAction::class,
    ];

    public function register(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
```

## Contracts e Interfacce

### 1. Definizione delle Interfacce

```php
namespace Modules\Tenant\Contracts;

interface TenantRepositoryInterface
{
    public function findById(int $id): ?Tenant;
    public function create(array $data): Tenant;
    public function update(Tenant $tenant, array $data): bool;
    public function delete(Tenant $tenant): bool;
}

interface TenantServiceInterface
{
    public function createTenant(array $data): Tenant;
    public function updateTenant(Tenant $tenant, array $data): bool;
    public function deleteTenant(Tenant $tenant): bool;
}
```

### 2. Implementazione delle Interfacce

```php
namespace Modules\Tenant\Repositories;

use Modules\Tenant\Contracts\TenantRepositoryInterface;
use Modules\Tenant\Models\Tenant;

class TenantRepository implements TenantRepositoryInterface
{
    public function findById(int $id): ?Tenant
    {
        return Tenant::find($id);
    }

    public function create(array $data): Tenant
    {
        return Tenant::create($data);
    }

    public function update(Tenant $tenant, array $data): bool
    {
        return $tenant->update($data);
    }

    public function delete(Tenant $tenant): bool
    {
        return $tenant->delete();
    }
}
```

## Gestione delle Dipendenze tra Moduli

### 1. Comunicazione tra Moduli

```php
namespace Modules\Tenant\Services;

use Modules\User\Contracts\UserServiceInterface;

class TenantService
{
    public function __construct(
        private UserServiceInterface $userService
    ) {
    }

    public function createTenant(array $data): Tenant
    {
        $tenant = $this->repository->create($data);
        
        // Creazione utente admin per il tenant
        $this->userService->createAdminUser($tenant);
        
        return $tenant;
    }
}
```

### 2. Eventi tra Moduli

```php
namespace Modules\Tenant\Events;

class TenantCreated
{
    public function __construct(
        public Tenant $tenant,
        public array $metadata = []
    ) {
    }
}

// Nel modulo User
namespace Modules\User\Listeners;

class HandleTenantCreated
{
    public function handle(TenantCreated $event): void
    {
        // Creazione utente admin
    }
}
```

## Iniezione delle Dipendenze

### 1. Controller

```php
namespace Modules\Tenant\Http\Controllers;

use Modules\Tenant\Contracts\TenantServiceInterface;

class TenantController extends Controller
{
    public function __construct(
        private TenantServiceInterface $tenantService
    ) {
    }

    public function store(Request $request)
    {
        $tenant = $this->tenantService->createTenant($request->validated());
        
        return response()->json($tenant);
    }
}
```

### 2. Actions

```php
namespace Modules\Tenant\Actions;

use Modules\Tenant\Contracts\TenantRepositoryInterface;

class CreateTenantAction
{
    public function __construct(
        private TenantRepositoryInterface $repository
    ) {
    }

    public function execute(array $data): Tenant
    {
        return $this->repository->create($data);
    }
}
```

## Testing delle Dipendenze

### 1. Mocking delle Dipendenze

```php
namespace Modules\Tenant\Tests\Unit;

use Tests\TestCase;
use Mockery;
use Modules\Tenant\Contracts\TenantRepositoryInterface;

class TenantServiceTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->repository = Mockery::mock(TenantRepositoryInterface::class);
    }

    public function test_can_create_tenant()
    {
        $this->repository->shouldReceive('create')
            ->once()
            ->andReturn(new Tenant());

        $service = new TenantService($this->repository);
        $result = $service->createTenant(['name' => 'Test']);

        $this->assertInstanceOf(Tenant::class, $result);
    }
}
```

### 2. Test di Integrazione

```php
namespace Modules\Tenant\Tests\Integration;

use Tests\TestCase;
use Modules\Tenant\Contracts\TenantServiceInterface;

class TenantIntegrationTest extends TestCase
{
    public function test_tenant_creation_workflow()
    {
        $service = app(TenantServiceInterface::class);
        
        $tenant = $service->createTenant([
            'name' => 'Test Tenant',
            'domain' => 'test.example.com'
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Test Tenant'
        ]);
    }
}
```

## Best Practices

### 1. Principi SOLID

- **Single Responsibility**: Ogni classe ha una sola responsabilità
- **Open/Closed**: Le classi sono aperte per estensione, chiuse per modifica
- **Liskov Substitution**: Le implementazioni sono intercambiabili
- **Interface Segregation**: Interfacce piccole e specifiche
- **Dependency Inversion**: Dipendere da astrazioni, non da implementazioni

### 2. Gestione delle Configurazioni

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

### 3. Gestione delle Eccezioni

```php
namespace Modules\Tenant\Exceptions;

class TenantException extends \Exception
{
    public static function notFound(int $id): self
    {
        return new self("Tenant non trovato: {$id}");
    }

    public static function invalidData(string $message): self
    {
        return new self("Dati tenant non validi: {$message}");
    }
}
```

## Collegamenti Correlati

- [Struttura del Modulo](structure.md)
- [Best Practices](README.md#best-practices)
- [Documentazione Laravel Service Container](https://laravel.com/docs/container) 
