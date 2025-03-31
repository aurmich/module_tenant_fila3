# Roadmap SaluteOra

> [!NOTE]
> Questo documento presenta una panoramica completa delle attività del progetto. Per dettagli specifici su ciascuna sezione, fare riferimento ai collegamenti presenti in ciascun paragrafo.

## Stato Attuale (Aprile 2024)

> [Dettagli sullo stato attuale](./roadmap/01-stato-attuale-aggiornato.md)

- ✅ Core system implementato (Xot, Lang, Tenant, User)
- ✅ Multi-tenant configurato e testato
- ✅ Autenticazione e autorizzazione
- ✅ Admin panel Filament integrato e personalizzato
- ✅ Gestione pazienti completa
- ✅ Modulo Dental implementato
- ✅ Modulo Reporting implementato
- ✅ Moduli funzionali installati:
  - ✅ Activity: logging e monitoraggio
  - ✅ Cms: gestione contenuti
  - ✅ Gdpr: conformità privacy
  - ✅ Job: gestione code
  - ✅ Media: gestione file
  - ✅ Notify: sistema notifiche
  - ✅ Chart: visualizzazione dati
- ✅ Struttura moduli definita e implementata
- ✅ Documentazione tecnica base
- ✅ Documentazione moduli principali
- ✅ Documentazione implementazione
- ✅ Integrazione ISEE (struttura base)

## Prossimi Passi

> [Roadmap dettagliata e priorità](./roadmap/09-roadmap-aggiornata.md)

### Q2 2024 (Aprile-Giugno)

> [Dettagli implementazione moduli core](./roadmap/core/implementazione-core.md) | 
> [Configurazione frontend](./roadmap/ui/configurazione-frontend.md)

- 🚧 Completamento funzionalità moduli installati
  - 🚧 Ottimizzazione modulo Xot (80%) - [Dettagli](./roadmap/moduli/xot-implementazione.md)
  - 🚧 Affinamento modulo Lang per supporto multilingua avanzato (70%) - [Dettagli](./roadmap/affinamento-modulo-lang.md)
  - 🚧 Miglioramento configurazione Tenant (90%) - [Dettagli](./roadmap/miglioramento-configurazione-tenant.md)
  - 🚧 Estensione modulo User con funzionalità avanzate (85%) - [Dettagli](./roadmap/estensione-modulo-user.md)
- 🚧 Completamento frontend
  - 🚧 Finalizzazione UI responsiva (75%) - [Dettagli](./roadmap/03-interfaccia-utente.md)
  - 🚧 Implementazione tema Filament personalizzato (60%) - [Dettagli](./roadmap/08-interfaccia-utente-filament.md)
  - 🚧 Ottimizzazione UX e accessibilità (50%) - [Dettagli](./roadmap/ottimizzazione-ux-accessibilita.md)
- 🚧 Integrazione moduli funzionali
  - 🚧 Completamento workflow pazienti (85%) - [Dettagli](./roadmap/completamento-workflow-pazienti.md)
  - 🚧 Integrazione avanzata trattamenti odontoiatrici (70%) - [Dettagli](./roadmap/integrazione-trattamenti-odontoiatrici.md)
  - ✅ Sistema reportistica avanzata (100%) - [Dettagli](./roadmap/04-reporting.md)
  - 🚧 Integrazione completa ISEE (60%) - [Dettagli](./roadmap/integrazione-isee-completa.md)
  - 🚧 Sistema notifiche multi-canale (50%) - [Dettagli](./roadmap/sistema-notifiche-multicanale.md)
  - 🚧 Workflow multi-step per prenotazioni (40%) - [Dettagli](./roadmap/workflow-multistep-prenotazioni.md)
- 🚧 API pubbliche essenziali (30%)
  - 🚧 Definizione struttura API RESTful (40%) - [Dettagli](./roadmap/api-restful.md)
  - 🚧 Implementazione autenticazione OAuth2 (20%) - [Dettagli](./roadmap/autenticazione-oauth2.md)
  - 🚧 Documentazione API con Swagger (30%) - [Dettagli](./roadmap/documentazione-api-swagger.md)

### Q3 2024 (Luglio-Settembre)

> [Piano di testing](./roadmap/testing/piano-testing.md) | 
> [Conformità GDPR](./roadmap/06-sicurezza-gdpr.md)

- 🚧 Completamento moduli funzionali
  - 🚧 Funzionalità avanzate Media (gestione documenti medici) (30%) - [Dettagli](./roadmap/funzionalita-avanzate-media.md)
  - 🚧 Sistema Activity avanzato con audit trail completo (20%) - [Dettagli](./roadmap/sistema-activity-avanzato.md)
  - 🚧 Conformità GDPR completa con gestione consensi (40%) - [Dettagli](./roadmap/06-gestione-dati-sensibili.md)
  - 🚧 Sistema notifiche avanzato con templates personalizzabili (30%) - [Dettagli](./roadmap/sistema-notifiche-avanzato.md)
  - 🚧 CMS per contenuti informativi e educativi (20%) - [Dettagli](./roadmap/cms-contenuti-informativi.md)
  - 🚧 Gestione job asincroni per operazioni pesanti (15%) - [Dettagli](./roadmap/gestione-job-asincroni.md)
- 📅 Testing completo
  - 🚧 Unit test per moduli core (15%) - [Dettagli](./roadmap/09-testing-deployment.md)
  - 📅 Feature test per funzionalità critiche
  - 📅 Browser test per UI/UX
  - 📅 Performance test
- 📅 Documentazione utente
- 📅 Telemedicina base
- 📅 Pagamenti online

### Q4 2024 (Ottobre-Dicembre)

> [Piano di deployment](./roadmap/05-deployment.md) | 
> [Ottimizzazione performance](./roadmap/deployment/ottimizzazione.md)

- 📅 Deployment e monitoraggio
  - 📅 Ambiente staging
  - 📅 CI/CD pipeline
  - 📅 Monitoraggio Sentry
  - 📅 Alerting automatico
- 📅 Ottimizzazioni
  - 📅 Performance frontend
  - 📅 Query database
  - 📅 Cache system
  - 📅 Queue jobs
- 📅 App mobile MVP
- 📅 Integrazione SSN
- 📅 Analytics base

### Q1 2025 (Gennaio-Marzo)

> [Piano funzionalità avanzate](./roadmap/stato-finale-progetto.md) | 
> [Sicurezza avanzata](./roadmap/testing/penetration-testing.md)

- 📅 Funzionalità avanzate
  - 📅 AI per supporto diagnosi preliminare
  - 📅 Blockchain per documenti sensibili
  - 📅 Marketplace servizi
  - 📅 Analytics avanzate
- 📅 Sicurezza avanzata
  - 📅 Audit completo
  - 📅 Penetration testing
  - 📅 GDPR compliance avanzata
  - 📅 Backup automation
- 📅 Integrazione completa PEC
- 📅 Dashboard personalizzabili

## Focus Attuale (Aprile-Maggio 2024)

> [Piano di lavoro dettagliato](./roadmap/ordine_implementazione.md) | 
> [Priorità attuali](./roadmap/07-tempistiche-priorita.md)

### 1. Completamento Integrazione Moduli

> [Dettagli integrazione](./roadmap/07-integrazione-fix.md) | 
> [Architettura moduli](./roadmap/02-architettura-moduli.md)

- 🚧 Miglioramento interoperabilità tra Patient, Dental e Reporting (70%)
- 🚧 Finalizzazione flussi di lavoro completi (60%) - [Dettagli](./roadmap/05-flussi-utente.md)
- 🚧 Ottimizzazione modelli dati condivisi (65%) - [Dettagli](./roadmap/02-gestione-dati.md)
- 🚧 Implementazione gestione documenti con Media module (50%)
- 🚧 Configurazione notifiche automatiche per appuntamenti (40%)

### 2. Sviluppo API

> [Implementazione API](./roadmap/03-implementazione-backend.md)

- 🚧 Definizione endpoints per Patient (30%)
- 🚧 Implementazione autenticazione API sicura (25%)
- 🚧 Creazione documentazione API con Swagger (20%)
- 📅 Implementazione rate limiting
- 📅 Test integrazione con sistemi esterni

### 3. Testing
- 🚧 Creazione test suite per moduli core (15%)
- 🚧 Implementazione CI/CD per i test (10%)
- 📅 Browser testing
- 📅 Test performance sotto carico
- 📅 Penetration testing

### 4. Preparazione Ambiente di Produzione

> [Dettagli deployment](./roadmap/deployment/infrastruttura.md) | 
> [Monitoraggio](./roadmap/deployment/monitoraggio.md)

- 🚧 Setup ambiente di staging (25%)
- 🚧 Configurazione pipeline di deploy (15%)
- 📅 Implementazione monitoraggio real-time
- 📅 Configurazione backups automatici
- 📅 Implementazione disaster recovery

## Criteri di Completamento

> [Indice completo documentazione](./roadmap/00-indice.md) | 
> [Conclusioni e prossimi passi](./roadmap/08-conclusioni.md)

- ✅ = Completato
- 🚧 = In corso (con percentuale di completamento)
- 📅 = Pianificato
