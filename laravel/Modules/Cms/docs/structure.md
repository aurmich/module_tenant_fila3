# Struttura del Modulo CMS

## Directory Principali

```
Modules/Cms/
├── app/                    # Codice principale del modulo
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Modelli del modulo
│   ├── Filament/          # Resources e Pages di Filament
│   ├── Providers/         # Service Providers
│   └── Console/           # Comandi Artisan
├── config/                # File di configurazione
├── database/              # Migrations e Seeders
│   ├── migrations/        # Migrations
│   └── seeders/          # Seeders
├── resources/             # Assets e Views
│   ├── views/            # Blade views
│   ├── lang/             # File di traduzione
│   └── assets/           # JS, CSS, immagini
├── routes/                # File delle routes
├── tests/                 # Test del modulo
└── docs/                  # Documentazione del modulo
```

## Convenzioni

1. **Namespace**
   - Tutte le classi devono usare il namespace `Modules\Cms`
   - I namespace devono riflettere la struttura delle directory

2. **Controllers**
   - Devono essere in `app/Http/Controllers`
   - Devono estendere `App\Http\Controllers\Controller`
   - Devono seguire la convenzione di naming `*Controller`

3. **Models**
   - Devono essere in `app/Models`
   - Devono estendere `Illuminate\Database\Eloquent\Model`
   - Devono avere il trait `HasFactory`

4. **Filament Resources**
   - Devono essere in `app/Filament/Resources`
   - Devono estendere `XotBaseResource`
   - Devono seguire le convenzioni di XotBaseResource

5. **Views**
   - Devono essere in `resources/views`
   - Devono usare il prefisso `cms::`
   - Devono seguire le convenzioni Blade

6. **Routes**
   - Devono essere in `routes`
   - Devono usare il prefisso `cms`
   - Devono essere raggruppate per funzionalità

7. **Config**
   - Devono essere in `config`
   - Devono usare il prefisso `cms`
   - Devono essere accessibili via `config('cms.*')`

8. **Translations**
   - Devono essere in `resources/lang`
   - Devono usare il prefisso `cms::`
   - Devono supportare italiano e inglese

## Spostamenti Necessari

1. Spostare i contenuti da:
   - `View/` → `resources/views/`
   - `Models/` → `app/Models/`
   - `Config/` → `config/`
   - `Routes/` → `routes/`
   - `Resources/` → `resources/`
   - `Database/` → `database/`
   - `lang/` → `resources/lang/`
   - `tests/` → `tests/`

2. Rimuovere directory non necessarie:
   - `Datas/`
   - `Presenters/`
   - `Actions/`
   - `bashscripts/`

3. Aggiornare i namespace in tutti i file
4. Aggiornare i riferimenti nei file di configurazione
5. Aggiornare i riferimenti nelle views
6. Aggiornare i riferimenti nelle routes 