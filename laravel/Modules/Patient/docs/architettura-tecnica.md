# Architettura Tecnica del Modulo Patient

## Struttura del Modulo

Il modulo Patient segue l'architettura modulare di Laravel con l'integrazione di Filament per l'interfaccia amministrativa. La struttura è organizzata secondo i principi SOLID e utilizza pattern moderni di sviluppo PHP.

```
Modules/Patient/
├── app/
│   ├── Console/
│   ├── Filament/
│   │   ├── Resources/
│   │   └── Widgets/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Livewire/
│   ├── Models/
│   ├── Providers/
│   └── View/
│       └── Components/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   ├── pages/
│   │   └── widgets/
│   └── lang/
└── routes/
    ├── api.php
    └── web.php
```

## Componenti Principali

### Models

I modelli rappresentano le entità principali del modulo e definiscono le relazioni tra di esse.

#### Patient

```php
namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'fiscal_code',
        'birth_date',
        'gender',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'province',
        'country',
        'is_pregnant',
        'isee_code',
        'isee_value',
        'isee_expiry_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_pregnant' => 'boolean',
        'isee_value' => 'decimal:2',
        'isee_expiry_date' => 'date',
    ];

    // Relazioni
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function anamnesis(): HasMany
    {
        return $this->hasMany(Anamnesis::class);
    }
}
```

### Controllers

I controller gestiscono le richieste HTTP e implementano la logica di business.

#### PatientController

```php
namespace Modules\Patient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Patient\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::paginate(15);
        return view('patient::pages.patient.index', compact('patients'));
    }

    public function create(Request $request)
    {
        $currentStep = $request->query('step', 1);
        $patientData = $request->session()->get('patient_data', []);
        
        return view('patient::pages.patient.create', compact('currentStep', 'patientData'));
    }

    public function store(Request $request)
    {
        // Validazione
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'fiscal_code' => 'required|string|size:16|unique:patients,fiscal_code',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'email' => 'required|email|max:255|unique:patients,email',
            'phone' => 'required|string|max:255',
            // Altri campi
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Creazione del paziente
        $patient = Patient::create($validator->validated());
        
        // Pulizia della sessione
        $request->session()->forget('patient_data');
        
        return redirect()->route('patient.show', $patient->id)
            ->with('success', 'Paziente registrato con successo!');
    }

    public function saveDraft(Request $request)
    {
        // Salvataggio temporaneo dei dati
        $patientData = $request->session()->get('patient_data', []);
        $patientData = array_merge($patientData, $request->except('_token'));
        $request->session()->put('patient_data', $patientData);
        
        return response()->json(['success' => true]);
    }

    // Altri metodi
}
```

### View Components

I componenti di vista incapsulano la logica di presentazione e rendono il codice più modulare.

#### PatientRegistrationWizard

```php
namespace Modules\Patient\View\Components;

use Illuminate\View\Component;

class PatientRegistrationWizard extends Component
{
    public int $totalSteps = 4;
    public int $currentStep = 1;
    public array $patientData = [];
    public bool $isSubmitted = false;
    
    public function __construct(int $currentStep = 1, array $patientData = [])
    {
        $this->currentStep = $currentStep;
        $this->patientData = $patientData;
    }

    public function render()
    {
        return view('patient::components.patient-registration-wizard');
    }
    
    public function getStepTitle(): string
    {
        return match($this->currentStep) {
            1 => 'Dati Anagrafici',
            2 => 'Contatti e Indirizzo',
            3 => 'Dati ISEE',
            4 => 'Conferma Dati',
            default => 'Registrazione Paziente',
        };
    }
    
    public function getStepDescription(): string
    {
        return match($this->currentStep) {
            1 => 'Inserisci i tuoi dati personali',
            2 => 'Inserisci i tuoi contatti e il tuo indirizzo',
            3 => 'Inserisci i dati relativi all\'ISEE (opzionale)',
            4 => 'Verifica i dati inseriti e conferma',
            default => 'Compila tutti i campi per completare la registrazione',
        };
    }
}
```

### Filament Resources

Le risorse Filament definiscono l'interfaccia amministrativa per la gestione dei pazienti.

#### PatientResource

```php
namespace Modules\Patient\Filament\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Modules\Patient\Models\Patient;
use Modules\Xot\Filament\Resources\XotBaseResource;

class PatientResource extends XotBaseResource
{
    protected static ?string $model = Patient::class;
    
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255),
            'surname' => TextInput::make('surname')
                ->required()
                ->maxLength(255),
            'fiscal_code' => TextInput::make('fiscal_code')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(16),
            'birth_date' => DatePicker::make('birth_date')
                ->required(),
            'gender' => Select::make('gender')
                ->options([
                    'M' => 'Maschio',
                    'F' => 'Femmina',
                    'O' => 'Altro',
                ])
                ->required(),
            // Altri campi
        ];
    }
    
    public static function getListTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'surname' => TextColumn::make('surname')
                ->searchable()
                ->sortable(),
            'fiscal_code' => TextColumn::make('fiscal_code')
                ->searchable(),
            'email' => TextColumn::make('email')
                ->searchable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            // Altri campi
        ];
    }
}
```

### Filament Widgets

I widget Filament forniscono funzionalità aggiuntive nell'interfaccia amministrativa.

#### PatientRegistrationWizard (Filament)

```php
namespace Modules\Patient\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Livewire\Component;
use Modules\Patient\Models\Patient;

class PatientRegistrationWizard extends Component
{
    use InteractsWithForms;
    
    public ?array $data = [];
    protected ?Form $form = null;
    
    public function mount(): void
    {
        $this->form = $this->form(new Form());
        $this->form->fill($this->data);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }
    
    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('Dati Personali')
                    ->icon('heroicon-o-user')
                    ->description('Inserisci i tuoi dati personali')
                    ->schema([
                        // Form fields
                    ]),
                // Altri step
            ])
        ];
    }
    
    public function submit(): void
    {
        $data = $this->form->getState();
        
        $patient = Patient::create($data);
        
        $this->dispatch('patient-registered', patientId: $patient->id);
    }
    
    public function render()
    {
        return view('patient::widgets.patient-registration-wizard');
    }
}
```

## Service Provider

Il service provider registra i componenti del modulo e configura le dipendenze.

```php
namespace Modules\Patient\Providers;

use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Modules\Patient\Filament\Widgets\PatientRegistrationWizard;
use Modules\Xot\Providers\XotBaseServiceProvider;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
    public string $nameLower = 'patient';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'patient');

        // Registrazione dei componenti Blade
        Blade::componentNamespace('Modules\\Patient\\View\\Components', 'patient');

        if (class_exists(Livewire::class)) {
            Livewire::component('patient.registration-wizard', PatientRegistrationWizard::class);
        }
    }
}
```

## Routing

Le rotte definiscono i punti di accesso alle funzionalità del modulo.

```php
// routes/web.php
use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\PatientController;

Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('index');
    Route::get('/create', [PatientController::class, 'create'])->name('create');
    Route::post('/store', [PatientController::class, 'store'])->name('store');
    Route::get('/{patient}', [PatientController::class, 'show'])->name('show');
    Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('edit');
    Route::put('/{patient}', [PatientController::class, 'update'])->name('update');
    Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('destroy');
    
    // Rotta per il salvataggio temporaneo dei dati del wizard
    Route::post('/save-draft', [PatientController::class, 'saveDraft'])->name('save-draft');
});
```

## Diagramma delle Relazioni

```
+----------------+       +----------------+       +----------------+
|    Patient     |       |    Document    |       |   Anamnesis    |
+----------------+       +----------------+       +----------------+
| id             |       | id             |       | id             |
| name           |       | patient_id     |       | patient_id     |
| surname        |       | title          |       | description    |
| fiscal_code    |       | file_path      |       | date           |
| birth_date     |       | type           |       | doctor_id      |
| gender         |       | created_at     |       | created_at     |
| email          |       | updated_at     |       | updated_at     |
| phone          |       +----------------+       +----------------+
| address        |              ^                        ^
| city           |              |                        |
| postal_code    |              |                        |
| province       |              |                        |
| country        |              |                        |
| is_pregnant    |              |                        |
| isee_code      |              |                        |
| isee_value     |--------------+------------------------+
| isee_expiry_date|
| created_at     |
| updated_at     |
+----------------+
```

## Implementazione del Wizard

Il wizard di registrazione pazienti è implementato utilizzando due approcci complementari:

1. **Componente Blade**: Utilizza l'approccio tradizionale con JavaScript per la gestione della navigazione
2. **Componente Livewire/Filament**: Utilizza Filament Forms e Livewire per una gestione più avanzata

Entrambi gli approcci condividono la stessa logica di business ma differiscono nell'implementazione tecnica.

### Flusso di Esecuzione

1. L'utente accede alla pagina di registrazione (`PatientController@create`)
2. Il controller carica la vista con il componente appropriato (Blade o Livewire)
3. L'utente compila i dati nel primo step e procede
4. I dati vengono validati e salvati temporaneamente
5. L'utente naviga attraverso tutti gli step
6. Al completamento, i dati vengono validati e salvati definitivamente
7. L'utente viene reindirizzato alla pagina del paziente appena creato

## Considerazioni sulla Sicurezza

- **Validazione Rigorosa**: Tutti i dati in ingresso sono validati sia lato client che lato server
- **Protezione CSRF**: Implementata tramite i middleware di Laravel
- **Autorizzazione**: Controlli di accesso per garantire che solo gli utenti autorizzati possano gestire i pazienti
- **Dati Sensibili**: Particolare attenzione alla gestione dei dati ISEE e delle informazioni personali

## Performance

- **Caricamento Lazy**: Le relazioni vengono caricate solo quando necessario
- **Caching**: Implementato per le query frequenti
- **Ottimizzazione Database**: Indici sulle colonne più utilizzate nelle ricerche

## Conclusioni

L'architettura del modulo Patient è progettata per essere modulare, estensibile e manutenibile. Seguendo i principi SOLID e le best practices di Laravel, il modulo fornisce una solida base per la gestione dei pazienti all'interno dell'applicazione SaluteOra.
