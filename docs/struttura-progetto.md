# Struttura del Progetto SaluteOra

## Struttura delle Directory

```
/var/www/html/saluteora/
├── docs/                     # Documentazione del progetto
├── laravel/                  # Installazione Laravel (percorso corretto)
│   ├── app/                  # Core application code
│   ├── bootstrap/            # Framework bootstrap files
│   ├── config/               # Configuration files
│   ├── database/             # Database migrations and seeds
│   ├── Modules/              # Moduli Laravel installati
│   │   ├── Xot/              # Modulo Core per utility e configurazioni base
│   │   ├── Patient/          # Modulo per gestione pazienti e anagrafica
│   │   ├── Dental/           # Modulo per gestione visite e trattamenti
│   │   ├── ISEE/             # Modulo per validazione economica
│   │   ├── UI/               # Componenti UI per Filament
│   │   ├── User/             # Gestione utenti e permessi
│   │   ├── Tenant/           # Gestione multitenant
│   │   └── GDPR/             # Gestione consensi e privacy
│   ├── public/               # Web server document root
│   ├── resources/            # Views, assets, and language files
│   ├── routes/               # Route definitions
│   ├── storage/              # Logs, cache, uploaded files (ensure proper permissions)
│   ├── tests/                # Automated tests
│   ├── vendor/               # Composer dependencies
│   ├── .env                  # Environment variables
│   ├── composer.json         # Composer dependencies and scripts
│   └── package.json          # NPM dependencies
└── .cursor/                  # Configurazioni IDE
    └── rules/                # Regole per l'ambiente di sviluppo
```

## Note Importanti

1. **Percorso Laravel**: L'installazione Laravel deve essere posizionata in `/var/www/html/saluteora/laravel` e non in altra directory. Questo è fondamentale per il corretto funzionamento del progetto.

2. **Struttura Modulare**: Tutti i moduli custom devono essere creati nella directory `laravel/Modules/` seguendo le convenzioni di nwidart/laravel-modules.

3. **Integrazione Moduli Laraxot**: I moduli Laraxot verranno integrati tramite git subtree in `laravel/Modules/`.

## Comandi di Installazione

```bash
# 1. Installare Laravel Installer globalmente
composer global require laravel/installer -W

# 2. Creare nuovo progetto Laravel nella directory corretta
laravel new laravel

# 3. Entrare nella directory del progetto
cd laravel

# 4. Installare Laravel Modules
composer require nwidart/laravel-modules
```
