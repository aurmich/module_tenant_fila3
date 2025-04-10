# Gestione Trattamenti Odontoiatrici per Pazienti in Gravidanza

Questo documento descrive le funzionalità implementate per la gestione dei trattamenti odontoiatrici per pazienti in gravidanza nel modulo Dental.

## Panoramica

La gravidanza è un periodo particolare che richiede attenzioni specifiche anche in ambito odontoiatrico. Alcuni trattamenti dentali possono essere sicuri durante la gravidanza, mentre altri potrebbero comportare rischi per la madre o il feto. Il modulo Dental è stato esteso per supportare la gestione dei trattamenti odontoiatrici per pazienti in gravidanza, fornendo strumenti per identificare quali trattamenti sono sicuri e quali dovrebbero essere evitati.

## Funzionalità Implementate

### 1. Modello Treatment

Il modello `Treatment` è stato esteso con le seguenti funzionalità:

- Campo `is_pregnancy_safe` per indicare se un trattamento è sicuro per pazienti in gravidanza
- Metodo `isSafeForPregnancy()` per verificare se un trattamento è sicuro per pazienti in gravidanza
- Metodo `hasPregnantPatient()` per verificare se il paziente associato è in gravidanza
- Scope `scopeSafeForPregnancy()` per filtrare i trattamenti sicuri per la gravidanza

### 2. Service PregnancyTreatmentService

È stato creato un service dedicato `PregnancyTreatmentService` che fornisce le seguenti funzionalità:

- Verifica se un paziente è in gravidanza
- Ottiene i dettagli della gravidanza di un paziente
- Verifica se un trattamento è sicuro per una paziente in gravidanza
- Ottiene i trattamenti raccomandati per pazienti in gravidanza
- Ottiene i trattamenti da evitare durante la gravidanza
 - Ottiene raccomandazioni specifiche per il trimestre di gravidanza
s
### 3. Risorse Filament per la Gestione della Gravidanza

Le funzionalità per la gestione dei trattamenti in gravidanza sono implementate attraverso le risorse Filament, che forniscono un'interfaccia amministrativa completa. Queste risorse si trovano in `Modules\Dental\Filament\Resources` e includono:

- Form per la verifica della sicurezza dei trattamenti per pazienti in gravidanza
- Widget per visualizzare raccomandazioni specifiche per il trimestre
- Azioni personalizzate per la gestione dei trattamenti in gravidanza
- Filtri per mostrare solo i trattamenti sicuri durante la gravidanza

Le funzionalità sono accessibili tramite l'interfaccia amministrativa di Filament, che sostituisce le tradizionali API REST esposte dai controller.

## Trattamenti Sicuri per la Gravidanza

I seguenti tipi di trattamenti sono considerati sicuri per pazienti in gravidanza:

- `check-up`: Controllo odontoiatrico di routine
- `cleaning`: Pulizia dentale professionale
- `emergency`: Trattamento di emergenza per dolore o infezione
- `consultation`: Consulenza odontoiatrica
- `preventive`: Trattamenti preventivi (fluorizzazione)

## Trattamenti da Evitare Durante la Gravidanza

I seguenti tipi di trattamenti dovrebbero essere evitati durante la gravidanza, a meno che non siano assolutamente necessari:

- `whitening`: Sbiancamento dentale
- `implant`: Impianti dentali
- `orthodontic`: Trattamenti ortodontici complessi
- `root_canal`: Trattamento canalare non urgente
- `extraction`: Estrazione dentale non urgente

## Raccomandazioni per Trimestre

### Primo Trimestre

- Evitare radiografie non urgenti
- Informare il dentista della gravidanza
- Monitorare eventuali cambiamenti gengivali

### Secondo Trimestre

- Periodo ideale per trattamenti dentali necessari
- Mantenere un'igiene orale rigorosa
- Possibile aumento dell'infiammazione gengivale

### Terzo Trimestre

- Evitare procedure lunghe e scomode
- Posizionamento attento sulla poltrona odontoiatrica
- Rimandare trattamenti non urgenti dopo il parto

## Integrazione con il Modulo Patient

Il modulo Dental si integra con il modulo Patient per accedere ai dati relativi alla gravidanza delle pazienti. Il modello `Pregnancy` del modulo Patient viene utilizzato per verificare se una paziente è in gravidanza e per ottenere informazioni sul trimestre di gravidanza.

## Utilizzo

### Esempio di Utilizzo nel Codice

```php
// Verifica se un trattamento è sicuro per una paziente in gravidanza
$treatment = Treatment::find($id);
if ($treatment->hasPregnantPatient() && !$treatment->isSafeForPregnancy()) {
    // Mostra avviso
}

// Ottieni raccomandazioni specifiche per una paziente
$pregnancyService = app(PregnancyTreatmentService::class);
$recommendations = $pregnancyService->getPatientSpecificRecommendations($patientId);
```

### Esempio di Utilizzo in Filament

```php
// Esempio di filtro in una risorsa Filament per mostrare solo trattamenti sicuri in gravidanza
Filters::make()
    ->schema([
        Filter::make('pregnancy_safe')
            ->label('Sicuri in gravidanza')
            ->query(fn (Builder $query): Builder => $query->safeForPregnancy())
    ])

// Esempio di azione in una risorsa Filament per verificare la sicurezza di un trattamento
Action::make('checkPregnancySafety')
    ->label('Verifica sicurezza in gravidanza')
    ->action(function (Treatment $record) {
        if ($record->isSafeForPregnancy()) {
            Notification::make()->success()->title('Trattamento sicuro per pazienti in gravidanza')->send();
        } else {
            Notification::make()->danger()->title('Trattamento non raccomandato durante la gravidanza')->send();
        }
    })
```