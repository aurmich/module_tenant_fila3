# Framework Laraxot

## Panoramica
Laraxot è un framework modulare basato su Laravel specificamente progettato per applicazioni multi-tenant con pannelli di amministrazione avanzati.

## Moduli Core

### Module XOT (module_xot_fila3)
Il modulo base di Laraxot che fornisce funzionalità core:
- Service Provider principale
- Helper e utility
- Traits comuni
- Middleware
- Commands di base
- Factory di base

### Module LANG (module_lang_fila3)
Gestisce il sistema multilingua:
- Traduzione automatica
- Localizzazione
- Switch lingua
- Traduzioni tenant-specific
- Export/import traduzioni

### Module TENANT (module_tenant_fila3)
Gestisce il multi-tenant:
- Identificazione tenant
- Isolamento dati
- Configurazione tenant
- Middleware tenant
- Database tenant

### Module USER (module_user_fila3)
Gestisce gli utenti:
- Autenticazione
- Autorizzazione
- Gestione profili
- Ruoli e permessi
- Preferenze utente

## Moduli Funzionali

### Module MEDIA (module_media_fila3)
Gestisce i file e i media:
- Upload file
- Image processing
- Storage configurabile
- Conversioni automatiche
- Associazione con modelli

### Module ACTIVITY (module_activity_fila3)
Gestisce il logging delle attività:
- Audit log
- Activity tracking
- Event logging
- Error tracking
- Statistiche

### Module GDPR (module_gdpr_fila3)
Gestisce la privacy:
- Cookie policy
- Privacy policy
- Consensi
- Data export
- Data deletion

### Module NOTIFY (module_notify_fila3)
Sistema di notifiche:
- Email
- In-app
- Push
- SMS
- Canali personalizzati

### Module CMS (module_cms_fila3)
Gestione contenuti:
- Pagine
- Blog
- Articoli
- Categorie
- Tag

### Module JOB (module_job_fila3)
Gestione job in background:
- Code
- Schedule
- Retry
- Monitoring
- Notifiche

## Struttura Moduli

```
ModuleName/
├── app/                     # Codice del modulo
│   ├── Console/             # Comandi Artisan
│   ├── Http/                # Controller, Middleware, Requests
│   ├── Models/              # Modelli Eloquent
│   ├── Providers/           # Service Provider
│   └── ...                  # Altri componenti
├── config/                  # Configurazioni
├── database/
│   ├── migrations/          # Migrazioni specifiche
│   └── seeders/             # Seeders specifici
├── resources/
│   ├── assets/              # Asset specifici
│   ├── lang/                # Traduzioni
│   └── views/               # Viste Blade
├── routes/                  # Route
├── composer.json            # Dipendenze
└── module.json              # Metadati
```

## Tema Filament (theme_one_fila3)
Theme One è il tema principale per Filament 3:
- Personalizzazione UI
- Componenti custom
- Layout admin
- Dark/light mode
- Responsive design

## Installazione

### Primo Utilizzo
```bash
# Clonare il progetto Laravel di base
git clone [url-progetto] my-project
cd my-project

# Installare le dipendenze
composer install

# Installare i moduli Laraxot con git subtree
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev --squash
git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev --squash
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

### Configurazione
```bash
# Setup ambiente
cp .env.example .env
php artisan key:generate

# Migrazioni
php artisan module:migrate

# Publishing assets
php artisan vendor:publish --tag=filament-config
php artisan vendor:publish --tag=xot-config
```

## Convenzioni

### Namespace
I moduli Laraxot utilizzano una struttura particolare per i namespace:
- **Struttura fisica**: `/Modules/Xot/app/Http/Controllers/`
- **Namespace logico**: `Modules\Xot\Http\Controllers\`

### Models
- Tutti i modelli devono usare il trait `BelongsToTenant` in ambiente multi-tenant
- Estendere `Modules\Xot\Models\BaseModel` per la massima compatibilità
- Usare i traits per funzionalità comuni

### Controllers
- Estendere `Modules\Xot\Http\Controllers\BaseController`
- Utilizzare form request per la validazione
- Seguire pattern resource controller

## Best Practices

### NON fare
- NON estendere direttamente classi Filament
- NON modificare i moduli core
- NON creare dipendenze circolari
- NON duplicare codice tra moduli

### FARE
- Creare wrapper personalizzati per Filament
- Utilizzare i traits per estendere funzionalità
- Seguire il pattern di composizione
- Mantenere back-compatibility
- Documentare le modifiche 