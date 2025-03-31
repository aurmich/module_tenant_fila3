# Miglioramento Configurazione Tenant

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

Il miglioramento della configurazione del sistema multi-tenant è attualmente completato al 90%. Questa componente è fondamentale per garantire la scalabilità della piattaforma SaluteOra e il supporto per multiple strutture sanitarie indipendenti.

## Obiettivi dell'Implementazione

Il miglioramento della configurazione Tenant mira a:

1. Fornire un sistema robusto per la gestione di strutture sanitarie multiple
2. Garantire l'isolamento completo dei dati tra i diversi tenant
3. Ottimizzare la gestione delle risorse condivise
4. Implementare un sistema flessibile di configurazione per tenant
5. Migliorare le performance del sistema multi-tenant

## Componenti Implementati (90%)

- ✅ Architettura multi-tenant con database separati per ciascun tenant
- ✅ Middleware per rilevamento e routing automatico al tenant corretto
- ✅ Sistema di gestione domini personalizzati per tenant
- ✅ Creazione automatizzata tenant con provisioning risorse
- ✅ Console di amministrazione per gestione tenant
- ✅ Sistema di cache isolata per tenant
- ✅ Gestione utenti cross-tenant con ruoli separati

## Componenti da Implementare (10%)

- 🚧 Sistema avanzato di backup per tenant individuali (50%)
- 🚧 Ottimizzazione query per migliorare performance cross-tenant (60%)
- 📅 Dashboard di monitoraggio risorse per tenant
- 📅 Sistema di migrazioni personalizzate per tenant specifici

## Architettura Multi-Tenant

SaluteOra implementa un'architettura multi-tenant basata sul database-per-tenant, garantendo il massimo isolamento:

```
                         ┌─────────────────┐
                         │                 │
                         │  Load Balancer  │
                         │                 │
                         └────────┬────────┘
                                  │
                                  │
                         ┌────────▼────────┐
                         │                 │
                         │  Tenant Router  │
                         │                 │
                         └───┬──────┬──────┘
                             │      │
              ┌──────────────┘      └──────────────┐
              │                                    │
     ┌────────▼─────────┐                ┌─────────▼────────┐
     │                  │                │                  │
     │  Tenant A        │                │  Tenant B        │
     │  (clinica1.com)  │                │  (clinica2.com)  │
     │                  │                │                  │
     └────────┬─────────┘                └─────────┬────────┘
              │                                    │
     ┌────────▼─────────┐                ┌─────────▼────────┐
     │                  │                │                  │
     │  Database A      │                │  Database B      │
     │                  │                │                  │
     └──────────────────┘                └──────────────────┘
```

## Implementazione Tecnica

### 1. Identificazione Tenant

Il sistema identifica il tenant tramite il dominio:

```php
// app/Http/Middleware/IdentifyTenant.php
public function handle($request, Closure $next)
{
    $host = $request->getHost();
    
    $tenant = Tenant::where('domain', $host)->first();
    
    if (!$tenant) {
        // Fallback al tenant principale o errore
        return redirect(config('tenant.central_domain'));
    }
    
    // Imposta il tenant corrente nel contenitore
    app()->instance('tenant', $tenant);
    
    // Configura la connessione al database del tenant
    config([
        'database.connections.tenant.database' => "tenant_{$tenant->id}",
    ]);
    
    DB::purge('tenant');
    
    return $next($request);
}
```

### 2. Creazione Tenant

La creazione di un nuovo tenant include:

```php
// Modules/Tenant/Actions/CreateTenantAction.php
public function execute(array $data): Tenant
{
    DB::beginTransaction();
    
    try {
        // 1. Crea record tenant
        $tenant = Tenant::create([
            'name' => $data['name'],
            'domain' => $data['domain'],
            'database' => "tenant_{$data['id']}",
            // Altri dati...
        ]);
        
        // 2. Crea database per tenant
        DB::statement("CREATE DATABASE IF NOT EXISTS {$tenant->database}");
        
        // 3. Esegue migrazioni per il nuovo tenant
        $this->runMigrationsForTenant($tenant);
        
        // 4. Crea utente amministratore per tenant
        $this->createAdminUser($tenant, $data);
        
        // 5. Setup configurazioni base
        $this->setupTenantConfigurations($tenant, $data);
        
        DB::commit();
        
        return $tenant;
    } catch (\Exception $e) {
        DB::rollBack();
        
        // Cleanup in caso di errore
        if (isset($tenant) && $tenant->exists) {
            DB::statement("DROP DATABASE IF EXISTS {$tenant->database}");
            $tenant->delete();
        }
        
        throw $e;
    }
}
```

### 3. Sistema di Configurazione per Tenant

Ogni tenant ha configurazioni personalizzabili:

```php
// config/tenant.php
return [
    'cache_prefix' => 'tenant_{id}_',
    'storage_path' => storage_path('tenant/{id}'),
    'migrate_path' => database_path('migrations/tenant'),
    'default_settings' => [
        'appointment_slots' => 30, // minuti
        'working_hours' => [
            'start' => '09:00',
            'end' => '18:00',
        ],
        'notification_channels' => ['mail', 'sms'],
        // Altre impostazioni...
    ],
];
```

## Ottimizzazioni Performance

Per garantire performance ottimali nel sistema multi-tenant:

1. **Query Scoping Automatico**:
   Utilizzo di trait `BelongsToTenant` per filtrare automaticamente i risultati:

```php
trait BelongsToTenant
{
    public static function bootBelongsToTenant()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $builder->where('tenant_id', app('tenant')->id);
        });
        
        static::creating(function ($model) {
            $model->tenant_id = app('tenant')->id;
        });
    }
}
```

2. **Cache Isolata**:
   Cache separata per ogni tenant con prefisso automatico:

```php
$cacheKey = "tenant_" . app('tenant')->id . "_key";
Cache::put($cacheKey, $value, $minutes);
```

3. **Storage Isolato**:
   Directory separate per ogni tenant:

```php
$path = storage_path("tenant/" . app('tenant')->id . "/uploads");
```

## Roadmap di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Sistema avanzato backup per tenant | Maggio 2024 | Alta |
| Ottimizzazione query cross-tenant | Maggio 2024 | Alta |
| Dashboard monitoraggio risorse | Giugno 2024 | Media |
| Migrazioni personalizzate per tenant | Luglio 2024 | Bassa |

## Considerazioni per Scalabilità

In preparazione per la futura crescita, il sistema è progettato per:

1. **Scalabilità Orizzontale**:
   - Supporto per distribuzione database su più server
   - Sharding automatico basato su tenant

2. **Backup e Disaster Recovery**:
   - Backup automatici per tenant
   - Ripristino selettivo a livello di tenant

3. **Risorse Condivise**:
   - Asset statici condivisi tra tenant
   - Cache di sistema separata dalla cache tenant

## Sicurezza

La sicurezza multi-tenant è garantita da:

1. **Isolamento Database**:
   - Database fisicamente separati
   - Utenti database con permessi limitati

2. **Autenticazione Cross-tenant**:
   - Prevenzione accesso cross-tenant
   - Sessioni separate per tenant

3. **Auditing**:
   - Log separati per tenant
   - Monitoraggio accessi cross-tenant

## Metriche di Successo

- Tempo di risposta medio < 100ms per tenant
- Isolamento dati 100% tra tenant
- Provisioning nuovo tenant < 2 minuti
- Overhead memoria per tenant < 5%
