# Traduzioni del Modulo Tenant

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)

## Struttura

```
Modules/Tenant/
└── lang/
    ├── it/
    │   └── tenant.php
    └── en/
        └── tenant.php
```

## Contenuto

Il file `tenant.php` contiene le traduzioni per:
- Gestione tenant
- Configurazione tenant
- Domini
- Database
- Permessi tenant
- Migrazione dati
- Backup tenant
- Restore tenant
- Statistiche tenant
- Log tenant

## Esempi

```php
return [
    'management' => [
        'label' => 'Gestione Tenant',
        'tooltip' => 'Gestisci i tenant del sistema'
    ],
    'configuration' => [
        'label' => 'Configurazione',
        'tooltip' => 'Configura le impostazioni del tenant'
    ],
    'domains' => [
        'label' => 'Domini',
        'tooltip' => 'Gestisci i domini del tenant'
    ],
    'backup' => [
        'label' => 'Backup',
        'tooltip' => 'Esegui il backup del tenant'
    ]
];
``` 
## Collegamenti tra versioni di translations.md
* [translations.md](laravel/Modules/Chart/docs/translations.md)
* [translations.md](laravel/Modules/Reporting/docs/translations.md)
* [translations.md](laravel/Modules/Gdpr/docs/translations.md)
* [translations.md](laravel/Modules/Notify/docs/translations.md)
* [translations.md](laravel/Modules/Xot/docs/roadmap/lang/translations.md)
* [translations.md](laravel/Modules/Xot/docs/translations.md)
* [translations.md](laravel/Modules/Dental/docs/translations.md)
* [translations.md](laravel/Modules/User/docs/translations.md)
* [translations.md](laravel/Modules/UI/docs/translations.md)
* [translations.md](laravel/Modules/Lang/docs/packages/translations.md)
* [translations.md](laravel/Modules/Lang/docs/translations.md)
* [translations.md](laravel/Modules/Job/docs/translations.md)
* [translations.md](laravel/Modules/Media/docs/translations.md)
* [translations.md](laravel/Modules/Tenant/docs/translations.md)
* [translations.md](laravel/Modules/Activity/docs/translations.md)
* [translations.md](laravel/Modules/Patient/docs/translations.md)
* [translations.md](laravel/Modules/Cms/docs/translations.md)

