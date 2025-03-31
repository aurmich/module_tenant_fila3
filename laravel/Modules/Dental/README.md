# Modulo Dental - SaluteOra

Questo modulo gestisce tutte le funzionalità relative ai servizi dentistici della piattaforma SaluteOra.

## Caratteristiche principali

### Gestione Appuntamenti
- Prenotazione appuntamenti con workflow multi-step
- Gestione dei dentisti e loro disponibilità
- Gestione dei trattamenti dentali
- Notifiche automatiche per appuntamenti

### Workflow Appuntamenti
Il sistema implementa un workflow completo per la gestione delle prenotazioni degli appuntamenti, che comprende i seguenti passi:

1. **Informazioni Paziente**: Selezione o conferma dei dati del paziente
2. **Selezione Dentista**: Scelta del dentista per l'appuntamento
3. **Selezione Data e Ora**: Definizione della data e dell'orario dell'appuntamento
4. **Definizione Trattamento**: Specifica del tipo di trattamento richiesto
5. **Conferma**: Revisione e conferma di tutte le informazioni

Ogni passo del workflow viene gestito tramite azioni dedicate utilizzando Spatie Laravel-Queueable-Action:
- `InitiateAppointmentWorkflowAction`: Inizializza un nuovo workflow
- `UpdateAppointmentWorkflowStepAction`: Aggiorna uno specifico passo del workflow
- `FinalizeAppointmentWorkflowAction`: Finalizza il workflow creando l'appuntamento

### Architettura Tecnica
L'intero modulo è stato sviluppato seguendo rigorosamente i principi architetturali di SaluteOra:

- **Backend/Backoffice**: Implementato esclusivamente con Filament
  - Nessun utilizzo di Blade nel backend
  - Form e interfacce gestiti con componenti nativi Filament
  - Pannelli di amministrazione per dentisti e personale

- **Logica di Business**: Implementata con Spatie Laravel-Queueable-Action
  - Nessun utilizzo di Job tradizionali
  - Azioni chiaramente separate e testabili
  - Support per esecuzione sia sincrona che asincrona

## Struttura del Modulo

```
Modules/Dental/
├── app/
│   ├── Actions/                      # Azioni Spatie per la logica di business
│   ├── Filament/                     # Risorse e componenti Filament
│   │   ├── Components/               # Componenti Filament riutilizzabili
│   │   └── Resources/                # Risorse Filament per i modelli
│   ├── Models/                       # Modelli Eloquent (Appointment, Dentist, etc.)
│   └── Providers/                    # Service providers
├── database/
│   └── migrations/                   # Migrazioni del database
├── config/                           # Configurazioni del modulo
└── routes/                           # Definizioni delle rotte (solo per API)
```

## Integrazione con Altri Moduli

- **Modulo Patient**: Per la gestione dei pazienti
- **Modulo Notify**: Per la gestione delle notifiche di appuntamento
- **Modulo User**: Per l'autenticazione e i permessi

## Funzionalità Pianificate

- Integrazione con sistema di pagamenti
- Sistema di recensioni per i dentisti
- Dashboard analitiche per monitoraggio appuntamenti
