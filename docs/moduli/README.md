# Moduli Laraxot per SaluteOra

## Moduli Core (Essenziali)
1. **module_xot_fila3** - Modulo base con utility e configurazioni core
2. **module_lang_fila3** - Gestione multilingua
3. **module_tenant_fila3** - Supporto multi-tenant
4. **module_user_fila3** - Gestione utenti e autenticazione

## Moduli Frontend
5. **module_ui_fila3** - Interfaccia utente base
6. **theme_one_fila3** - Tema per Filament 3 (da installare in `/laravel/Themes/One/`)

## Moduli Funzionali
7. **module_media_fila3** - Gestione media e file
8. **module_activity_fila3** - Logging e monitoraggio attività
9. **module_gdpr_fila3** - Gestione privacy e GDPR (cruciale!)
10. **module_notify_fila3** - Sistema di notifiche
11. **module_cms_fila3** - Gestione contenuti
12. **module_job_fila3** - Gestione job in background

## Struttura Corretta dei Moduli
```
laravel/Modules/
└── NomeModulo/
    ├── app/                     # Codice del modulo (namespace: Modules\NomeModulo\)
    │   ├── Console/             # Comandi Artisan
    │   ├── Http/                # Controller, Middleware, Requests
    │   ├── Models/              # Modelli Eloquent
    │   ├── Providers/           # Service Provider
    │   └── ...                  # Altri componenti
    ├── config/                  # Configurazioni del modulo
    ├── database/
    │   ├── migrations/          # Migrazioni specifiche del modulo
    │   └── seeders/             # Seeders specifici del modulo
    ├── resources/
    │   ├── assets/              # Asset specifici del modulo
    │   ├── lang/                # Traduzioni
    │   └── views/               # Viste Blade
    ├── routes/                  # Route del modulo
    ├── composer.json            # Dipendenze del modulo
    └── module.json              # Metadati del modulo
```

## Comandi di Installazione
```bash
# Installazione corretta dei moduli
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev --squash
# ... e così via per gli altri moduli

# Installazione corretta del tema
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

## Ordine di Installazione (in base alle dipendenze)
1. module_xot_fila3 (base)
2. module_lang_fila3 (dipende da Xot)
3. module_tenant_fila3 (dipende da Xot)
4. module_ui_fila3 (dipende da Xot)
5. theme_one_fila3 (dipende da UI)
6. module_user_fila3 (dipende da Xot, Tenant)
7. module_media_fila3 (dipende da Xot)
8. module_activity_fila3 (dipende da Xot, User)
9. module_gdpr_fila3 (dipende da Xot, User)
10. module_notify_fila3 (dipende da Xot, User)
11. module_cms_fila3 (dipende da Xot, Media)
12. module_job_fila3 (dipende da Xot)

## Struttura dei Namespace
I moduli Laraxot utilizzano una struttura particolare per i namespace:

1. **Struttura fisica**: I file si trovano nella sottodirectory `app/` del modulo
   - Esempio: `Modules/Chart/app/Providers/ChartServiceProvider.php`

2. **Namespace logico**: Nonostante la posizione fisica, il namespace NON include "App"
   - Esempio: `Modules\Chart\Providers\ChartServiceProvider`

## Manutenzione
- Aggiornamento dipendenze: `composer update`
- Pulizia cache: `php artisan optimize:clear`
- Rimozione migrazioni centrali: `rm -rf database/migrations`
- Esecuzione migrazioni dai moduli: `php artisan module:migrate` 