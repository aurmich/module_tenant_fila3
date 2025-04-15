# Pacchetti del Modulo Tenant

## Pacchetti Utilizzati

### Core
- [laraxot/module_xot_fila3](../Xot/docs/packages.md) - Modulo base per funzionalità comuni
- [laraxot/module_ui](../UI/docs/packages.md) - Componenti UI e temi
- [stancl/tenancy](https://github.com/stancl/tenancy) - Gestione multi-tenant

### Database
- [stancl/tenancy-database](https://github.com/stancl/tenancy-database) - Database per tenant
- [stancl/tenancy-filesystem](https://github.com/stancl/tenancy-filesystem) - Filesystem per tenant
- [stancl/tenancy-cache](https://github.com/stancl/tenancy-cache) - Cache per tenant

## Pacchetti di Riferimento

### Multi-tenant
- [spatie/laravel-multitenancy](https://github.com/spatie/laravel-multitenancy) - Alternativa a Stancl
- [hyn/multi-tenant](https://github.com/hyn/multi-tenant) - Soluzione legacy
- [archtechx/tenancy](https://github.com/archtechx/tenancy) - Nuova soluzione

### Database
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup) - Backup tenant
- [spatie/laravel-db-snapshots](https://github.com/spatie/laravel-db-snapshots) - Snapshot DB
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action) - Azioni in coda

## Pacchetti Potenziali

### Performance
- [spatie/laravel-responsecache](https://github.com/spatie/laravel-responsecache) - Cache risposte
- [spatie/laravel-image-optimizer](https://github.com/spatie/laravel-image-optimizer) - Ottimizzazione immagini
- [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap) - Sitemap

### Sicurezza
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission) - Permessi tenant
- [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog) - Log attività
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup) - Backup

## Pacchetti da Non Utilizzare

### Multi-tenant
- [laravel/fortify](https://github.com/laravel/fortify) - Non necessario per tenant
- [laravel/sanctum](https://github.com/laravel/sanctum) - Non per tenant

### Database
- [laravel/telescope](https://github.com/laravel/telescope) - Non per production
- [laravel/horizon](https://github.com/laravel/horizon) - Non necessario per tenant

## Documentazione Collegata

- [Database](packages/database.md)
- [Filesystem](packages/filesystem.md)
- [Cache](packages/cache.md)
- [Backup](packages/backup.md) 
