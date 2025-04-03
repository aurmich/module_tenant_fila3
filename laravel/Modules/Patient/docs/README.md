# Modulo Patient - SaluteOra

## Panoramica

Il modulo Patient gestisce tutte le funzionalità relative ai pazienti all'interno dell'applicazione SaluteOra, con particolare attenzione alle gestanti che partecipano al programma di salute orale. Il modulo implementa un sistema completo per la registrazione, gestione e monitoraggio dei pazienti.

## Funzionalità Principali

- Registrazione pazienti tramite wizard multi-step
- Gestione dati anagrafici e contatti
- Gestione informazioni ISEE
- Visualizzazione e modifica dati paziente
- Validazione dati in tempo reale

## Architettura

Il modulo Patient segue l'architettura modulare di Laravel con l'integrazione di Filament per l'interfaccia amministrativa. La struttura del modulo è organizzata secondo i principi SOLID e utilizza pattern moderni di sviluppo PHP.

### Componenti Principali

- **Models**: Definiscono la struttura dei dati e le relazioni
- **Controllers**: Gestiscono le richieste HTTP e la logica di business
- **Views/Components**: Implementano l'interfaccia utente
- **Resources**: Definiscono le risorse Filament per l'amministrazione

## Wizard di Registrazione Pazienti

Una delle funzionalità principali del modulo è il wizard di registrazione pazienti, che guida l'utente attraverso un processo strutturato in più step per la raccolta completa dei dati necessari.

### Implementazione

Il wizard è implementato utilizzando due approcci complementari:

1. **Componente Blade**: `PatientRegistrationWizard` che gestisce la visualizzazione e la navigazione tra gli step
2. **Componente Livewire/Filament**: Implementazione alternativa che utilizza Filament Forms per una gestione più avanzata dei form

### Struttura del Wizard

Il wizard è strutturato in 4 step principali:

1. **Dati Anagrafici**: Raccolta informazioni personali di base (nome, cognome, codice fiscale, data di nascita)
2. **Contatti e Indirizzo**: Raccolta informazioni di contatto e residenza
3. **Dati ISEE** (opzionale): Raccolta informazioni relative all'ISEE
4. **Riepilogo e Conferma**: Visualizzazione riepilogativa dei dati inseriti e conferma finale

### Validazione

Il wizard implementa una validazione progressiva dei dati:

- Validazione lato client tramite JavaScript per feedback immediato
- Validazione lato server tramite Laravel Validator per garantire l'integrità dei dati
- Controlli specifici per campi critici come il codice fiscale e l'email

### Persistenza dei Dati

Durante la navigazione tra gli step, i dati vengono temporaneamente salvati utilizzando:

- Sessione Laravel per mantenere lo stato tra le richieste
- Chiamate AJAX per il salvataggio in background senza interruzioni dell'esperienza utente

## Integrazione con Filament

Il modulo Patient è completamente integrato con Filament per fornire un'interfaccia amministrativa avanzata:

- **PatientResource**: Gestisce la visualizzazione e modifica dei pazienti nell'area amministrativa
- **Widgets**: Fornisce dashboard e widget informativi per il monitoraggio dei pazienti

## Best Practices Implementate

- **Tipizzazione Stretta**: Utilizzo di tipi PHP 8.2+ per garantire robustezza del codice
- **Validazione Rigorosa**: Controlli approfonditi sui dati in ingresso
- **Separazione delle Responsabilità**: Ogni componente ha una responsabilità ben definita
- **Codice Leggibile**: Nomi di variabili e metodi descrittivi, commenti dove necessario
- **Gestione Errori**: Implementazione di una gestione errori robusta con messaggi chiari

## Configurazione

Il modulo Patient può essere configurato tramite il file `config/patient.php` che permette di personalizzare vari aspetti del comportamento del modulo.

## Sviluppi Futuri

- Implementazione di un sistema di appuntamenti integrato
- Miglioramento dell'integrazione con altri moduli (es. Dental)
- Aggiunta di funzionalità di reportistica avanzata
- Implementazione di notifiche automatiche per follow-up
