# Guida all'Installazione di SaluteOra

## Prerequisiti

- PHP 8.2 o superiore
- Composer
- Node.js e npm
- Git
- MySQL 8.0 o superiore

## Passi di Installazione

1. Clonare il repository
```bash
git clone https://github.com/your-org/saluteora.git
cd saluteora
```

2. Installare le dipendenze PHP
```bash
composer install
```

3. Installare le dipendenze JavaScript
```bash
npm install
```

4. Copiare il file di configurazione
```bash
cp .env.example .env
```

5. Generare la chiave dell'applicazione
```bash
php artisan key:generate
```

6. Configurare il database nel file .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=saluteora
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. **IMPORTANTE**: Rimuovere le migrazioni centrali
```bash
rm -rf database/migrations
```

8. Eseguire le migrazioni
```bash
php artisan migrate
```

9. Compilare gli assets
```bash
npm run dev
```

10. Avviare il server di sviluppo
```bash
php artisan serve
```

## Note sulla Gestione delle Migrazioni

⚠️ **ATTENZIONE**: Tutte le migrazioni sono contenute all'interno dei moduli. È fondamentale rimuovere le migrazioni centrali prima di eseguire qualsiasi comando di migrazione.

### Perché è necessario rimuovere database/migrations?

1. **Evita Conflitti**: Le migrazioni dei moduli potrebbero entrare in conflitto con quelle centrali
2. **Organizzazione**: Mantiene una struttura pulita e organizzata
3. **Indipendenza**: Permette una gestione indipendente delle migrazioni per modulo
4. **Manutenibilità**: Facilita il rollback e l'aggiornamento dei moduli

### Gestione Aggiornamenti

Quando si aggiorna un modulo:

```bash
# 1. Aggiornare il modulo
git subtree pull --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev

# 2. Rimuovere migrazioni centrali
rm -rf database/migrations

# 3. Eseguire le migrazioni
php artisan migrate
```

Per maggiori dettagli sulla gestione delle migrazioni, consultare [Gestione Migrazioni](migrazione-struttura.md).

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