# Standard di Codice SaluteOra

## Principi Fondamentali

Il codice del progetto SaluteOra deve rispettare i seguenti principi fondamentali:

### Robustezza

- **Gestione errori completa**: Ogni possibile errore deve essere gestito e documentato
- **Validazione input**: Tutti gli input esterni devono essere validati e sanitizzati
- **Gestione eccezioni**: Implementare try/catch appropriati con logging degli errori
- **Fail fast**: Identificare e segnalare gli errori il prima possibile
- **Degradazione graceful**: Il sistema deve mantenere funzionalità essenziali anche in caso di errori
- **Testing esaustivo**: Copertura test per tutti i casi limite ed edge case

### Solidità

- **SOLID principles**: Seguire i principi SOLID in tutta la codebase
  - Single Responsibility Principle
  - Open/Closed Principle
  - Liskov Substitution Principle
  - Interface Segregation Principle
  - Dependency Inversion Principle
- **Separation of Concerns**: Ogni componente deve avere una responsabilità chiaramente definita
- **DRY (Don't Repeat Yourself)**: Evitare duplicazione di codice
- **Pattern appropriati**: Utilizzare i pattern di design appropriati per il contesto
- **Manutenibilità**: Il codice deve essere facilmente mantenibile e comprensibile

### Tipizzazione Stretta

- **Type hints obbligatori**: Tutti i parametri e i valori di ritorno devono essere tipizzati
- **Return types obbligatori**: Specificare sempre il tipo di ritorno delle funzioni
- **Evitare mixed e any**: Utilizzare tipi specifici invece di tipi generici quando possibile
- **PHPStan**: Utilizzare PHPStan con livello progressivo (obiettivo minimo livello 9)
- **Interfaces**: Definire interfacce chiare per contratti di codice
- **Generics**: Utilizzare generics per collezioni tipizzate
- **Data Transfer Objects**: Preferire DTO tipizzati rispetto ad array associativi
- **Enum**: Utilizzare enum per stati e valori costanti
- **Property promotion**: Utilizzare constructor property promotion
- **Nullable types**: Specificare esplicitamente quando un valore può essere null

## Linee Guida Implementative

### Struttura del Codice

- Mantenere file di dimensioni contenute e con responsabilità singola
- Organizzare il codice in classi, trait e interfaces ben definiti
- Mantenere una struttura di directory coerente
- Rispettare le convenzioni di naming di Laravel
- Utilizzare namespace appropriati

### Documentazione

- Documentare con PHPDoc tutte le classi, metodi e proprietà pubbliche
- Spiegare il "perché" delle scelte implementative, non solo il "cosa"
- Mantenere la documentazione aggiornata con il codice
- Utilizzare type annotations nei commenti

### Debugging e Logging

- Implementare logging dettagliato per operazioni critiche
- Utilizzare livelli di log appropriati (debug, info, warning, error)
- Evitare di loggare dati sensibili
- Implementare tracciamento delle performance per operazioni costose

### Testing

- Test unitari per tutte le classi
- Test di integrazione per componenti interconnessi
- Test funzionali per i flussi critici
- Mocking appropriato delle dipendenze
- Coverage target minimo dell'80%

## Esempi

### Esempio di Classe Tipizzata

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Actions;

use Modules\Patient\Models\Patient;
use Modules\Patient\Data\PatientData;
use Modules\Patient\Exceptions\PatientCreationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class CreatePatientAction
{
    /**
     * Crea un nuovo paziente con i dati forniti.
     *
     * @param PatientData $data I dati validati del paziente
     * 
     * @throws PatientCreationException Se si verifica un errore durante la creazione
     * 
     * @return Patient Il paziente creato
     */
    public function execute(PatientData $data): Patient
    {
        try {
            DB::beginTransaction();
            
            $patient = new Patient();
            $patient->name = $data->name;
            $patient->surname = $data->surname;
            $patient->fiscal_code = $data->fiscal_code;
            $patient->birth_date = $data->birth_date;
            $patient->email = $data->email;
            $patient->phone = $data->phone;
            $patient->save();
            
            // Logica addizionale...
            
            DB::commit();
            
            Log::info('Paziente creato con successo', ['id' => $patient->id]);
            
            return $patient;
        } catch (Throwable $e) {
            DB::rollBack();
            
            Log::error('Errore durante la creazione del paziente', [
                'exception' => $e->getMessage(),
                'data' => $data->toArray(),
            ]);
            
            throw new PatientCreationException(
                'Impossibile creare il paziente: ' . $e->getMessage(),
                previous: $e
            );
        }
    }
}
```

### Esempio di DTO Tipizzato

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Data;

use Spatie\LaravelData\Data;
use Carbon\CarbonImmutable;
use Modules\Patient\Enums\GenderEnum;

final class PatientData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly string $fiscal_code,
        public readonly CarbonImmutable $birth_date,
        public readonly GenderEnum $gender,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
    ) {
    }
    
    /**
     * Regole di validazione per il DTO.
     */
    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'fiscal_code' => 'required|string|size:16',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|enum:'.GenderEnum::class,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ];
    }
}
```

## Risorse e Strumenti

- PHPStan per analisi statica
- PHP_CodeSniffer per standard di codifica
- Laravel Pint per formattazione
- Rector per refactoring automatizzato
- Pest/PHPUnit per testing
- Laravel IDE Helper per supporto IDE

## Conclusione

Mantenere un codice robusto, solido e strettamente tipizzato non è solo una questione tecnica ma un requisito fondamentale per il successo del progetto SaluteOra. Questi standard non sono negoziabili e devono essere rispettati in ogni fase dello sviluppo.

La qualità del codice è direttamente proporzionale alla qualità del prodotto finale e alla velocità con cui è possibile implementare nuove funzionalità e risolvere problemi.
