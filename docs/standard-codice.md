# Standard di Codice per SaluteOra

## Principi Fondamentali

Il codice del progetto SaluteOra **deve** aderire ai seguenti principi fondamentali:

1. **Robustezza**: Il codice deve funzionare correttamente anche in condizioni impreviste o avverse
2. **Solidità**: La struttura deve essere manutenibile, scalabile e testabile
3. **Tipizzazione Stretta**: Ogni variabile, parametro e valore di ritorno deve essere esplicitamente tipizzato

Questi principi sono **non negoziabili** e costituiscono la base per uno sviluppo di qualità.

## Tipizzazione Stretta (Strict Typing)

### Configurazione PHP

Tutti i file PHP **devono** iniziare con la dichiarazione di strict types:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\app\Models;
```

### Tipizzazione Esplicita

Ogni metodo e funzione **deve** dichiarare:
- Il tipo di ogni parametro
- Il tipo di ritorno, incluso `void` quando non restituisce valori
- Tipizzazioni nullable quando appropriato (`?string`)
- Tipizzazioni di unione quando strettamente necessario (`string|int`)

**Esempi corretti:**

```php
public function getPatientById(int $id): ?Patient
{
    return $this->repository->find($id);
}

public function calculateAge(DateTimeInterface $birthDate): int
{
    return $birthDate->diff(new DateTime())->y;
}

public function processData(array $data): void
{
    // Elaborazione senza valore di ritorno
}
```

**Esempi errati (da evitare):**

```php
// ❌ NO: Mancanza di tipizzazione
public function getPatient($id)
{
    return $this->repository->find($id);
}

// ❌ NO: Tipizzazione incompleta
public function savePatient(Patient $patient)
{
    $this->repository->save($patient);
}
```

### Utilizzo di Types e Enums

- Utilizzare **enum** PHP 8.1+ per tutti i valori che rappresentano un insieme limitato di opzioni
- Utilizzare **typed properties** per tutte le proprietà delle classi
- Utilizzare **value objects** per rappresentare concetti di dominio complessi

**Esempio di Enum:**

```php
enum GenderType: string
{
    case FEMALE = 'F';
    case MALE = 'M';
    case OTHER = 'O';
    
    public function label(): string
    {
        return match($this) {
            self::FEMALE => 'Femminile',
            self::MALE => 'Maschile',
            self::OTHER => 'Altro',
        };
    }
}

// Utilizzo
public function setGender(GenderType $gender): void
{
    $this->gender = $gender->value;
}
```

**Esempio di Value Object:**

```php
final class TaxCode
{
    private string $value;
    
    public function __construct(string $taxCode)
    {
        if (!$this->isValid($taxCode)) {
            throw new InvalidArgumentException('Codice fiscale non valido');
        }
        
        $this->value = $taxCode;
    }
    
    public function value(): string
    {
        return $this->value;
    }
    
    private function isValid(string $taxCode): bool
    {
        // Validazione del codice fiscale
        return (bool) preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/', $taxCode);
    }
}
```

## Robustezza del Codice

### Gestione delle Eccezioni

- Utilizzare eccezioni specifiche per ogni tipo di errore
- Documentare tutte le eccezioni che possono essere lanciate da un metodo
- Gestire le eccezioni al livello appropriato dell'applicazione
- Mai nascondere le eccezioni senza una gestione appropriata

```php
/**
 * Trova un paziente per codice fiscale.
 *
 * @param string $taxCode Il codice fiscale del paziente
 * @return Patient Il paziente trovato
 * @throws PatientNotFoundException Se nessun paziente viene trovato con il codice fiscale specificato
 * @throws InvalidTaxCodeException Se il codice fiscale non è valido
 */
public function findByTaxCode(string $taxCode): Patient
{
    if (!TaxCode::isValid($taxCode)) {
        throw new InvalidTaxCodeException($taxCode);
    }
    
    $patient = $this->repository->findByTaxCode($taxCode);
    
    if ($patient === null) {
        throw new PatientNotFoundException("Nessun paziente trovato con codice fiscale: {$taxCode}");
    }
    
    return $patient;
}
```

### Validazione Input

- Validare **sempre** gli input esterni (richieste HTTP, dati importati, ecc.)
- Utilizzare form request per la validazione nelle richieste HTTP
- Applicare validazione approfondita anche per i dati provenienti dal database

```php
namespace Modules\Patient\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Patient\app\Enums\GenderType;

class StorePatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:' . implode(',', array_column(GenderType::cases(), 'value'))],
            'tax_code' => ['required', 'string', 'size:16', 'unique:patients,tax_code'],
            'pregnancy_week' => ['nullable', 'integer', 'min:1', 'max:45'],
        ];
    }
}
```

### Controlli Difensivi

- Implementare controlli precondizionali all'inizio dei metodi
- Utilizzare guardie per evitare esecuzioni indesiderate
- Verificare sempre lo stato del sistema prima di operazioni critiche

```php
public function scheduleVisit(Patient $patient, Doctor $doctor, DateTimeImmutable $visitDate): Visit
{
    // Controlli difensivi
    if (!$patient->isActive()) {
        throw new InactivePatientException('Non è possibile programmare visite per pazienti inattivi');
    }
    
    if (!$doctor->isAvailable($visitDate)) {
        throw new DoctorNotAvailableException('Il medico non è disponibile nella data selezionata');
    }
    
    if ($visitDate < new DateTimeImmutable()) {
        throw new InvalidVisitDateException('La data della visita non può essere nel passato');
    }
    
    // Procedi con la programmazione della visita
    return $this->visitRepository->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'visit_date' => $visitDate,
        'status' => VisitStatus::SCHEDULED->value,
    ]);
}
```

## Solidità del Codice

### Principi SOLID

Ogni classe deve seguire i principi SOLID:

1. **S** - Single Responsibility Principle: Ogni classe deve avere una sola responsabilità
2. **O** - Open/Closed Principle: Le classi devono essere aperte all'estensione ma chiuse alla modifica
3. **L** - Liskov Substitution Principle: Gli oggetti di una classe derivata devono poter sostituire gli oggetti della classe base
4. **I** - Interface Segregation Principle: Molte interfacce cliente-specifiche sono meglio di una sola interfaccia per tutti
5. **D** - Dependency Inversion Principle: Dipendere da astrazioni, non da implementazioni concrete

### Repository Pattern

- Utilizzare il Repository Pattern per isolare la logica di accesso ai dati
- Utilizzare interfacce per definire i contratti dei repository
- Iniettare i repository tramite Dependency Injection

```php
interface PatientRepositoryInterface
{
    public function find(int $id): ?Patient;
    public function findByTaxCode(string $taxCode): ?Patient;
    public function save(Patient $patient): void;
    public function delete(int $id): void;
}

class EloquentPatientRepository implements PatientRepositoryInterface
{
    public function __construct(
        private readonly Patient $model
    ) {}
    
    public function find(int $id): ?Patient
    {
        return $this->model->find($id);
    }
    
    public function findByTaxCode(string $taxCode): ?Patient
    {
        return $this->model->where('tax_code', $taxCode)->first();
    }
    
    // Altre implementazioni...
}
```

### Service Layer

- Incapsulare la logica di business in service dedicati
- Separare le responsabilità tra diversi service
- Utilizzare DTOs per trasferire dati tra i layer

```php
class PatientService
{
    public function __construct(
        private readonly PatientRepositoryInterface $patientRepository,
        private readonly IseeDocumentRepositoryInterface $iseeRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}
    
    public function registerPatient(PatientData $data): Patient
    {
        $patient = new Patient();
        $patient->setFirstName($data->firstName);
        $patient->setLastName($data->lastName);
        // Altre proprietà...
        
        $this->patientRepository->save($patient);
        
        $this->eventDispatcher->dispatch(new PatientRegisteredEvent($patient));
        
        return $patient;
    }
}
```

### Testing

- Ogni componente deve essere testabile
- Scrivere test unitari per ogni classe
- Utilizzare mocking per isolare i componenti durante i test

```php
public function test_find_patient_by_tax_code_returns_null_when_not_found(): void
{
    // Arrange
    $repository = Mockery::mock(PatientRepositoryInterface::class);
    $repository->shouldReceive('findByTaxCode')
        ->with('ABCDEF12G34H567I')
        ->once()
        ->andReturnNull();
        
    $service = new PatientService($repository, $this->mockIseeRepository, $this->mockEventDispatcher);
    
    // Act & Assert
    $this->expectException(PatientNotFoundException::class);
    $service->findPatientByTaxCode('ABCDEF12G34H567I');
}
```

## Best Practices di Implementazione

### Modelli

I modelli **devono**:
- Avere proprietà tipizzate
- Utilizzare `casts` per garantire i tipi corretti
- Implementare relazioni con tipi di ritorno espliciti
- Utilizzare scopes tipizzati

```php
namespace Modules\Patient\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Modules\Patient\app\Enums\GenderType;
use Modules\Patient\app\Enums\PatientStatus;

class Patient extends Model
{
    protected $fillable = [
        'code',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'tax_code',
        // Altri campi...
    ];

    protected $casts = [
        'birth_date' => 'date',
        'gender' => GenderType::class,
        'status' => PatientStatus::class,
        'pregnancy_week' => 'integer',
    ];

    public function iseeDocuments(): HasMany
    {
        return $this->hasMany(IseeDocument::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', PatientStatus::ACTIVE->value);
    }
    
    public function scopePregnant(Builder $query): Builder
    {
        return $query->whereNotNull('pregnancy_week')
            ->where('gender', GenderType::FEMALE->value);
    }
}
```

### Controllers

I controllers **devono**:
- Essere sottili (thin) con logica minima
- Delegare la logica di business ai service
- Utilizzare form request per la validazione
- Restituire tipi di risposta espliciti

```php
namespace Modules\Patient\app\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Patient\app\Http\Requests\StorePatientRequest;
use Modules\Patient\app\Services\PatientService;

class PatientController extends Controller
{
    public function __construct(
        private readonly PatientService $patientService
    ) {}

    public function show(int $id): View
    {
        $patient = $this->patientService->getPatientById($id);
        
        return view('patient::show', compact('patient'));
    }

    public function store(StorePatientRequest $request): RedirectResponse
    {
        $patient = $this->patientService->createPatient(
            $request->validated()
        );
        
        return redirect()->route('patients.show', $patient)
            ->with('success', 'Paziente creato con successo');
    }
}
```

### Filament Resources

I resources Filament **devono**:
- Utilizzare tipizzazioni esplicite per form e tabelle
- Implementare validazione coerente con quella dei modelli
- Utilizzare enums per opzioni di selezione

```php
namespace Modules\Patient\app\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Patient\app\Models\Patient;
use Modules\Patient\app\Enums\GenderType;
use Modules\Patient\app\Enums\PatientStatus;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    
    // Implementazione...
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('first_name')
                ->label('Nome')
                ->required()
                ->maxLength(255),
            // Altri campi...
            Select::make('gender')
                ->label('Genere')
                ->options(array_combine(
                    array_column(GenderType::cases(), 'value'),
                    array_map(fn (GenderType $gender) => $gender->label(), GenderType::cases())
                ))
                ->required(),
            Select::make('status')
                ->label('Stato')
                ->options(array_combine(
                    array_column(PatientStatus::cases(), 'value'),
                    array_map(fn (PatientStatus $status) => $status->label(), PatientStatus::cases())
                ))
                ->default(PatientStatus::ACTIVE->value)
                ->required(),
        ]);
    }
}
```

## Documentazione del Codice

- Ogni classe **deve** avere un docblock che descrive il suo scopo
- Ogni metodo pubblico **deve** essere documentato con parametri, tipo di ritorno ed eccezioni
- Ogni modulo **deve** avere un file README.md che descrive il suo scopo e utilizzo

```php
/**
 * Service responsabile della gestione dei dati dei pazienti.
 * 
 * Questo service implementa la logica di business relativa alla creazione,
 * aggiornamento e ricerca dei pazienti nel sistema.
 */
class PatientService
{
    /**
     * Trova un paziente tramite il suo codice fiscale.
     *
     * @param string $taxCode Il codice fiscale del paziente
     * @return Patient Il paziente trovato
     * @throws PatientNotFoundException Se non viene trovato alcun paziente
     * @throws InvalidTaxCodeException Se il codice fiscale non è valido
     */
    public function findByTaxCode(string $taxCode): Patient
    {
        // Implementazione...
    }
}
```

## Strumenti e Configurazioni

### PHPStan

Utilizzare PHPStan livello 8 (massimo) per l'analisi statica del codice:

```bash
# Installazione
composer require --dev phpstan/phpstan

# Configurazione (phpstan.neon)
parameters:
  level: 8
  paths:
    - app
    - Modules
  checkMissingIterableValueType: true
  checkGenericClassInNonGenericObjectType: true
```

### PHP-CS-Fixer

Utilizzare PHP-CS-Fixer per garantire la coerenza dello stile del codice:

```bash
# Installazione
composer require --dev friendsofphp/php-cs-fixer

# Configurazione (.php-cs-fixer.dist.php)
$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'declare_strict_types' => true,
    ])
    ->setFinder(PhpCsFixer\Finder::create()
        ->in([__DIR__ . '/app', __DIR__ . '/Modules'])
    );
```

### Configurazione composer.json

Aggiungere script utili in composer.json:

```json
"scripts": {
    "phpstan": "phpstan analyse",
    "csfix": "php-cs-fixer fix",
    "test": "phpunit",
    "check": [
        "@phpstan",
        "@csfix",
        "@test"
    ]
}
```

## Conclusione

L'aderenza a questi standard di codice **non è opzionale**:

1. Codice **robusto** ci protegge da errori in produzione
2. Codice **solido** ci permette di mantenere e far evolvere il sistema nel tempo
3. Codice **strettamente tipizzato** ci dà garanzie e ci permette di rilevare errori prima del runtime

Questi principi sono alla base della qualità del software che produciamo per SaluteOra e sono essenziali per il successo del progetto. 