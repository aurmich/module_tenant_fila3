# Installazione in SaluteOra

Questa guida descrive come installare e configurare il tema One in SaluteOra.

## Requisiti

- PHP 8.1+
- Laravel 10+
- Filament 3.3+
- Node.js 16+
- NPM 8+

## Installazione

1. **Installa il tema**
```bash
composer require saluteora/theme-one
```

2. **Pubblica gli assets**
```bash
php artisan vendor:publish --tag=one-assets
```

3. **Pubblica le viste**
```bash
php artisan vendor:publish --tag=one-views
```

4. **Pubblica le configurazioni**
```bash
php artisan vendor:publish --tag=one-config
```

5. **Installa le dipendenze NPM**
```bash
npm install
```

6. **Compila gli assets**
```bash
npm run dev
```

## Configurazione

1. **Configura il tema in `config/app.php`**
```php
'providers' => [
    // ...
    Themes\One\Providers\ThemeServiceProvider::class,
],
```

2. **Configura il tema in `config/theme.php`**
```php
return [
    'name' => 'One',
    'description' => 'Tema One per SaluteOra',
    'version' => '1.0.0',
    'author' => 'SaluteOra Team',
    'path' => 'themes/one',
    'views' => [
        'path' => 'resources/views',
        'namespace' => 'one',
    ],
    'assets' => [
        'path' => 'public/themes/one',
        'url' => '/themes/one',
    ],
    'providers' => [
        \Themes\One\Providers\ThemeServiceProvider::class,
    ],
];
```

3. **Configura Vite in `vite.config.js`**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'themes/one/assets/css/app.css',
                'themes/one/assets/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

## Verifica

1. **Verifica l'installazione**
```bash
php artisan theme:list
```

2. **Verifica gli assets**
```bash
php artisan theme:assets
```

3. **Verifica le viste**
```bash
php artisan theme:views
```

## Risoluzione Problemi

### Problemi Comuni

1. **Assets non trovati**
```bash
php artisan theme:publish --force
```

2. **Viste non trovate**
```bash
php artisan view:clear
php artisan cache:clear
```

3. **Configurazioni non caricate**
```bash
php artisan config:clear
php artisan cache:clear
```

### Log

I log del tema sono disponibili in:
```
storage/logs/theme-one.log
```

## Best Practices

1. **Backup**: Fai sempre un backup prima dell'installazione
2. **Versioning**: Usa il controllo versione per il codice
3. **Test**: Verifica sempre l'installazione
4. **Documentazione**: Mantieni la documentazione aggiornata
5. **Sicurezza**: Proteggi le informazioni sensibili
6. **Performance**: Ottimizza le performance
7. **Manutenibilità**: Mantieni il codice pulito
8. **Supporto**: Fornisci supporto per i problemi 