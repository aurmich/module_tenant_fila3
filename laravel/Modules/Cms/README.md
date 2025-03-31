# Modulo CMS - SaluteOra

Modulo per la gestione dei contenuti del sito SaluteOra.

## Caratteristiche

- Gestione pagine
- Gestione menu
- Contenuti dinamici
- Editor visuale
- Supporto multilingua

## Struttura

Il modulo è organizzato secondo le convenzioni di Laravel Modules e segue la struttura standard:

```
Modules/Cms/
├── app/                    # Codice principale del modulo
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Modelli del modulo
│   ├── Filament/          # Resources e Pages di Filament
│   ├── Providers/         # Service Providers
│   └── Console/           # Comandi Artisan
├── config/                # File di configurazione
├── database/              # Migrations e Seeders
├── resources/             # Assets e Views
├── routes/                # File delle routes
├── tests/                 # Test del modulo
└── docs/                  # Documentazione del modulo
```

## Documentazione

La documentazione è disponibile nella cartella `docs`:

- [Struttura del Modulo](docs/structure.md)
- [Convenzioni Filament](docs/filament.md)
- [Gestione Contenuti](docs/content.md)

## Setup

### Installazione

```bash
# Non è necessario installare il modulo separatamente, 
# è già parte del progetto SaluteOra
```

### Configurazione

```php
// Configurare il file config/cms.php
```

## Utilizzo

### Filament Admin

Accedere al pannello di amministrazione Filament per gestire i contenuti del CMS:

- Pagine: creazione e modifica di pagine del sito
- Menu: gestione dei menu di navigazione
- Contenuti: gestione di blocchi di contenuto riutilizzabili

### API

Utilizzare le API del modulo per integrare i contenuti CMS in altre parti dell'applicazione:

```php
use Modules\Cms\Models\Page;

// Ottenere tutte le pagine pubblicate
$pages = Page::published()->get();

// Ottenere una pagina specifica per slug
$page = Page::where('slug', 'chi-siamo')->first();
```

## Sviluppo

### Guidelines

Il modulo segue le convenzioni di Laravel e Filament, con alcune personalizzazioni:

- Utilizzare XotBaseResource per le risorse Filament
- Seguire le convenzioni PSR-12 per il codice
- Implementare tests per tutte le funzionalità

### Testing

Eseguire i test con:

```bash
php artisan test --filter=Cms
```
