# PatientServiceProvider

## Descrizione
`PatientServiceProvider` è il service provider principale del modulo Patient. Estende `XotBaseServiceProvider` per fornire funzionalità specifiche per la gestione dei pazienti.

## Caratteristiche Specifiche

### Risorse Filament
Il provider registra le seguenti risorse Filament:
- `PatientResource`: Gestione anagrafica pazienti
- `DocumentResource`: Gestione documenti dei pazienti
- `AnamnesisResource`: Gestione anamnesi dei pazienti

### Struttura
```php
namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Document;
use Modules\Patient\Models\Anamnesis;
use Modules\Patient\Filament\Resources\PatientResource;
use Modules\Patient\Filament\Resources\DocumentResource;
use Modules\Patient\Filament\Resources\AnamnesisResource;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';

    public function boot(): void
    {
        parent::boot();
        $this->registerResources();
    }

    protected function registerResources(): void
    {
        if (class_exists(\Filament\Facades\Filament::class)) {
            \Filament\Facades\Filament::registerResources([
                PatientResource::class,
                DocumentResource::class,
                AnamnesisResource::class,
            ]);
        }
    }
}
```

## Funzionalità

1. **Boot**
   - Chiama il boot del parent per la configurazione base
   - Registra le risorse Filament specifiche del modulo

2. **Risorse Filament**
   - Registra automaticamente le risorse se Filament è disponibile
   - Gestisce le risorse per pazienti, documenti e anamnesi

## Note Importanti
- Estende `XotBaseServiceProvider` invece di `ServiceProvider`
- Utilizza la proprietà `$name` per identificare il modulo
- Non necessita di reimplementare i metodi base già forniti da `XotBaseServiceProvider`
- Aggiunge solo la registrazione delle risorse Filament specifiche del modulo

## Dipendenze
- Modulo Xot
- Filament Admin Panel
- Laravel Framework

## Best Practices
1. Mantenere il provider il più snello possibile
2. Utilizzare le funzionalità fornite da XotBaseServiceProvider
3. Aggiungere solo funzionalità specifiche del modulo
4. Documentare eventuali personalizzazioni 