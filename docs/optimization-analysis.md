# Analisi di Ottimizzazione - Modulo Tenant

## 🎯 Principi Applicati: DRY + KISS + SOLID + ROBUST + Laraxot

### 📊 Stato Attuale del Modulo

Il modulo Tenant gestisce la **multi-tenancy** del sistema , fornendo:
- **Isolamento Dati** tra studi medici diversi
- **Database Separation** per tenant
- **Domain-based Routing** per accesso tenant-specific
- **Configuration Management** per tenant
- **User Association** con tenant specifici

---

## 🚨 Problemi Critici Identificati

### 1. **VIOLAZIONE ROBUSTNESS - File .no e Codice Commentato**

#### Problema: File Duplicati e Codice Morto
```php
// ❌ PROBLEMATICO - File duplicati con estensione .no
// Tenant.php.no, tenant.php.no - confusione e manutenzione difficile

// ❌ PROBLEMATICO - Codice commentato nel modello
class Tenant extends BaseModel
{
    /*
     * Verifica se il tenant è attivo.
     *
     * @return bool
     
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
        */
}
```

**✅ Soluzione ROBUST + KISS:**
```php
// Rimuovere file .no e implementare metodi necessari
class Tenant extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name', 'domain', 'database', 'slug', 'settings', 'is_active',
        'logo', 'email', 'phone', 'address', 'city', 'postal_code',
        'province', 'country', 'tax_code', 'vat_number',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'settings' => 'array',
            'is_active' => 'boolean',
        ]);
    }

    /**
     * Verifica se il tenant è attivo.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Genera lo slug dal nome se non fornito.
     */
    protected function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;

        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Restituisce l'URL del tenant.
     */
    public function getUrlAttribute(): string
    {
        if ($this->domain) {
            return "https://{$this->domain}";
        }
        
        return config('app.url') . "/{$this->slug}";
    }
}
```

### 2. **VIOLAZIONE SOLID - TenantServiceProvider Fa Troppo**

#### Problema: Service Provider con Responsabilità Miste
```php
// ❌ PROBLEMATICO - Responsabilità mescolate
class TenantServiceProvider extends XotBaseServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        
        $this->mergeConfigs();      // Configuration
        $this->registerDB();        // Database  
        $this->registerMorphMap();  // Eloquent
        $this->publishConfig();     // Publishing
    }
    
    public function registerDB(): void
    {
        // Logica complessa per database
        if (Request::has('act') && Request::input('act') === 'migrate') {
            DB::purge('mysql');
            DB::reconnect('mysql');
        }
        DB::reconnect();
        Schema::defaultStringLength(191);
    }
}
```

**✅ Soluzione SOLID (Single Responsibility):**
```php
// Service Provider semplificato
class TenantServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Tenant';
    
    public function boot(): void
    {
        parent::boot();
        
        $this->bootTenantServices();
    }
    
    public function register(): void
    {
        parent::register();
        
        $this->registerTenantServices();
    }
    
    private function bootTenantServices(): void
    {
        app(TenantConfigurationBootstrap::class)->boot();
        app(TenantDatabaseBootstrap::class)->boot();
        app(TenantMorphMapBootstrap::class)->boot();
    }
    
    private function registerTenantServices(): void
    {
        $this->app->singleton(TenantManager::class);
        $this->app->singleton(TenantResolver::class);
        $this->app->singleton(TenantDatabaseManager::class);
        $this->app->singleton(TenantConfigurationManager::class);
    }
}

// Classi separate per ogni responsabilità
class TenantDatabaseBootstrap
{
    public function boot(): void
    {
        if (app()->environment('testing')) {
            Schema::defaultStringLength(191);
            return;
        }
        
        $this->configureDatabaseConnections();
        $this->handleMigrationRequests();
    }
    
    private function configureDatabaseConnections(): void
    {
        Schema::defaultStringLength(191);
        
        // Configurazione connessioni tenant-specific
        $tenantConnections = config('tenant.database.connections', []);
        foreach ($tenantConnections as $name => $config) {
            config(["database.connections.{$name}" => $config]);
        }
    }
    
    private function handleMigrationRequests(): void
    {
        if (request()->has('act') && request()->input('act') === 'migrate') {
            DB::purge('mysql');
            DB::reconnect('mysql');
        }
    }
}

class TenantMorphMapBootstrap
{
    public function boot(): void
    {
        $morphMap = config('tenant.morph_map', []);
        
        if (!empty($morphMap)) {
            Relation::morphMap($morphMap);
        }
    }
}
```

### 3. **VIOLAZIONE DRY - Configurazione Tenant Ripetuta**

#### Problema: Configurazione Hardcoded in Più Posti
```php
// ❌ PROBLEMATICO - Configurazione ripetuta
// Nel TenantService
public static function config(string $key): mixed
{
    return config("tenant.{$key}");
}

// Nel ServiceProvider
$this->mergeConfigs();

// In altri file
config('tenant.database.connections');
config('tenant.morph_map');
```

**✅ Soluzione DRY + Configuration Manager:**
```php
class TenantConfigurationManager
{
    private array $config;
    private array $cache = [];
    
    public function __construct()
    {
        $this->config = config('tenant', []);
    }
    
    public function get(string $key, mixed $default = null): mixed
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
        
        $value = data_get($this->config, $key, $default);
        $this->cache[$key] = $value;
        
        return $value;
    }
    
    public function set(string $key, mixed $value): void
    {
        data_set($this->config, $key, $value);
        unset($this->cache[$key]);
    }
    
    public function getDatabaseConnections(): array
    {
        return $this->get('database.connections', []);
    }
    
    public function getMorphMap(): array
    {
        return $this->get('morph_map', []);
    }
    
    public function getDefaultConnection(): string
    {
        return $this->get('database.default', 'mysql');
    }
    
    public function getTenantConnectionTemplate(): array
    {
        return $this->get('database.tenant_template', [
            'driver' => 'mysql',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);
    }
}
```

---

## ⚡ Ottimizzazioni Performance

### 1. **Tenant Resolution Caching**

```php
class TenantResolver
{
    private ?Tenant $currentTenant = null;
    private array $tenantCache = [];
    
    public function resolveFromDomain(string $domain): ?Tenant
    {
        if (isset($this->tenantCache[$domain])) {
            return $this->tenantCache[$domain];
        }
        
        $tenant = Cache::remember(
            "tenant_domain_{$domain}",
            3600,
            fn() => Tenant::where('domain', $domain)->where('is_active', true)->first()
        );
        
        $this->tenantCache[$domain] = $tenant;
        return $tenant;
    }
    
    public function resolveFromSlug(string $slug): ?Tenant
    {
        if (isset($this->tenantCache[$slug])) {
            return $this->tenantCache[$slug];
        }
        
        $tenant = Cache::remember(
            "tenant_slug_{$slug}",
            3600,
            fn() => Tenant::where('slug', $slug)->where('is_active', true)->first()
        );
        
        $this->tenantCache[$slug] = $tenant;
        return $tenant;
    }
    
    public function getCurrentTenant(): ?Tenant
    {
        if ($this->currentTenant !== null) {
            return $this->currentTenant;
        }
        
        // Risoluzione dal dominio corrente
        $domain = request()->getHost();
        $this->currentTenant = $this->resolveFromDomain($domain);
        
        // Fallback su slug da URL
        if (!$this->currentTenant) {
            $slug = request()->segment(1);
            if ($slug) {
                $this->currentTenant = $this->resolveFromSlug($slug);
            }
        }
        
        return $this->currentTenant;
    }
    
    public function setCurrentTenant(?Tenant $tenant): void
    {
        $this->currentTenant = $tenant;
        
        if ($tenant) {
            // Set database connection per il tenant
            app(TenantDatabaseManager::class)->switchToTenant($tenant);
        }
    }
}
```

### 2. **Database Connection Management**

```php
class TenantDatabaseManager
{
    private array $connections = [];
    
    public function __construct(
        private TenantConfigurationManager $config
    ) {}
    
    public function switchToTenant(Tenant $tenant): void
    {
        $connectionName = $this->getTenantConnectionName($tenant);
        
        if (!isset($this->connections[$connectionName])) {
            $this->createTenantConnection($tenant, $connectionName);
        }
        
        // Set default database connection
        config(['database.default' => $connectionName]);
        DB::purge('mysql');
        DB::reconnect();
    }
    
    private function createTenantConnection(Tenant $tenant, string $connectionName): void
    {
        $template = $this->config->getTenantConnectionTemplate();
        
        $connection = array_merge($template, [
            'database' => $tenant->database ?: "tenant_{$tenant->id}",
            'host' => $tenant->database_host ?: config('database.connections.mysql.host'),
            'username' => $tenant->database_username ?: config('database.connections.mysql.username'),
            'password' => $tenant->database_password ?: config('database.connections.mysql.password'),
        ]);
        
        config(["database.connections.{$connectionName}" => $connection]);
        $this->connections[$connectionName] = $connection;
    }
    
    private function getTenantConnectionName(Tenant $tenant): string
    {
        return "tenant_{$tenant->id}";
    }
    
    public function createTenantDatabase(Tenant $tenant): bool
    {
        $databaseName = $tenant->database ?: "tenant_{$tenant->id}";
        
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // Update tenant record
            $tenant->update(['database' => $databaseName]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to create tenant database', [
                'tenant_id' => $tenant->id,
                'database' => $databaseName,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }
}
```

### 3. **Middleware per Tenant Context**

```php
class ResolveTenantMiddleware
{
    public function __construct(
        private TenantResolver $resolver
    ) {}
    
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $this->resolver->getCurrentTenant();
        
        if (!$tenant) {
            // Redirect to tenant selection or 404
            return $this->handleMissingTenant($request);
        }
        
        if (!$tenant->isActive()) {
            return $this->handleInactiveTenant($tenant);
        }
        
        // Set tenant context
        $this->resolver->setCurrentTenant($tenant);
        
        // Add tenant to view data
        view()->share('currentTenant', $tenant);
        
        return $next($request);
    }
    
    private function handleMissingTenant(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Tenant not found'], 404);
        }
        
        return redirect()->route('tenant.select');
    }
    
    private function handleInactiveTenant(Tenant $tenant): Response
    {
        Log::warning('Access attempt to inactive tenant', [
            'tenant_id' => $tenant->id,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        return response()->view('tenant::inactive', compact('tenant'), 503);
    }
}
```

---

## 🔒 Miglioramenti Sicurezza

### 1. **Tenant Isolation Security**

```php
trait EnforcesTenantIsolation
{
    protected static function bootEnforcesTenantIsolation(): void
    {
        // Automatically scope queries to current tenant
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenant = app(TenantResolver::class)->getCurrentTenant();
            
            if ($tenant && Schema::hasColumn($builder->getModel()->getTable(), 'tenant_id')) {
                $builder->where('tenant_id', $tenant->id);
            }
        });
        
        // Auto-assign tenant on creation
        static::creating(function ($model) {
            $tenant = app(TenantResolver::class)->getCurrentTenant();
            
            if ($tenant && Schema::hasColumn($model->getTable(), 'tenant_id')) {
                $model->tenant_id = $tenant->id;
            }
        });
    }
    
    public function scopeForTenant(Builder $query, Tenant $tenant): Builder
    {
        return $query->where('tenant_id', $tenant->id);
    }
    
    public function scopeWithoutTenantScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
}
```

### 2. **Cross-Tenant Access Prevention**

```php
class TenantAccessPolicy
{
    public function __construct(
        private TenantResolver $resolver
    ) {}
    
    public function canAccess(User $user, Model $model): bool
    {
        $currentTenant = $this->resolver->getCurrentTenant();
        
        if (!$currentTenant) {
            return false;
        }
        
        // Verifica che l'utente appartenga al tenant
        if (!$user->belongsToTenant($currentTenant)) {
            return false;
        }
        
        // Verifica che il modello appartenga al tenant
        if ($this->hasTenantId($model) && $model->tenant_id !== $currentTenant->id) {
            return false;
        }
        
        return true;
    }
    
    private function hasTenantId(Model $model): bool
    {
        return Schema::hasColumn($model->getTable(), 'tenant_id');
    }
}
```

### 3. **Audit Trail per Tenant**

```php
class TenantAuditLogger
{
    public function logTenantAccess(Tenant $tenant, User $user): void
    {
        activity('tenant_access')
            ->causedBy($user)
            ->performedOn($tenant)
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'timestamp' => now(),
            ])
            ->log('User accessed tenant');
    }
    
    public function logTenantSwitch(Tenant $from, Tenant $to, User $user): void
    {
        activity('tenant_switch')
            ->causedBy($user)
            ->withProperties([
                'from_tenant_id' => $from->id,
                'to_tenant_id' => $to->id,
                'ip' => request()->ip(),
            ])
            ->log('User switched tenant');
    }
    
    public function logDataAccess(Model $model, User $user, string $action): void
    {
        $tenant = app(TenantResolver::class)->getCurrentTenant();
        
        activity('tenant_data_access')
            ->causedBy($user)
            ->performedOn($model)
            ->withProperties([
                'tenant_id' => $tenant?->id,
                'action' => $action,
                'model_type' => get_class($model),
                'model_id' => $model->getKey(),
            ])
            ->log("User {$action} model data");
    }
}
```

---

## 🏗️ Refactoring Architetturale

### 1. **Tenant Manager con Command Pattern**

```php
interface TenantCommandInterface
{
    public function execute(Tenant $tenant): bool;
}

class CreateTenantDatabaseCommand implements TenantCommandInterface
{
    public function __construct(
        private TenantDatabaseManager $databaseManager
    ) {}
    
    public function execute(Tenant $tenant): bool
    {
        return $this->databaseManager->createTenantDatabase($tenant);
    }
}

class RunTenantMigrationsCommand implements TenantCommandInterface
{
    public function execute(Tenant $tenant): bool
    {
        $connectionName = "tenant_{$tenant->id}";
        
        try {
            Artisan::call('migrate', [
                '--database' => $connectionName,
                '--force' => true,
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to run tenant migrations', [
                'tenant_id' => $tenant->id,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }
}

class TenantManager
{
    /** @var TenantCommandInterface[] */
    private array $setupCommands = [];
    
    public function addSetupCommand(TenantCommandInterface $command): void
    {
        $this->setupCommands[] = $command;
    }
    
    public function setupTenant(Tenant $tenant): bool
    {
        foreach ($this->setupCommands as $command) {
            if (!$command->execute($tenant)) {
                Log::error('Tenant setup failed', [
                    'tenant_id' => $tenant->id,
                    'command' => get_class($command),
                ]);
                
                return false;
            }
        }
        
        return true;
    }
}
```

### 2. **Observer Pattern per Tenant Events**

```php
class TenantObserver
{
    public function __construct(
        private TenantManager $manager,
        private TenantAuditLogger $auditLogger
    ) {}
    
    public function created(Tenant $tenant): void
    {
        // Setup automatico del tenant
        $this->manager->setupTenant($tenant);
        
        // Log dell'evento
        $this->auditLogger->logTenantCreation($tenant);
        
        // Dispatch evento
        event(new TenantCreated($tenant));
    }
    
    public function updated(Tenant $tenant): void
    {
        // Invalida cache
        $this->clearTenantCache($tenant);
        
        // Log dell'evento
        $this->auditLogger->logTenantUpdate($tenant);
        
        // Dispatch evento
        event(new TenantUpdated($tenant));
    }
    
    public function deleted(Tenant $tenant): void
    {
        // Cleanup risorse tenant
        $this->cleanupTenantResources($tenant);
        
        // Log dell'evento
        $this->auditLogger->logTenantDeletion($tenant);
        
        // Dispatch evento
        event(new TenantDeleted($tenant));
    }
    
    private function clearTenantCache(Tenant $tenant): void
    {
        Cache::forget("tenant_domain_{$tenant->domain}");
        Cache::forget("tenant_slug_{$tenant->slug}");
    }
    
    private function cleanupTenantResources(Tenant $tenant): void
    {
        // Cleanup database, files, cache, etc.
        $this->manager->cleanupTenant($tenant);
    }
}
```

---

## 📋 Testing Strategy

### 1. **Multi-Tenant Testing**

```php
class TenantTestCase extends TestCase
{
    protected Tenant $tenant;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->tenant = Tenant::factory()->create([
            'domain' => 'test.example.com',
            'database' => 'test_tenant_db',
        ]);
        
        // Setup tenant context
        app(TenantResolver::class)->setCurrentTenant($this->tenant);
    }
    
    protected function tearDown(): void
    {
        // Cleanup tenant context
        app(TenantResolver::class)->setCurrentTenant(null);
        
        parent::tearDown();
    }
    
    protected function actingAsTenant(Tenant $tenant): self
    {
        app(TenantResolver::class)->setCurrentTenant($tenant);
        return $this;
    }
}

class TenantIsolationTest extends TenantTestCase
{
    public function test_models_are_automatically_scoped_to_tenant(): void
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();
        
        // Create data for tenant1
        $this->actingAsTenant($tenant1);
        $user1 = User::factory()->create();
        
        // Switch to tenant2
        $this->actingAsTenant($tenant2);
        $user2 = User::factory()->create();
        
        // Verify isolation
        $this->assertCount(1, User::all()); // Should only see tenant2 users
        $this->assertEquals($user2->id, User::first()->id);
    }
}
```

---

## 📈 Monitoring e Observability

### 1. **Tenant Health Monitoring**

```php
class TenantHealthMonitor
{
    public function checkTenantHealth(Tenant $tenant): array
    {
        $health = [
            'tenant_id' => $tenant->id,
            'name' => $tenant->name,
            'status' => 'healthy',
            'checks' => [],
        ];
        
        // Database connectivity
        $health['checks']['database'] = $this->checkDatabaseConnectivity($tenant);
        
        // User count
        $health['checks']['users'] = $this->checkUserCount($tenant);
        
        // Storage usage
        $health['checks']['storage'] = $this->checkStorageUsage($tenant);
        
        // Determine overall status
        $health['status'] = $this->determineOverallStatus($health['checks']);
        
        return $health;
    }
    
    private function checkDatabaseConnectivity(Tenant $tenant): array
    {
        try {
            app(TenantDatabaseManager::class)->switchToTenant($tenant);
            DB::connection()->getPdo();
            
            return ['status' => 'ok', 'message' => 'Database accessible'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    private function checkUserCount(Tenant $tenant): array
    {
        try {
            $count = User::where('tenant_id', $tenant->id)->count();
            
            return [
                'status' => 'ok',
                'count' => $count,
                'message' => "Active users: {$count}",
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    private function determineOverallStatus(array $checks): string
    {
        foreach ($checks as $check) {
            if ($check['status'] === 'error') {
                return 'unhealthy';
            }
        }
        
        return 'healthy';
    }
}
```

---

## 🎯 Roadmap di Implementazione

### Fase 1: Cleanup e Stabilizzazione (Settimana 1-2)
- [ ] Rimuovere file .no e codice commentato
- [ ] Implementare metodi mancanti nei modelli
- [ ] Separare responsabilità nel ServiceProvider
- [ ] Aggiungere configurazione centralizzata

### Fase 2: Performance Optimization (Settimana 3-4)
- [ ] Implementare caching per tenant resolution
- [ ] Ottimizzare database connection management
- [ ] Aggiungere middleware per tenant context
- [ ] Implementare lazy loading per risorse tenant

### Fase 3: Security Enhancement (Settimana 5-6)
- [ ] Implementare tenant isolation enforcement
- [ ] Aggiungere cross-tenant access prevention
- [ ] Implementare audit trail completo
- [ ] Aggiungere security monitoring

### Fase 4: Architecture Patterns (Settimana 7-8)
- [ ] Implementare Command Pattern per setup
- [ ] Aggiungere Observer Pattern per eventi
- [ ] Implementare comprehensive testing
- [ ] Aggiungere health monitoring

---

## 🔗 Collegamenti

- [Multi-Tenancy in Laravel](https://laravel.com/docs/database#multiple-database-connections)
- [Filament Multi-Tenancy](https://filamentphp.com/docs/panels/tenancy)
- [Database Isolation Patterns](../../../docs/database-isolation-patterns.md)
- [Security Best Practices](../../../docs/security-best-practices.md)

---

*Documento creato: Gennaio 2025*  
*Principi: DRY + KISS + SOLID + ROBUST + Laraxot*  
*Stato: 🔴 Necessita Cleanup Urgente e Refactoring Architetturale*

