# Roadmap Progetto SaluteOra

## Stato Attuale del Progetto

### Attività Completate
- [x] Definizione dei requisiti di sistema (25/03/2024)
- [x] Documentazione della struttura modulare (26/03/2024)
- [x] Analisi dei moduli necessari per il progetto (26/03/2024)
- [x] Documentazione sui pacchetti utilizzati (27/03/2024)
- [x] Documentazione sulla configurazione dei moduli (27/03/2024)
- [x] Documentazione sulla creazione di moduli custom (28/03/2024)

### Attività in Corso
- [ ] Setup dell'ambiente di sviluppo (in corso)
- [ ] Implementazione della struttura modulare base (in corso)
- [ ] Creazione della documentazione per gli sviluppatori (in corso)

### Prossimi Passi
- [ ] Integrazione dei moduli Laraxot (previsto: 2-3/04/2024)
- [ ] Configurazione dell'autenticazione con Filament (previsto: 4-5/04/2024)
- [ ] Setup del testing automatizzato (previsto: 6/04/2024)
- [ ] Deployment iniziale (previsto: 7/04/2024)
- [ ] Sviluppo dei moduli Patient e Dental (previsto: 10-20/04/2024)
- [ ] Implementazione interfaccia utente Filament (previsto: 20-30/04/2024)

## Piano di Implementazione

### Fase 1: Setup Ambiente e Struttura Base

Il progetto è attualmente nella Fase 1, che comprende l'impostazione dell'ambiente di sviluppo, la struttura modulare e la configurazione iniziale. Le attività dettagliate sono descritte in [01-setup-ambiente.md](./01-setup-ambiente.md).

#### Integrazione Moduli Laraxot

Per integrare i moduli core Laraxot, seguiremo questi passaggi:

1. Creazione della struttura Laravel con `composer create-project`
2. Installazione di Laravel Modules con `composer require nwidart/laravel-modules`
3. Configurazione corretta di `composer.json` per l'autoloading dei moduli
4. Importazione dei moduli Laraxot tramite git subtree:
   ```bash
   git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev
   git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev
   # Altri moduli...
   ```
5. Configurazione del file `module.json` per ogni modulo

#### Sviluppo Moduli Custom

Per lo sviluppo dei moduli custom (Patient, Dental, ISEE), seguiremo questi passaggi:

1. Creazione dei moduli con `php artisan module:make`
2. Definizione delle entità e relazioni nei modelli
3. Implementazione delle migrazioni per la struttura del database
4. Creazione delle risorse Filament per l'interfaccia amministrativa
5. Implementazione della logica di business nei service e controller
6. Creazione di API per l'integrazione con il frontend

#### GDPR e Privacy

Per garantire la conformità GDPR, implementeremo:

1. Sistema di consenso per i pazienti
2. Funzionalità di esportazione dati
3. Meccanismo di cancellazione dati
4. Registro dei trattamenti
5. Notifiche di violazione dei dati

### Fase 2: Gestione Dati

Nella Fase 2, ci focalizzeremo sull'implementazione della gestione dei dati. Le attività dettagliate sono descritte in [02-gestione-dati.md](./02-gestione-dati.md).

### Fase 3: Interfaccia Utente

Nella Fase 3, implementeremo l'interfaccia utente con Filament. Le attività dettagliate sono descritte in [03-interfaccia-utente.md](./03-interfaccia-utente.md).

### Fase 4: Reporting

Nella Fase 4, implementeremo le funzionalità di reporting. Le attività dettagliate sono descritte in [04-reporting.md](./04-reporting.md).

### Fase 5: Deployment

Nella Fase 5, ci occuperemo del deployment in produzione. Le attività dettagliate sono descritte in [05-deployment.md](./05-deployment.md).

## Completati (✅)
1. **Analisi dei Requisiti** - _Completato il 25/03/2024_
   - Definizione degli obiettivi di progetto
   - Analisi dei flussi di dati e privacy
   - Documentazione GDPR e requisiti legali
   - Definizione dei moduli necessari

2. **Setup Base** - _Completato il 27/03/2024_
   - Configurazione ambiente di sviluppo
   - Implementazione struttura modulare
   - Creazione documentazione tecnica
   - Definizione struttura dei moduli

3. **Analisi Approfondita** - _Completato il 27/03/2025_
   - Analisi dell'architettura del sistema
   - Analisi privacy e GDPR
   - Analisi dei flussi utente
   - Analisi tecnica implementativa
   - Analisi della sicurezza e protezione dati

## In Corso (🔄)
1. **Integrazione Moduli Laraxot** - _Iniziato il 27/03/2025, 45% completato_
   - Setup struttura per git subtree
      1. Creare la directory principale per i moduli: `mkdir -p laravel/Modules`
      2. Configurare .gitignore per escludere file temporanei e di sviluppo
      3. Preparare lo spazio di repository per l'integrazione dei moduli Laraxot
   - Integrazione modulo Xot
      1. Eseguire: `git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev`
      2. Verificare l'installazione con: `ls -la laravel/Modules/Xot`
      3. Aggiornare composer.json per includere l'autoloading del modulo
   - Integrazione moduli dipendenti
      1. Eseguire: `git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev`
      2. Eseguire: `git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev`
      3. Eseguire: `git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev`
   - Preparazione ambiente multi-tenant
      1. Configurare config/tenancy.php con le impostazioni adeguate
      2. Verificare le migrations del modulo Tenant
      3. Configurare middleware per l'identificazione tenant

2. **Implementazione modelli base** - _Iniziato il 27/03/2025, 30% completato_
   - Sviluppo Modulo Patient
      1. Creare la struttura base: `php artisan module:make Patient`
      2. Definire modelli in `Modules/Patient/app/Models/`
      3. Implementare il service provider estendendo XotBaseServiceProvider
      4. Configurare il file module.json con dipendenze corrette
   - Sviluppo Modulo Dental
      1. Creare la struttura base: `php artisan module:make Dental`
      2. Definire modelli in `Modules/Dental/app/Models/`
      3. Implementare il service provider estendendo XotBaseServiceProvider
      4. Configurare relazioni con il modulo Patient

## Prossimi Passi (⏱️)
1. **Autenticazione e Multi-tenant** - _Inizio previsto: 02/04/2025_
   - Implementazione multi-tenant
      1. Configurare il database per supportare multi-tenancy:
         ```php
         // config/database.php
         'tenant_connection' => [
             'driver' => 'mysql',
             'prefix' => '',
             'tenant_id_resolver' => \App\Resolvers\TenantIdResolver::class,
         ]
         ```
      2. Implementare il TenantIdResolver che gestisce l'identificazione dei tenant
      3. Creare middleware `TenantMiddleware` per assicurare l'isolamento dei dati
      4. Testare la separazione dei dati tra tenant
   - Configurazione ruoli e permessi con Spatie
      1. Integrare Spatie Permission: `composer require spatie/laravel-permission`
      2. Pubblicare le migrations: `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`
      3. Definire i ruoli di base nel seeder:
         ```php
         // Amministratore (Backoffice)
         Role::create(['name' => 'administrator']);
         // Odontoiatra
         Role::create(['name' => 'dentist']);
         // Paziente
         Role::create(['name' => 'patient']);
         ```
      4. Creare permessi specifici per ogni entità e operazione
      5. Configurare Filament per utilizzare i ruoli nelle policy
   - Implementazione GDPR e gestione consensi
      1. Creare modelli e tabelle per i consensi:
         ```bash
         php artisan module:make-migration create_user_consents_table GDPR
         ```
      2. Implementare processi di eliminazione dati conformi GDPR
      3. Implementare meccanismo di export dati personali
      4. Creare interfaccia di gestione consensi

2. **Interfaccia Utente con Filament** - _Inizio previsto: 09/04/2025_
   - Sviluppo pannelli specifici per ruolo
      1. Creare pannello amministrativo:
         ```php
         php artisan filament:panel admin
         ```
      2. Creare pannello odontoiatri:
         ```php
         php artisan filament:panel dentist
         ```
      3. Creare pannello pazienti:
         ```php
         php artisan filament:panel patient
         ```
      4. Configurare l'autenticazione specifica per pannello in `config/filament.php`
   - Implementazione widget personalizzati
      1. Creare widget calendario appuntamenti:
         ```bash
         php artisan filament:widget AppointmentCalendar --panel=dentist
         ```
      2. Creare widget statistiche dentista:
         ```bash
         php artisan filament:widget DentistStats --panel=dentist
         ```
      3. Creare widget richieste rimborso:
         ```bash
         php artisan filament:widget ReimbursementRequests --panel=admin
         ```
   - Creazione Filament Resources per le entità principali
      1. Creare Patient Resource:
         ```bash
         php artisan filament:resource Patient --module=Patient --generate
         ```
      2. Creare Visit Resource:
         ```bash
         php artisan filament:resource Visit --module=Dental --generate
         ```
      3. Implementare form complessi con validazione
      4. Configurare relazioni e selezioni in modal/select

## Moduli Principali
1. **Core (Xot)**
   - Gestione base del sistema
   - Configurazioni
   - Utility comuni
   - Service Provider di base

2. **Patient**
   - Gestione pazienti
   - Gestione ISEE
   - Anamnesi
   - Documenti e privacy

3. **Dental**
   - Gestione visite
   - Gestione trattamenti
   - Scheda clinica
   - Calendario

4. **Reporting**
   - Reportistica
   - Statistiche
   - Analisi dati
   - Export dati

5. **UI**
   - Componenti interfaccia Filament
   - Layout responsive
   - Temi e personalizzazione
   - Widget specializzati

6. **User**
   - Gestione utenti
   - Permessi (Spatie)
   - Ruoli
   - Autenticazione

7. **Tenant**
   - Gestione multi-tenant
   - Configurazioni tenant
   - Isolamento dati
   - Domain mapping

8. **GDPR**
   - Gestione consensi
   - Esportazione dati personali
   - Cancellazione dati
   - Registri trattamenti

## Piano di Implementazione Dettagliato

### 1. Integrazione Moduli Laraxot (Settimana 1-2)
- **Responsabile**: Team di sviluppo
- **Tempi**: 10 giorni lavorativi
- **Steps**:
  1. Clonare il repository base (Giorno 1)
  2. Setup ambiente Docker/locale (Giorno 1)
  3. Configurare composer.json per PSR-4 (Giorno 2)
  4. Integrare moduli core con git subtree (Giorni 3-4)
  5. Configurare service providers (Giorno 5)
  6. Testare funzionalità base (Giorni 6-7)
  7. Documentare l'installazione (Giorni 8-9)
  8. Revisione e correzioni (Giorno 10)

### 2. Sviluppo Moduli Custom (Settimana 3-4)
- **Responsabile**: Team di sviluppo
- **Tempi**: 10 giorni lavorativi
- **Steps**:
  1. Creare struttura modulo Patient (Giorni 1-2)
  2. Implementare migrations e modelli (Giorni 3-4)
  3. Creare struttura modulo Dental (Giorni 5-6)
  4. Implementare relationships tra moduli (Giorni 7-8)
  5. Testare modelli e relazioni (Giorni 9-10)

### 3. Autenticazione e Sicurezza (Settimana 5)
- **Responsabile**: Team di sviluppo
- **Tempi**: 5 giorni lavorativi
- **Steps**:
  1. Setup Filament Auth (Giorno 1)
  2. Configurare Spatie Permissions (Giorno 2)
  3. Implementare ruoli multi-tenant (Giorno 3)
  4. Integrare middleware GDPR (Giorno 4)
  5. Testare flussi di autenticazione (Giorno 5)

### 4. Interfaccia Utente (Settimana 6-7)
- **Responsabile**: Team di sviluppo
- **Tempi**: 10 giorni lavorativi
- **Steps**:
  1. Setup pannelli amministrativi (Giorni 1-2)
  2. Implementare risorse Patient (Giorni 3-4)
  3. Implementare risorse Dental (Giorni 5-6)
  4. Creare widget per dashboard (Giorni 7-8)
  5. Testare responsive e UX (Giorni 9-10)

### 5. Reportistica e Analisi (Settimana 8)
- **Responsabile**: Team di sviluppo
- **Tempi**: 5 giorni lavorativi
- **Steps**:
  1. Implementare dashboard statistiche (Giorni 1-2)
  2. Creare export dati GDPR compliant (Giorno 3)
  3. Sviluppare report per medici e amministratori (Giorni 4-5)

### 6. Testing e Deployment (Settimana 9-10)
- **Responsabile**: Team di sviluppo
- **Tempi**: 10 giorni lavorativi
- **Steps**:
  1. Implementare test automatizzati (Giorni 1-3)
  2. Eseguire test funzionali (Giorni 4-5)
  3. Setup ambiente staging (Giorni 6-7)
  4. Deploy in produzione (Giorni 8-9)
  5. Monitoraggio e ottimizzazione (Giorno 10)

## Timeframe Complessivo

Il progetto richiederà circa 10 settimane lavorative (50 giorni) per il completamento, suddivise in:

1. **Fase 1: Setup e Integrazione** - 2 settimane
   - Setup ambiente completo
   - Integrazione moduli Laraxot
   - Configurazione database

2. **Fase 2: Moduli Core** - 2 settimane
   - Sviluppo Patient e Dental
   - Modello dati
   - Relazioni tra entità

3. **Fase 3: Autenticazione** - 1 settimana
   - Filament Auth
   - Ruoli e permessi
   - GDPR compliance

4. **Fase 4: Interfaccia e UX** - 2 settimane
   - Implementazione pannelli Filament
   - Form e validazione
   - Dashboard personalizzate

5. **Fase 5: Reporting** - 1 settimana
   - Implementazione report
   - Export dati
   - Statistiche

6. **Fase 6: Testing e Deployment** - 2 settimane
   - Test completi
   - Bug fixing
   - Deploy in produzione

## Documentazione Dettagliata
Per ogni fase e modulo, è disponibile una documentazione dettagliata nei file:
- `01-setup-ambiente.md`: Setup e struttura base
- `02-gestione-dati.md`: Gestione dati e moduli core
- `03-interfaccia-utente.md`: Interfaccia utente e Filament
- `04-reporting.md`: Reporting e analisi dati
- `05-deployment.md`: Deployment e manutenzione

## Note sulla Privacy e Sicurezza
- **Implementazione GDPR completa**
  - Gestione consensi
  - Diritti degli interessati
  - Registro trattamenti
  - Procedure data breach

- **Protezione dati sensibili**
  - Crittografia dati sensibili
  - Pseudonimizzazione
  - Accesso basato su ruoli
  - Scadenza sessioni

- **Logging e audit**
  - Tracciamento attività
  - Log di sicurezza
  - Audit trail completo
  - Monitoraggio accessi

- **Backup e recovery**
  - Backup automatici
  - Procedure di ripristino
  - Test di recovery
  - Retention policy 