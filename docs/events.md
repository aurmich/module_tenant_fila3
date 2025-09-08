# Gestione degli Eventi nel Modulo Tenant

## Introduzione

La gestione degli eventi è un aspetto cruciale nell'architettura Modular Monolith. Questo documento descrive come implementare e gestire gli eventi nel modulo Tenant in modo efficace e mantenibile.

## Architettura degli Eventi

### 1. Struttura Base

```
Events/
├── TenantCreated.php
├── TenantUpdated.php
├── TenantDeleted.php
└── TenantSuspended.php

Listeners/
├── HandleTenantCreated.php
├── HandleTenantUpdated.php
├── HandleTenantDeleted.php
└── HandleTenantSuspended.php
```

### 2. Definizione degli Eventi

```php
namespace Modules\Tenant\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Tenant\Models\Tenant;

class TenantCreated
{
    use SerializesModels;

    public function __construct(
        public Tenant $tenant
    ) {
    }
}
```

### 3. Implementazione dei Listener

```php
namespace Modules\Tenant\Listeners;

use Modules\Tenant\Events\TenantCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleTenantCreated implements ShouldQueue
{
    public function handle(TenantCreated $event): void
    {
        // Logica di gestione
        $tenant = $event->tenant;
        
        // Esempio: Creazione del database del tenant
        $this->createTenantDatabase($tenant);
        
        // Esempio: Invio email di benvenuto
        $this->sendWelcomeEmail($tenant);
    }

    private function createTenantDatabase(Tenant $tenant): void
    {
        // Implementazione
    }

    private function sendWelcomeEmail(Tenant $tenant): void
    {
        // Implementazione
    }
}
```

## Best Practices

### 1. Naming Convention

- Eventi: `{Entity}{Action}` (es. `TenantCreated`)
- Listener: `Handle{Entity}{Action}` (es. `HandleTenantCreated`)

### 2. Registrazione degli Eventi

```php
namespace Modules\Tenant\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Tenant\Events\TenantCreated' => [
            'Modules\Tenant\Listeners\HandleTenantCreated',
        ],
        'Modules\Tenant\Events\TenantUpdated' => [
            'Modules\Tenant\Listeners\HandleTenantUpdated',
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
```

### 3. Eventi tra Moduli

```php
// Nel modulo Tenant
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
        // Creazione utente admin per il tenant
        User::create([
            'tenant_id' => $event->tenant->id,
            'role' => 'admin',
            // ...
        ]);
    }
}
```

## Gestione delle Code

### 1. Configurazione delle Code

```php
// config/queue.php
return [
    'connections' => [
        'tenant' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'tenant',
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],
];
```

### 2. Listener in Coda

```php
namespace Modules\Tenant\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleTenantCreated implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'tenant';
    public $tries = 3;
    public $timeout = 60;

    public function handle(TenantCreated $event): void
    {
        // Implementazione
    }

    public function failed(TenantCreated $event, \Throwable $exception): void
    {
        // Gestione del fallimento
    }
}
```

## Testing degli Eventi

### 1. Test Unitari

```php
namespace Modules\Tenant\Tests\Unit;

use Tests\TestCase;
use Modules\Tenant\Events\TenantCreated;
use Modules\Tenant\Models\Tenant;

class TenantEventTest extends TestCase
{
    public function test_tenant_created_event()
    {
        $tenant = Tenant::factory()->create();
        $event = new TenantCreated($tenant);

        $this->assertInstanceOf(Tenant::class, $event->tenant);
        $this->assertEquals($tenant->id, $event->tenant->id);
    }
}
```

### 2. Test di Integrazione

```php
namespace Modules\Tenant\Tests\Integration;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Modules\Tenant\Events\TenantCreated;

class TenantEventIntegrationTest extends TestCase
{
    public function test_tenant_creation_dispatches_event()
    {
        Event::fake();

        $tenant = Tenant::factory()->create();

        Event::assertDispatched(TenantCreated::class, function ($event) use ($tenant) {
            return $event->tenant->id === $tenant->id;
        });
    }
}
```

## Monitoraggio e Debugging

### 1. Logging degli Eventi

```php
namespace Modules\Tenant\Listeners;

use Illuminate\Support\Facades\Log;

class HandleTenantCreated
{
    public function handle(TenantCreated $event): void
    {
        Log::info('Tenant created', [
            'tenant_id' => $event->tenant->id,
            'timestamp' => now(),
        ]);

        // Implementazione
    }
}
```

### 2. Tracciamento delle Performance

```php
namespace Modules\Tenant\Listeners;

use Illuminate\Support\Facades\Log;

class HandleTenantCreated
{
    public function handle(TenantCreated $event): void
    {
        $start = microtime(true);

        // Implementazione

        $duration = microtime(true) - $start;
        Log::info('Tenant creation completed', [
            'duration' => $duration,
            'tenant_id' => $event->tenant->id,
        ]);
    }
}
```

## Sicurezza

### 1. Validazione dei Dati

```php
namespace Modules\Tenant\Events;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;

class TenantCreated implements ValidatesWhenResolved
{
    public function rules(): array
    {
        return [
            'tenant.id' => 'required|integer',
            'tenant.name' => 'required|string|max:255',
        ];
    }
}
```

### 2. Autorizzazione

```php
namespace Modules\Tenant\Listeners;

use Illuminate\Auth\Access\AuthorizationException;

class HandleTenantCreated
{
    public function handle(TenantCreated $event): void
    {
        if (!auth()->user()->can('manage_tenant', $event->tenant)) {
            throw new AuthorizationException('Non autorizzato a gestire questo tenant');
        }

        // Implementazione
    }
}
```

## Collegamenti Correlati

- [Struttura del Modulo](structure.md)
- [Best Practices](README.md#best-practices)
- [Documentazione Laravel Events](https://laravel.com/docs/events) 
