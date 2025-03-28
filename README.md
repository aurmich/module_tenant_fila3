# SaluteOra - Sistema di Gestione Salute Orale

## Requisiti di Sistema
- PHP 8.2 o superiore
- Composer
- Node.js 18+ e npm
- MySQL 8.0+
- Git

## Installazione

### 1. Clonare il Repository
```bash
git clone https://github.com/your-username/saluteora.git
cd saluteora
```

### 2. Installare le Dipendenze PHP
```bash
composer install
```

### 3. Installare le Dipendenze Node.js
```bash
npm install
```

### 4. Configurare l'Ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurare il Database
Modificare il file `.env` con le credenziali del database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=saluteora
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Eseguire le Migrazioni
```bash
php artisan migrate
```

### 7. Installare i Moduli
```bash
# Installare Laravel Modules
composer require nwidart/laravel-modules

# Pubblicare la configurazione dei moduli
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

# Aggiungere il modulo Xot
git remote add -f xot https://github.com/crud-lab/xot.git
git subtree add --prefix Modules/Xot xot main --squash
```

### 8. Compilare gli Assets
```bash
npm run dev
```

### 9. Avviare il Server di Sviluppo
```bash
php artisan serve
```

## Struttura del Progetto

```
saluteora/
├── app/
├── config/
├── database/
├── Modules/
│   ├── Core/
│   ├── Patient/
│   ├── Dental/
│   └── Xot/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
└── docs/
    ├── roadmap/
    └── packages/
```

## Moduli Principali

### Core
- Gestione utenti e autenticazione
- Configurazione sistema
- Funzionalità base

### Patient
- Gestione pazienti
- Anamnesi
- Storico visite

### Dental
- Gestione trattamenti
- Calendario appuntamenti
- Documenti clinici

### Xot
- Framework base per i moduli
- Componenti riutilizzabili
- Funzionalità comuni

## Documentazione

La documentazione completa è disponibile nella directory `docs/`:
- [Roadmap del Progetto](docs/roadmap/README.md)
- [Documentazione dei Pacchetti](docs/packages/README.md)

## Sviluppo

### Comandi Utili
```bash
# Creare un nuovo modulo
php artisan module:make NomeModulo

# Generare componenti per un modulo
php artisan module:make-controller NomeController NomeModulo
php artisan module:make-model NomeModel NomeModulo
php artisan module:make-migration create_table NomeModulo

# Eseguire i test
php artisan test

# Aggiornare le dipendenze
composer update
npm update
```

### Best Practices
- Seguire le convenzioni PSR-4 per l'autoloading
- Utilizzare i namespace corretti per i moduli
- Documentare le modifiche nel CHANGELOG.md
- Mantenere i test aggiornati
- Verificare la compatibilità cross-browser

## Licenza
Questo progetto è sotto licenza MIT. Vedere il file [LICENSE](LICENSE) per i dettagli. 