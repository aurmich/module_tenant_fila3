# Struttura del Modulo Patient

## Directory Base
```
Patient/
├── app/                    # Logica applicativa
│   ├── Models/            # Modelli del modulo
│   ├── Http/              # Controllers e middleware
│   ├── Services/          # Logica di business
│   ├── Jobs/              # Job asincroni
│   ├── Events/            # Eventi del sistema
│   ├── Listeners/         # Gestori eventi
│   ├── Notifications/     # Notifiche
│   ├── Providers/         # Service providers
│   ├── Console/           # Comandi Artisan
│   ├── Filament/          # Risorse Filament
│   └── View/              # Componenti Blade
├── config/                # Configurazioni
├── database/              # Migrations e seeders
├── resources/             # Views e assets
├── routes/                # Definizione route
├── tests/                 # Test del modulo
├── docs/                  # Documentazione
├── lang/                  # Traduzioni
├── .github/               # Configurazioni GitHub
├── .vscode/               # Configurazioni VSCode
├── composer.json          # Dipendenze PHP
├── package.json           # Dipendenze JS
├── module.json            # Configurazione modulo
└── vite.config.js         # Configurazione Vite
```

## Namespace
Il namespace base del modulo è `Modules\Patient`. Tutti i componenti devono seguire questa struttura:

- Models: `Modules\Patient\Models`
- Controllers: `Modules\Patient\Http\Controllers`
- Services: `Modules\Patient\Services`
- Jobs: `Modules\Patient\Jobs`
- Events: `Modules\Patient\Events`
- Listeners: `Modules\Patient\Listeners`
- Notifications: `Modules\Patient\Notifications`
- Providers: `Modules\Patient\Providers`
- Console: `Modules\Patient\Console`
- Filament: `Modules\Patient\Filament`
- View: `Modules\Patient\View`

## Dipendenze
Il modulo Patient dipende dai seguenti moduli core:
- User: Per la gestione degli utenti
- Tenant: Per il multi-tenant
- Activity: Per il logging delle attività
- Media: Per la gestione dei file
- UI: Per i componenti base dell'interfaccia

## Funzionalità Principali
1. Gestione anagrafica pazienti
2. Gestione documenti
3. Gestione anamnesi
4. Gestione appuntamenti
5. Gestione consensi
6. Gestione ISEE

## Note Importanti
- Tutti i file devono essere organizzati nelle directory appropriate
- I namespace devono essere corretti e coerenti
- La documentazione deve essere mantenuta aggiornata
- I test devono coprire tutte le funzionalità principali
- Le traduzioni devono essere complete per tutte le lingue supportate 