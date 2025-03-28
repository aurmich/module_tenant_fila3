# Guida all'Installazione di SaluteOra

## Comandi di Installazione

### Step 1: Installare Laravel Installer
Il primo passo è installare Laravel Installer globalmente:
```bash
composer global require laravel/installer
```

### Step 2: Creare un nuovo progetto Laravel
Il secondo comando è creare un nuovo progetto Laravel con il nome 'laravel':
```bash
laravel new laravel
```

> **IMPORTANTE**: È fondamentale utilizzare esattamente questo comando. Non utilizzare varianti come `laravel new saluteora` o `laravel new laravel --version=X.Y`. Il nome del progetto deve essere esattamente `laravel`.

### Step 3: Installare Laravel Modules
Una volta creato il progetto, procederemo con l'installazione di Laravel Modules:
```bash
cd laravel
composer require nwidart/laravel-modules
```

### Step 4: Configurare Laravel Modules
Pubblicare i file di configurazione di Laravel Modules:
```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

### Step 5: Configurare il composer.json
Modificare il file `composer.json` per aggiungere l'autoloading dei moduli:
```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/",
        "Modules\\": "Modules/"
    }
}
```

Aggiungere anche la sezione per il merge-plugin:
```json
"extra": {
    "laravel": {
        "dont-discover": []
    },
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"
        ],
        "recurse": true,
        "replace": false,
        "ignore-duplicates": false,
        "merge-dev": true,
        "merge-extra": false,
        "merge-extra-deep": false,
        "merge-scripts": false
    }
}
```

### Step 6: Aggiornare le dipendenze
Dopo aver modificato il composer.json:
```bash
composer dump-autoload
``` 