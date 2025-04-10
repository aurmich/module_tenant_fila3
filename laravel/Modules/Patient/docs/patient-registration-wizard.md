# Wizard di Registrazione Pazienti

## Panoramica

Il Wizard di Registrazione Pazienti è un componente chiave del modulo Patient che guida gli utenti attraverso un processo strutturato per la raccolta completa e accurata dei dati dei pazienti. Progettato seguendo i principi di UX moderni, il wizard semplifica un processo complesso suddividendolo in passaggi logici e sequenziali.

## Architettura del Componente

Il wizard è implementato utilizzando due approcci complementari che possono essere utilizzati in base alle esigenze specifiche:

### 1. Componente Blade

```
Modules\Patient\View\Components\PatientRegistrationWizard
```

Questo componente utilizza l'approccio tradizionale di Laravel Blade con JavaScript per la gestione della navigazione e validazione. È ideale per implementazioni leggere e personalizzate.

#### Caratteristiche principali:
- Implementazione leggera senza dipendenze esterne
- Controllo completo sul markup HTML e sul comportamento JavaScript
- Validazione client-side personalizzata
- Salvataggio progressivo dei dati tramite AJAX

### 2. Componente Livewire/Filament

```
Modules\Patient\Filament\Widgets\PatientRegistrationWizard
```

Questo componente utilizza Filament Forms e Livewire per una gestione più avanzata dei form con funzionalità reactive. È ideale per integrazioni con il pannello di amministrazione Filament.

#### Caratteristiche principali:
- Integrazione nativa con l'ecosistema Filament
- Reattività automatica dei form tramite Livewire
- Validazione integrata di Laravel/Filament
- Componenti form avanzati (date picker, select, ecc.)

## Struttura del Wizard

Il wizard è strutturato in 4 step principali, ciascuno progettato per raccogliere un insieme logico di informazioni:

### Step 1: Dati Anagrafici
- Nome e Cognome
- Codice Fiscale (con validazione formato)
- Data di Nascita
- Genere

### Step 2: Contatti e Indirizzo
- Email (con validazione formato e unicità)
- Telefono
- Indirizzo completo (via, città, CAP, provincia)
- Paese

### Step 3: Dati ISEE (opzionale)
- Codice ISEE
- Valore ISEE
- Data di scadenza ISEE

### Step 4: Riepilogo e Conferma
- Visualizzazione riepilogativa di tutti i dati inseriti
- Accettazione privacy e termini di servizio
- Conferma finale e invio

## Implementazione Tecnica

### Gestione dello Stato

Il wizard mantiene lo stato tra i vari step utilizzando:

1. **Sessione Laravel**: Per il componente Blade, i dati vengono temporaneamente salvati in sessione
2. **Stato Livewire**: Per il componente Livewire, i dati vengono mantenuti nello stato del componente

### Validazione

La validazione avviene su più livelli:

#### Validazione Client-side
```javascript
function validateStep1() {
    var isValid = true;
    
    // Validazione nome
    if (!document.getElementById('name').value) {
        showError('name', 'Il nome è obbligatorio');
        isValid = false;
    }
    
    // Validazione codice fiscale
    var fiscalCode = document.getElementById('fiscal_code').value;
    if (!fiscalCode || !validateFiscalCode(fiscalCode)) {
        showError('fiscal_code', 'Codice fiscale non valido');
        isValid = false;
    }
    
    return isValid;
}
```

#### Validazione Server-side
```php
$validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'surname' => 'required|string|max:255',
    'fiscal_code' => 'required|string|size:16|unique:patients,fiscal_code',
    'birth_date' => 'required|date',
    'gender' => 'required|in:M,F,O',
    'email' => 'required|email|max:255|unique:patients,email',
    'phone' => 'required|string|max:255',
]);
```

### Navigazione tra gli Step

La navigazione è gestita tramite JavaScript per il componente Blade:

```javascript
function nextStep() {
    var currentStep = {{ $currentStep }};
    
    // Validazione dello step corrente
    if (!validateCurrentStep(currentStep)) {
        return false;
    }
    
    // Salvataggio dati
    saveFormData();
    
    // Navigazione al prossimo step
    window.location.href = "{{ route('patient.create') }}?step=" + (currentStep + 1);
}

function prevStep() {
    var currentStep = {{ $currentStep }};
    window.location.href = "{{ route('patient.create') }}?step=" + (currentStep - 1);
}
```

Per il componente Filament, la navigazione è gestita tramite il componente Wizard nativo:

```php
Wizard::make([
    Step::make('Dati Personali')
        ->icon('heroicon-o-user')
        ->description('Inserisci i tuoi dati personali')
        ->schema([
            // Form fields
        ]),
    Step::make('Indirizzo')
        ->icon('heroicon-o-home')
        ->description('Inserisci il tuo indirizzo')
        ->schema([
            // Form fields
        ]),
    // Other steps
])
```

### Salvataggio dei Dati

Il salvataggio finale dei dati avviene nel controller:

```php
public function store(Request $request)
{
    // Validazione
    $validator = Validator::make($request->all(), [
        // Validation rules
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
```

## Personalizzazione

Il wizard può essere personalizzato in diversi modi:

1. **Aggiunta di nuovi step**: Estendendo la logica esistente nel componente
2. **Modifica dei campi**: Aggiungendo o rimuovendo campi nei form
3. **Personalizzazione del layout**: Modificando i template Blade
4. **Logica di validazione**: Aggiungendo regole di validazione personalizzate

## Best Practices

Durante l'implementazione del wizard, sono state seguite queste best practices:

1. **Feedback immediato**: L'utente riceve feedback immediato sulla validità dei dati inseriti
2. **Persistenza dei dati**: I dati inseriti non vengono persi durante la navigazione
3. **Indicatori di progresso**: L'utente è sempre consapevole della sua posizione nel processo
4. **Validazione progressiva**: I dati vengono validati ad ogni step
5. **Design responsivo**: Il wizard funziona correttamente su dispositivi di diverse dimensioni

## Problemi Noti e Soluzioni

### Problema: Conflitto tra implementazioni Blade e Livewire

Avendo due implementazioni parallele (Blade e Livewire), possono verificarsi conflitti se entrambe sono attive contemporaneamente.

**Soluzione**: Utilizzare solo una delle due implementazioni alla volta, modificando il template `create.blade.php` per includere il componente desiderato:

```php
// Per utilizzare il componente Blade
<x-patient::patient-registration-wizard />

// Per utilizzare il componente Livewire
<livewire:patient.registration-wizard />
```

### Problema: Errori JavaScript in ambiente di sviluppo

Gli strumenti di lint possono segnalare errori nel JavaScript incorporato nei template Blade.

**Soluzione**: Questi errori sono spesso falsi positivi dovuti alla sintassi mista Blade/JavaScript. È possibile ignorarli se il codice funziona correttamente in produzione o estrarre il JavaScript in file separati.

## Sviluppi Futuri

- **Integrazione con sistema di appuntamenti**: Collegare la registrazione del paziente con la prenotazione del primo appuntamento
- **Upload documenti**: Aggiungere la possibilità di caricare documenti (es. ISEE, documenti di identità)
- **Autenticazione integrata**: Creare automaticamente un account utente per il paziente
- **Versione mobile ottimizzata**: Migliorare l'esperienza su dispositivi mobili
