# Roadmap SaluteOra

> [!NOTE]
> Questo documento presenta una panoramica completa delle attività del progetto. Per dettagli specifici su ciascuna sezione, fare riferimento ai collegamenti presenti in ciascun paragrafo.

## Stato Attuale (Marzo 2024)

> [Dettagli sullo stato attuale](./roadmap/01-stato-attuale.md)

- ✅ Core system implementato (Xot, Lang, Tenant, User)
- ✅ Multi-tenant configurato e testato
- ✅ Autenticazione e autorizzazione
- ✅ Admin panel Filament integrato e personalizzato
- ✅ Gestione pazienti base
- ✅ Modulo Dental base
- ✅ Modulo Reporting base
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
- 🚧 Integrazione ISEE (30%)

## Fasi in Corso

### Q2 2024 (Aprile-Giugno)

> [Dettagli implementazione moduli core](./roadmap/core/implementazione-core.md) | 
> [Configurazione frontend](./roadmap/ui/configurazione-frontend.md)

#### 1. Implementazione Core (40%)
- 🚧 Completamento funzionalità moduli installati
  - 🚧 Ottimizzazione modulo Xot (80%) - [Dettagli](./roadmap/moduli/xot-implementazione.md)
  - 🚧 Affinamento modulo Lang per supporto multilingua (70%) - [Dettagli](./roadmap/affinamento-modulo-lang.md)
  - 🚧 Miglioramento configurazione Tenant (60%) - [Dettagli](./roadmap/miglioramento-configurazione-tenant.md)
  - 🚧 Estensione modulo User con funzionalità avanzate (50%) - [Dettagli](./roadmap/estensione-modulo-user.md)

#### 2. Frontend e UI (30%)
- 🚧 Completamento frontend
  - 🚧 Finalizzazione UI responsiva (40%) - [Dettagli](./roadmap/03-interfaccia-utente.md)
  - 🚧 Implementazione tema Filament personalizzato (30%) - [Dettagli](./roadmap/08-interfaccia-utente-filament.md)
  - 🚧 Ottimizzazione UX e accessibilità (20%) - [Dettagli](./roadmap/ottimizzazione-ux-accessibilita.md)

#### 3. Integrazione Moduli Funzionali (25%)
- 🚧 Completamento workflow pazienti (40%) - [Dettagli](./roadmap/completamento-workflow-pazienti.md)
- 🚧 Integrazione avanzata trattamenti odontoiatrici (30%) - [Dettagli](./roadmap/integrazione-trattamenti-odontoiatrici.md)
- 🚧 Sistema reportistica avanzata (20%) - [Dettagli](./roadmap/04-reporting.md)
- 🚧 Integrazione completa ISEE (30%) - [Dettagli](./roadmap/integrazione-isee-completa.md)
- 🚧 Sistema notifiche multi-canale (20%) - [Dettagli](./roadmap/sistema-notifiche-multicanale.md)
- 🚧 Workflow multi-step per prenotazioni (15%) - [Dettagli](./roadmap/workflow-multistep-prenotazioni.md)

### Q3 2024 (Luglio-Settembre)

> [Piano di testing](./roadmap/testing/piano-testing.md) | 
> [Conformità GDPR](./roadmap/06-sicurezza-gdpr.md)

#### 1. Completamento Moduli Funzionali (0%)
- 📅 Funzionalità avanzate Media (gestione documenti medici) - [Dettagli](./roadmap/funzionalita-avanzate-media.md)
- 📅 Sistema Activity avanzato con audit trail completo - [Dettagli](./roadmap/sistema-activity-avanzato.md)
- 📅 Conformità GDPR completa con gestione consensi - [Dettagli](./roadmap/06-gestione-dati-sensibili.md)
- 📅 Sistema notifiche avanzato con templates personalizzabili - [Dettagli](./roadmap/sistema-notifiche-avanzato.md)
- 📅 CMS per contenuti informativi e educativi - [Dettagli](./roadmap/cms-contenuti-informativi.md)
- 📅 Gestione job asincroni per operazioni pesanti - [Dettagli](./roadmap/gestione-job-asincroni.md)

#### 2. Testing e Sicurezza (0%)
- 📅 Testing completo
  - 📅 Unit test per moduli core - [Dettagli](./roadmap/09-testing-deployment.md)
  - 📅 Feature test per funzionalità critiche - [Dettagli](./roadmap/testing/feature-test.md)
  - 📅 Browser test per UI/UX - [Dettagli](./roadmap/testing/browser-test.md)
  - 📅 Performance test - [Dettagli](./roadmap/testing/performance-test.md)
- 📅 Documentazione utente - [Dettagli](./roadmap/documentazione-utente.md)
- 📅 Telemedicina base - [Dettagli](./roadmap/telemedicina-base.md)
- 📅 Pagamenti online - [Dettagli](./roadmap/pagamenti-online.md)

### Q4 2024 (Ottobre-Dicembre)

> [Piano di deployment](./roadmap/05-deployment.md) | 
> [Ottimizzazione performance](./roadmap/deployment/ottimizzazione.md)

#### 1. Deployment e Monitoraggio (0%)
- 📅 Ambiente staging
- 📅 CI/CD pipeline
- 📅 Monitoraggio Sentry
- 📅 Alerting automatico

#### 2. Ottimizzazioni (0%)
- 📅 Performance frontend
- 📅 Query database
- 📅 Cache system
- 📅 Queue jobs

#### 3. Funzionalità Avanzate (0%)
- 📅 App mobile MVP - [Dettagli](./roadmap/app-mobile-mvp.md)
- 📅 Integrazione SSN - [Dettagli](./roadmap/integrazione-ssn.md)
- 📅 Analytics base - [Dettagli](./roadmap/analytics-base.md)

## Prossime Evoluzioni (2025 e oltre)

> [Piano di lavoro dettagliato](./roadmap/ordine_implementazione.md) | 
> [Priorità attuali](./roadmap/07-tempistiche-priorita.md)

### 1. Espansione Funzionalità Avanzate

> [Piano evoluzione piattaforma](./roadmap/evoluzione-piattaforma.md) | 
> [Integrazioni esterne](./roadmap/integrazioni-esterne-avanzate.md)

- 📅 Integrazione completa con sistemi regionali (0%)
- 📅 Espansione marketplace con servizi di terze parti (0%)
- 📅 AI avanzata per predizione e prevenzione (0%)
- 📅 Sistema telemedicina evoluto con dispositivi IoT (0%)
- 📅 Interfacce conversazionali per supporto pazienti (0%)

### 2. Espansione Territoriale e Multi-Regione

> [Piano espansione](./roadmap/espansione-geografica.md)

- 📅 Supporto multi-lingua avanzato (0%)
- 📅 Compliance normative internazionali (0%)
- 📅 Personalizzazione per requisiti regionali specifici (0%)
- 📅 Dashboard di confronto multi-regione (0%)
- 📅 Analisi demografiche cross-region (0%)

### 3. Evoluzione Tecnologica
- 📅 Migrazione a microservizi completa (0%)
- 📅 Adozione architettura serverless per componenti selezionati (0%)
- 📅 Implementazione edge computing per performance locality (0%)
- 📅 Adozione standard FHIR per interoperabilità sanitaria (0%)
- 📅 Implementazione Web 3.0 per privacy avanzata (0%)

## Criteri di Completamento

> [Indice completo documentazione](./roadmap/00-indice.md) | 
> [Conclusioni e prossimi passi](./roadmap/08-conclusioni.md)

- ✅ = Completato
- 🚧 = In corso (con percentuale di completamento)
- 📅 = Pianificato
