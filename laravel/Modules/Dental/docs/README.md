# Modulo Dental

## Descrizione
Il modulo Dental gestisce tutte le funzionalità relative alle visite e ai trattamenti dentali nel sistema SaluteOra.

## Namespace
Il namespace base del modulo è:
```php
namespace Modules\Dental;
```

## Struttura del Modulo
```
Modules/Dental/
├── app/                    # Logica applicativa
│   ├── Models/            # Modelli del modulo
│   │   ├── Visit.php      # Gestione visite
│   │   ├── Treatment.php  # Gestione trattamenti
│   │   └── Tooth.php      # Gestione denti
│   ├── Http/              # Controllers e middleware
│   ├── Services/          # Logica di business
│   ├── Events/            # Eventi del sistema
│   ├── Listeners/         # Gestori eventi
│   ├── Notifications/     # Notifiche
│   ├── Providers/         # Service providers
│   ├── Console/           # Comandi Artisan
│   └── Filament/          # Risorse Filament
├── config/                # Configurazioni
├── database/              # Migrations e seeders
├── resources/             # Views e assets
└── routes/                # Definizione route
```

## Dipendenze
- Patient: Per l'accesso ai dati del paziente
- User: Per la gestione dei permessi
- Tenant: Per la gestione multi-tenant

## Modelli Principali

### Visit
```php
namespace Modules\Dental\Models;

class Visit extends Model
{
    protected $fillable = [
        'patient_id',
        'date',
        'notes',
        'status',
        // ...
    ];
}
```

### Treatment
```php
namespace Modules\Dental\Models;

class Treatment extends Model
{
    protected $fillable = [
        'visit_id',
        'type',
        'description',
        'cost',
        // ...
    ];
}
```

### Tooth
```php
namespace Modules\Dental\Models;

class Tooth extends Model
{
    protected $fillable = [
        'patient_id',
        'position',
        'status',
        'notes',
        // ...
    ];
}
```

## Risorse Filament
Le risorse Filament sono disponibili in:
```php
namespace Modules\Dental\Filament\Resources;
```

## Eventi
Gli eventi principali sono:
- VisitCreated
- VisitUpdated
- TreatmentCreated
- TreatmentCompleted

## Permessi
I permessi principali sono:
- dental.view_visits
- dental.create_visits
- dental.edit_visits
- dental.delete_visits
- dental.view_treatments
- dental.create_treatments
- dental.edit_treatments
- dental.delete_treatments

## Best Practices
1. **Validazione**:
   - Validare tutti gli input
   - Verificare i permessi
   - Controllare le dipendenze

2. **Performance**:
   - Ottimizzare le query
   - Utilizzare eager loading
   - Implementare caching

3. **Sicurezza**:
   - Proteggere i dati sensibili
   - Logging delle modifiche
   - Backup regolari

4. **Manutenzione**:
   - Aggiornare le dipendenze
   - Testare le modifiche
   - Documentare le API 