# Backup SaluteOra

## Strategia di Backup

### Database
- Backup giornaliero completo
- Backup incrementale ogni 6 ore
- Retention: 30 giorni
- Compressione: gzip
- Verifica integrità

### Files
- Backup settimanale completo
- Backup incrementale giornaliero
- Retention: 30 giorni
- Compressione: tar.gz
- Verifica integrità

## Configurazione

### Spatie Backup
```php
// config/backup.php
return [
    'backup' => [
        'name' => env('APP_NAME', 'saluteora'),
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                ],
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                ],
            ],
            'databases' => [
                'mysql',
            ],
        ],
        'destination' => [
            'filename_prefix' => 'saluteora-',
            'disks' => [
                'backup',
            ],
        ],
    ],
];
```

### Storage
```php
// config/filesystems.php
'disks' => [
    'backup' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BACKUP_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    ],
],
```

## Comandi

### Backup Manuale
```bash
# Backup completo
php artisan backup:run

# Backup solo database
php artisan backup:run --only-db

# Backup solo files
php artisan backup:run --only-files

# Backup specifico tenant
php artisan backup:run --tenant=1
```

### Verifica Backup
```bash
# Lista backup
php artisan backup:list

# Verifica backup
php artisan backup:verify

# Ripristino backup
php artisan backup:restore
```

## Automazione

### Cron Jobs
```bash
# Backup giornaliero
0 0 * * * cd /var/www/html/saluteora && php artisan backup:run

# Backup incrementale
0 */6 * * * cd /var/www/html/saluteora && php artisan backup:run --only-db

# Pulizia backup vecchi
0 1 * * * cd /var/www/html/saluteora && php artisan backup:clean
```

### Notifiche
```php
// config/backup-notifications.php
return [
    'notifications' => [
        'mail' => [
            'to' => 'admin@saluteora.it',
        ],
        'slack' => [
            'webhook_url' => env('SLACK_WEBHOOK_URL'),
        ],
    ],
];
```

## Monitoraggio

### Logs
```bash
# Log backup
tail -f storage/logs/backup.log

# Log errori
tail -f storage/logs/backup-error.log
```

### Metriche
```php
// Monitoraggio spazio
$disk = Storage::disk('backup');
$size = $disk->size('backup.tar.gz');

// Monitoraggio frequenza
$lastBackup = Backup::latest()->first();
$frequency = $lastBackup->created_at->diffInHours(now());
```

## Ripristino

### Database
```bash
# Ripristino completo
php artisan backup:restore --path=backup.tar.gz

# Ripristino database
php artisan backup:restore --path=backup.tar.gz --only-db

# Ripristino files
php artisan backup:restore --path=backup.tar.gz --only-files
```

### Verifica Ripristino
```bash
# Verifica database
php artisan db:show

# Verifica files
php artisan storage:link
php artisan view:clear
php artisan cache:clear
```

## Manutenzione

### Pulizia
```bash
# Rimuovi backup vecchi
php artisan backup:clean

# Rimuovi backup specifici
php artisan backup:delete --path=backup.tar.gz
```

### Ottimizzazione
```bash
# Compressi backup
php artisan backup:compress

# Verifica integrità
php artisan backup:verify
``` 