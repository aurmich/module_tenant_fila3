# Guida per Sviluppatori - Modulo Patient

## Introduzione

Questa guida è rivolta agli sviluppatori che lavorano sul modulo Patient di SaluteOra. Fornisce linee guida, best practices e esempi pratici per estendere e personalizzare il modulo seguendo gli standard di codice del progetto.

## Standard di Codice

Il modulo Patient segue rigorosamente gli standard di codice definiti per il progetto SaluteOra:

### Tipizzazione Stretta

Utilizzare sempre la dichiarazione dei tipi stretta per garantire robustezza e manutenibilità:

```php
declare(strict_types=1);

public function getPatientById(int $id): ?Patient
{
    return Patient::find($id);
}
```

### Convenzioni di Naming

- **Classi**: PascalCase (es. `PatientController`)
- **Metodi e variabili**: camelCase (es. `getPatientData()`)
- **Costanti**: SNAKE_CASE_MAIUSCOLO (es. `DEFAULT_PAGINATION_LIMIT`)
- **File di configurazione**: snake_case (es. `patient_settings.php`)

### Documentazione del Codice

Documentare adeguatamente classi, metodi e funzioni complesse:

```php
/**
 * Calcola l'età del paziente in base alla data di nascita.
 *
 * @param \DateTime $birthDate Data di nascita del paziente
 * @return int Età in anni
 */
public function calculateAge(\DateTime $birthDate): int
{
    return $birthDate->diff(new \DateTime())->y;
}
```

### Gestione degli Errori

Utilizzare eccezioni tipizzate per gestire gli errori in modo strutturato:

```php
if (!$patient) {
    throw new PatientNotFoundException("Paziente con ID {$id} non trovato");
}
```

## Estensione del Modulo

### Aggiungere Nuovi Campi al Modello Patient

1. Creare una nuova migrazione:

```bash
php artisan module:make-migration add_new_field_to_patients_table Patient
```

2. Definire la migrazione:

```php
public function up()
{
    Schema::table('patients', function (Blueprint $table) {
        $table->string('emergency_contact')->nullable();
        $table->string('emergency_phone')->nullable();
    });
}
```

3. Aggiornare il modello `Patient`:

```php
protected $fillable = [
    // Campi esistenti
    'emergency_contact',
    'emergency_phone',
];
```

4. Aggiornare i form e le viste per includere i nuovi campi

### Creare un Nuovo Modello Correlato

1. Generare il modello:

```bash
php artisan module:make-model MedicalRecord Patient
```

2. Definire la relazione nel modello `Patient`:

```php
public function medicalRecords(): HasMany
{
    return $this->hasMany(MedicalRecord::class);
}
```

3. Implementare il modello `MedicalRecord`:

```php
namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'record_date',
        'description',
        'doctor_name',
        'attachments',
    ];
    
    protected $casts = [
        'record_date' => 'date',
        'attachments' => 'array',
    ];
    
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
```

## Personalizzazione del Wizard di Registrazione

### Aggiungere un Nuovo Step al Wizard Blade

1. Modificare la proprietà `$totalSteps` nel componente:

```php
public int $totalSteps = 5; // Aumentato da 4 a 5
```

2. Aggiungere il titolo e la descrizione del nuovo step:

```php
public function getStepTitle(): string
{
    return match($this->currentStep) {
        // Step esistenti
        5 => 'Informazioni Mediche',
        default => 'Registrazione Paziente',
    };
}

public function getStepDescription(): string
{
    return match($this->currentStep) {
        // Step esistenti
        5 => 'Inserisci informazioni mediche rilevanti',
        default => 'Compila tutti i campi per completare la registrazione',
    };
}
```

3. Aggiungere il markup HTML per il nuovo step nel template Blade:

```html
<div class="wizard-step {{ $currentStep == 5 ? 'block' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-group">
            <label for="allergies" class="block text-sm font-medium text-gray-700">Allergie</label>
            <textarea name="allergies" id="allergies" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $patientData['allergies'] ?? old('allergies') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="medications" class="block text-sm font-medium text-gray-700">Farmaci in Uso</label>
            <textarea name="medications" id="medications" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $patientData['medications'] ?? old('medications') }}</textarea>
        </div>
    </div>
    
    <div class="form-group mt-6">
        <label for="medical_notes" class="block text-sm font-medium text-gray-700">Note Mediche</label>
        <textarea name="medical_notes" id="medical_notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $patientData['medical_notes'] ?? old('medical_notes') }}</textarea>
    </div>
</div>
```

4. Aggiornare la validazione JavaScript:

```javascript
function validateStep5() {
    var isValid = true;
    // Validazione dei campi del nuovo step
    return isValid;
}

function validateCurrentStep(step) {
    switch(step) {
        // Case esistenti
        case 5:
            return validateStep5();
        default:
            return true;
    }
}
```

### Aggiungere un Nuovo Step al Wizard Filament

1. Modificare il metodo `getFormSchema()` nel componente Filament:

```php
protected function getFormSchema(): array
{
    return [
        Wizard::make([
            // Step esistenti
            
            Step::make('Informazioni Mediche')
                ->icon('heroicon-o-heart')
                ->description('Inserisci informazioni mediche rilevanti')
                ->schema([
                    Textarea::make('allergies')
                        ->label('Allergie')
                        ->rows(3),
                    
                    Textarea::make('medications')
                        ->label('Farmaci in Uso')
                        ->rows(3),
                    
                    Textarea::make('medical_notes')
                        ->label('Note Mediche')
                        ->rows(4),
                ]),
        ])
    ];
}
```

## Integrazione con Altri Moduli

### Integrazione con il Modulo Dental

Per integrare il modulo Patient con il modulo Dental, seguire questi passaggi:

1. Creare una relazione tra i modelli:

```php
// In Patient.php
public function dentalRecords(): HasMany
{
    return $this->hasMany(\Modules\Dental\Models\DentalRecord::class);
}

// In DentalRecord.php (modulo Dental)
public function patient(): BelongsTo
{
    return $this->belongsTo(\Modules\Patient\Models\Patient::class);
}
```

2. Aggiungere un tab nella vista dettaglio del paziente:

```php
// In PatientResource.php
public static function getRelations(): array
{
    return [
        RelationManagers\DentalRecordsRelationManager::class,
    ];
}
```

3. Implementare il RelationManager:

```php
namespace Modules\Patient\Filament\Resources\PatientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Modules\Dental\Models\DentalRecord;

class DentalRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'dentalRecords';
    
    public static function getTitle(): string
    {
        return 'Cartelle Dentali';
    }
    
    public static function getListTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'date' => TextColumn::make('date')
                ->date()
                ->sortable(),
            'dentist' => TextColumn::make('dentist')
                ->searchable(),
            'description' => TextColumn::make('description')
                ->limit(50),
        ];
    }
}
```

## Testing

### Test Unitari

Creare test unitari per le funzionalità critiche:

```php
namespace Modules\Patient\Tests\Unit;

use Tests\TestCase;
use Modules\Patient\Models\Patient;

class PatientTest extends TestCase
{
    /** @test */
    public function it_can_calculate_patient_age()
    {
        $patient = new Patient();
        $patient->birth_date = now()->subYears(30);
        
        $this->assertEquals(30, $patient->getAge());
    }
    
    /** @test */
    public function it_validates_fiscal_code_format()
    {
        $patient = Patient::factory()->make([
            'fiscal_code' => 'INVALID',
        ]);
        
        $this->assertFalse($patient->hasValidFiscalCode());
        
        $patient->fiscal_code = 'RSSMRA80A01H501U';
        $this->assertTrue($patient->hasValidFiscalCode());
    }
}
```

### Test di Feature

Testare i flussi completi:

```php
namespace Modules\Patient\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientRegistrationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_can_register_a_new_patient()
    {
        $response = $this->post(route('patient.store'), [
            'name' => 'Mario',
            'surname' => 'Rossi',
            'fiscal_code' => 'RSSMRA80A01H501U',
            'birth_date' => '1980-01-01',
            'gender' => 'M',
            'email' => 'mario.rossi@example.com',
            'phone' => '3331234567',
            // Altri campi
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('patients', [
            'name' => 'Mario',
            'surname' => 'Rossi',
            'fiscal_code' => 'RSSMRA80A01H501U',
        ]);
    }
    
    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->post(route('patient.store'), [
            // Campi mancanti
        ]);
        
        $response->assertSessionHasErrors(['name', 'surname', 'fiscal_code']);
    }
}
```

## Risoluzione dei Problemi Comuni

### Conflitto tra Componenti Blade e Livewire

**Problema**: Errori quando entrambe le implementazioni del wizard (Blade e Livewire) sono attive.

**Soluzione**: Utilizzare solo una delle due implementazioni alla volta, modificando il template `create.blade.php`:

```php
// Per utilizzare il componente Blade
<x-patient::patient-registration-wizard />

// Per utilizzare il componente Livewire
<livewire:patient.registration-wizard />
```

### Errori di Validazione non Visualizzati

**Problema**: Gli errori di validazione non vengono visualizzati nel form.

**Soluzione**: Assicurarsi che il componente visualizzi correttamente gli errori:

```php
@error('field_name')
    <span class="text-red-500 text-sm">{{ $message }}</span>
@enderror
```

### Problemi con il Salvataggio dei Dati in Sessione

**Problema**: I dati non vengono mantenuti durante la navigazione tra gli step.

**Soluzione**: Verificare la configurazione della sessione e il funzionamento del metodo `saveDraft`:

```php
public function saveDraft(Request $request)
{
    $patientData = $request->session()->get('patient_data', []);
    $patientData = array_merge($patientData, $request->except('_token'));
    $request->session()->put('patient_data', $patientData);
    
    // Aggiungere log per debug
    \Log::debug('Dati salvati in sessione', $patientData);
    
    return response()->json(['success' => true]);
}
```

## Performance e Ottimizzazione

### Ottimizzazione delle Query

Utilizzare eager loading per evitare il problema N+1:

```php
$patients = Patient::with(['documents', 'anamnesis'])->paginate(15);
```

### Caching

Implementare il caching per le query frequenti:

```php
$patients = Cache::remember('patients_page_'.$page, 60*5, function () use ($page) {
    return Patient::paginate(15, ['*'], 'page', $page);
});
```

### Ottimizzazione JavaScript

Minimizzare il JavaScript per migliorare i tempi di caricamento:

```bash
npm run production
```

## Sicurezza

### Validazione Lato Server

Assicurarsi che tutti i dati siano validati lato server, indipendentemente dalla validazione client:

```php
$validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'fiscal_code' => 'required|string|size:16|unique:patients,fiscal_code',
    // Altri campi
]);
```

### Protezione CSRF

Includere sempre il token CSRF nei form:

```php
@csrf
```

### Autorizzazione

Implementare policy per controllare l'accesso ai dati dei pazienti:

```php
namespace Modules\Patient\Policies;

use App\Models\User;
use Modules\Patient\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;
    
    public function view(User $user, Patient $patient)
    {
        return $user->hasPermissionTo('view patients');
    }
    
    public function create(User $user)
    {
        return $user->hasPermissionTo('create patients');
    }
    
    // Altri metodi
}
```

## Conclusioni

Seguendo queste linee guida, gli sviluppatori possono estendere e personalizzare il modulo Patient in modo coerente con gli standard del progetto SaluteOra. Per ulteriori informazioni o assistenza, consultare la documentazione generale del progetto o contattare il team di sviluppo.
