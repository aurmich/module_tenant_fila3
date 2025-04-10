# Regola Fondamentale: Struttura dei Namespace nei Moduli

Nel progetto SaluteOra, ogni modulo segue una struttura di namespace specifica e standardizzata che deve essere rispettata rigorosamente per garantire il corretto funzionamento dell'autoloading.

## Struttura Fisica vs Namespace Logico

È **fondamentale** comprendere la distinzione tra struttura fisica dei file e namespace logico nei moduli del progetto:

### Struttura Fisica dei File

I moduli utilizzano la seguente struttura di directory fisica:

```
Modules/
└── NomeModulo/
    ├── app/
    │   ├── Models/                  # Modelli del modulo (posizione fisica)
    │   ├── Providers/               # Service e Route providers (posizione fisica)
    │   ├── Filament/                # Risorse Filament 
    │   │   ├── Resources/
    │   │   │   └── ...
    │   │   └── Pages/
    │   ├── Actions/                 # Spatie Laravel Queueable Actions (sostituiscono Service e Jobs)
    │   └── Http/                    # (Middleware, ecc., NON controller)
    ├── database/
    │   └── migrations/              # Migrazioni del modulo
    ├── lang/                        # File di traduzione
    │   ├── it/
    │   └── en/
    ├── routes/                      # Definizione delle rotte
    ├── config/                      # Configurazione modulo
    └── resources/                   # Views e assets
```

### Convenzione di Namespace

Il namespace dei file **non** rispecchia direttamente la struttura fisica. La parte `app/` del percorso fisico viene **omessa** dal namespace:

```
File fisico:                        Namespace corrispondente:
------------------------------------------------------------------
Modules/Dental/app/Models/X.php     Modules\Dental\Models\X
Modules/Dental/app/Providers/Y.php  Modules\Dental\Providers\Y
Modules/Dental/app/Filament/Z.php   Modules\Dental\Filament\Z
```

## Dichiarazione del Namespace

Modo **corretto** per dichiarare il namespace:

```php
// ✅ CORRETTO
// File fisico: /var/www/html/saluteora/laravel/Modules/Dental/app/Models/Treatment.php
namespace Modules\Dental\Models;

class Treatment extends BaseModel
{
    // ...
}
```

Modo **errato** da evitare assolutamente:

```php
// ❌ ERRATO - NON UTILIZZARE MAI
namespace Modules\Dental\app\Models;

class Treatment extends BaseModel
{
    // ...
}
```

## Configurazione dell'Autoloading

Questa struttura è definita nella configurazione dell'autoloading di ogni modulo. Nel file `composer.json` del modulo:

```json
"autoload": {
    "psr-4": {
        "Modules\\Dental\\": "app/"
    }
}
```

Questa direttiva PSR-4 mappa tutti i file contenuti nella directory `app/` al namespace base `Modules\Dental\`, **omettendo** la parte `app/` dal namespace.

## Riferimenti tra Moduli

Quando un file deve fare riferimento a classi di un altro modulo, deve utilizzare il namespace corretto:

```php
// ✅ CORRETTO
use Modules\Dental\Models\Treatment;
use Modules\Patient\Models\Patient;

// ❌ ERRATO
use Modules\Dental\app\Models\Treatment; // Errato: include 'app' nel percorso
use Modules\Patient\App\Models\Patient; // Errato: usa maiuscola in 'App'
```

## Import Standard per i Modelli

I modelli nel progetto SaluteOra seguono una struttura coerente:

```php
namespace Modules\NomeModulo\Models;

// Import fondamentali
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // se applicabile

// Relazioni (solo quelle utilizzate)
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Trait del progetto
use Modules\Xot\Traits\Updater;
use Modules\Tenant\Traits\BelongsToTenant; // se applicabile

// Modelli correlati di altri moduli
use Modules\Patient\Models\Patient;
```

## Pattern Action con Spatie Laravel Queueable Action

Il progetto SaluteOra utilizza **esclusivamente** il pattern Action implementato tramite [Spatie Laravel Queueable Action](https://github.com/spatie/laravel-queueable-action) al posto dei tradizionali Service e Jobs:

```php
// ✅ CORRETTO - Utilizzare Queueable Action
namespace Modules\Dental\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateAppointmentAction
{
    use QueueableAction;
    
    public function execute(array $data): Appointment
    {
        // Logica di business...
    }
}

// ❌ ERRATO - NON utilizzare Service Class
namespace Modules\Dental\Services;

class AppointmentService
{
    public function create(array $data)
    {
        // ...
    }
}

// ❌ ERRATO - NON utilizzare Job direttamente
namespace Modules\Dental\Jobs;

class CreateAppointmentJob implements ShouldQueue
{
    // ...
}
```

Le Queueable Action combinano i vantaggi di Service e Job, permettendo di:
1. Incapsulare la logica di business in unità testabili
2. Eseguire operazioni in modo sincrono o asincrono (in coda) senza cambiare codice
3. Mantenere una struttura coerente in tutto il progetto

## Riepilogo delle Regole Fondamentali

1. I file dei modelli si trovano fisicamente in `/Modules/NomeModulo/app/Models/`
2. Il namespace deve essere `Modules\NomeModulo\Models` (senza `app`)
3. Tutte le classi nella cartella `app/` hanno namespace che **omette** la parte `app/`
4. Non usare mai `app\` nel namespace o nelle istruzioni `use`
5. **Non** usare controller tradizionali, utilizzare Filament per tutte le interfacce
6. **Non** usare Service Class o Job diretti, utilizzare **esclusivamente** Spatie Queueable Action

Il rispetto di queste regole è **essenziale** per evitare errori di autoloading e garantire la corretta funzionalità del progetto SaluteOra.
