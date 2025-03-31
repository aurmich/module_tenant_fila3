# Stato Attuale dell'Implementazione

## Architettura e Infrastruttura

### Completato ✅

- **Struttura di base Laravel**:
  - Installazione Laravel nella directory corretta (`/var/www/html/saluteora/laravel`)
  - Configurazione dell'ambiente di sviluppo
  - Integrazione del pacchetto `nwidart/laravel-modules` per la gestione modulare

- **Implementazione moduli Laraxot**:
  - Integrazione di tutti i moduli core:
    - **Xot**: Modulo base con utility e configurazioni core
    - **Lang**: Gestione multilingua
    - **Tenant**: Supporto multi-tenant
    - **User**: Gestione utenti e autenticazione
  - Integrazione dei moduli frontend:
    - **UI**: Interfaccia utente base
    - **ThemeOne**: Tema per Filament 3
  - Integrazione dei moduli funzionali:
    - **Media**: Gestione media e file
    - **Activity**: Logging e monitoraggio attività
    - **Gdpr**: Gestione privacy e GDPR
    - **Notify**: Sistema di notifiche
    - **Cms**: Gestione contenuti 
    - **Job**: Gestione job in background
    - **Chart**: Visualizzazione dati e statistiche
  - Integrazione dei moduli specifici:
    - **Patient**: Gestione delle pazienti gestanti

- **Repository Git**:
  - Struttura repository configurata
  - Integrazioni moduli via git subtree
  - Risoluzione conflitti di nomenclatura (CMS vs Cms)

### In corso ⏳

- **Risoluzione problemi autoloading**:
  - Conflitti di namespace tra moduli (es. Gdpr e UI)
  - Classi non conformi a PSR-4
  - Classi duplicate tra moduli con implementazioni differenti

- **Configurazione moduli**:
  - Pubblicazione configurazioni moduli
  - Registrazione service provider
  - Esecuzione delle migrazioni database

- **Integrazione Filament**:
  - Installazione di Filament 3
  - Configurazione pannelli multi-ruolo (admin, dentista, paziente)
  - Integrazione tema personalizzato ThemeOne

### Criticità 🚫

- **Conflitti di classe**: Diverse classi sono definite in più moduli causando ambiguità nel sistema di autoloading, in particolare:
  - `App\Models\BaseModel` presente in più moduli
  - `App\Services\RouteService` con implementazioni differenti
  - Conflitti tra `Modules\Gdpr\Models\Consent` e `Modules\User\Models\Consent`

- **Problemi di compatibilità**: Incompatibilità tra versioni dei moduli Laraxot e Laravel 12, con errori durante l'esecuzione dei comandi artisan

- **Service provider non registrati**: I service provider dei moduli non sono correttamente registrati in `config/app.php`, impedendo l'inizializzazione delle funzionalità

- **Non conformità PSR-4**: Diversi file presentano namespace non allineati con la loro posizione nel filesystem, causando errori di autoloading

## Documentazione

### Completato ✅

- **Documentazione dell'architettura**:
  - Struttura directory e moduli
  - Integrazione moduli Laraxot
  - Analisi dei problemi incontrati

- **Documentazione dei requisiti**:
  - Analisi del progetto SaluteOra
  - Requisiti funzionali per gestanti, odontoiatri e back office
  - Requisiti GDPR e privacy con analisi dettagliata dei flussi dati
  - Analisi di Privacy by Design e Privacy by Default

- **Roadmap implementativa**:
  - Definizione delle fasi di implementazione backend
  - Definizione delle fasi di implementazione frontend
  - Documentazione dei flussi utente critici
  - Piano di implementazione GDPR
  - Tempistiche e priorità

### In corso ⏳

- **Roadmap implementativa**:
  - Creazione struttura roadmap
  - Documentazione attività completate e da completare

### Criticità 🚫

- **Mancanza di documentazione tecnica dettagliata** per ogni modulo
- **Assenza di documentazione API** per l'integrazione tra moduli

## Database e Modelli

### Completato ✅

- **Struttura database**:
  - Configurazione connessione
  - Schema modulare

### In corso ⏳

- **Migrazioni**:
  - Migrazioni non ancora eseguite per i moduli integrati

### Criticità 🚫

- **Conflitti potenziali** tra migrazioni di moduli diversi
- **Schema per il multi-tenancy** da finalizzare

## Frontend

### Completato ✅

- **Integrazione moduli UI e ThemeOne**:
  - Struttura base dell'interfaccia utente
  - Tema compatibile con Filament 3
  - Preparazione componenti base

### In corso ⏳

- **Configurazione Filament**:
  - Installazione Filament 3
  - Preparazione pannelli multi-ruolo (admin, dentist, patient)
  - Integrazione tema personalizzato ThemeOne

### Da implementare 🚫

- **Interfaccia pubblica** (come da mockup in progetto.md):
  - Homepage informativa con spiegazione progetto e requisiti
  - Form registrazione pazienti multi-step (dati anagrafici, documenti, questionario, consensi)
  - Mappa/ricerca odontoiatri per area geografica
  - Sistema prenotazione appuntamenti con selezione slot

- **Dashboard pazienti**:
  - Visualizzazione stato richiesta iscrizione
  - Gestione appuntamenti (prenotazione, visualizzazione, storico)
  - Centro notifiche (conferme, rifiuti, promemoria)
  - Gestione consensi GDPR e richieste diritti

- **Dashboard odontoiatri**:
  - Configurazione disponibilità oraria e dettagli studio
  - Gestione richieste appuntamenti (accettazione/rifiuto motivato)
  - Visualizzazione appuntamenti confermati con memo
  - Compilazione referti post-visita
  - Gestione richieste rimborso e fatturazione

- **Dashboard back office**:
  - Verifica registrazioni pazienti e odontoiatri
  - Gestione rimborsi con approvazione/rifiuto
  - Sistema avvisi al superamento soglie
  - Reportistica e statistiche personalizzabili
  - Esportazione dati in vari formati

## Backend

### Completato ✅

- **Struttura modulare**:
  - Impostazione ambiente Laravel
  - Installazione Laravel Modules
  - Integrazione completa moduli Laraxot
  - Risoluzione conflitto duplicazione CMS/Cms

### In corso ⏳

- **Risoluzione problemi tecnici**:
  - Correzione namespace non conformi a PSR-4
  - Risoluzione conflitti tra classi duplicate
  - Configurazione service provider in app.php
  - Preparazione migrazioni database

### Da implementare 🚫

- **Autenticazione multi-ruolo**:
  - Sistema di registrazione gestanti con verifica documenti
  - Sistema di registrazione odontoiatri con approvazione back office
  - Autenticazione personale back office con 2FA
  - Gestione permessi granulari per funzionalità

- **API per frontend**:
  - Endpoint RESTful per gestione gestanti (CRUD, ricerca)
  - Endpoint RESTful per gestione odontoiatri (CRUD, disponibilità)
  - Endpoint RESTful per gestione appuntamenti
  - Endpoint RESTful per gestione rimborsi
  - Endpoint per reportistica e statistiche

- **Implementazione Multi-tenant**:
  - Configurazione database con schema dedicato per tenant
  - Middleware identificazione tenant per routing corretto
  - Isolamento dati tra studi odontoiatrici
  - Sistema centralizzato per dati condivisi

- **Sistema GDPR**:
  - Implementazione registro trattamenti (Art. 30)
  - Sistema consensi informati con tracking versioni
  - Implementazione diritti interessati (accesso, rettifica, cancellazione)
  - Esportazione dati in formato portabile
  - Pseudonimizzazione e anonimizzazione
  - Logging attività GDPR per accountability
  - Definizione periodi di retention dati

## Prossimi Passi (Priorità Alta - P0)

1. **Risolvere conflitti di classe e problemi di autoloading**:
   - Eseguire analisi completa dei namespace con script dedicato
   - Correggere tutti i file non conformi a PSR-4
   - Risolvere i conflitti tra classi duplicate con stessa funzionalità
   - Aggiornare composer.json per garantire corretto autoloading
   - Verificare la risoluzione con test di caricamento
   - *Documentazione completa: `/var/www/html/saluteora/docs/tecnico/01-risoluzione-problemi-autoloading.md`*

2. **Configurare service provider**:
   - Registrare tutti i service provider necessari in config/app.php
   - Rispettare l'ordine corretto in base alle dipendenze dei moduli
   - Pubblicare le configurazioni dei moduli
   - Verificare la corretta inizializzazione con test appositi
   - *Documentazione completa: `/var/www/html/saluteora/docs/tecnico/02-configurazione-service-provider.md`*

3. **Eseguire migrazioni database**:
   - Pubblicare le migrazioni di tutti i moduli
   - Risolvere eventuali conflitti tra migrazioni
   - Eseguire le migrazioni in ordine corretto
   - Verificare la struttura del database risultante
   - Preparare i seeder per i dati iniziali

4. **Implementare core GDPR**:
   - Configurare il modulo GDPR di Laraxot per SaluteOra
   - Implementare il registro dei trattamenti specifico per il progetto
   - Sviluppare il sistema di consensi informati multi-livello
   - Implementare funzionalità per esercizio diritti interessati
   - *Documentazione completa: `/var/www/html/saluteora/docs/tecnico/03-implementazione-gdpr-core.md`*

5. **Installare e configurare Filament**:
   - Aggiungere pacchetto Filament 3
   - Configurare i pannelli multi-ruolo (admin, dentist, patient)
   - Integrare il tema personalizzato ThemeOne
   - Sviluppare le prime risorse Filament per test
   - Verificare la corretta integrazione con i moduli Laraxot
