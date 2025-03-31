# Comandi Principali Moduli SaluteOra

## Installazione
```bash
# Installare un modulo
composer require vendor/module-name

# Abilitare un modulo
php artisan module:enable ModuleName

# Disabilitare un modulo
php artisan module:disable ModuleName

# Lista moduli installati
php artisan module:list

# Lista moduli abilitati
php artisan module:enabled
```

## Configurazione
```bash
# Pubblicare assets
php artisan vendor:publish --provider="Vendor\ModuleName\Providers\ModuleServiceProvider"

# Pubblicare configurazioni
php artisan vendor:publish --provider="Vendor\ModuleName\Providers\ModuleServiceProvider" --tag="config"

# Pubblicare assets
php artisan vendor:publish --provider="Vendor\ModuleName\Providers\ModuleServiceProvider" --tag="assets"

# Pubblicare traduzioni
php artisan vendor:publish --provider="Vendor\ModuleName\Providers\ModuleServiceProvider" --tag="translations"
```

## Database
```bash
# Eseguire migrazioni
php artisan module:migrate ModuleName

# Rollback migrazioni
php artisan module:migrate-rollback ModuleName

# Reset migrazioni
php artisan module:migrate-reset ModuleName

# Eseguire seeders
php artisan module:seed ModuleName

# Refresh database
php artisan module:migrate-refresh ModuleName
```

## Testing
```bash
# Eseguire test
php artisan module:test ModuleName

# Eseguire test specifici
php artisan module:test ModuleName --filter=TestName

# Eseguire test con coverage
php artisan module:test ModuleName --coverage

# Eseguire test paralleli
php artisan module:test ModuleName --parallel
```

## Cache
```bash
# Pulire cache
php artisan module:cache:clear ModuleName

# Pulire config
php artisan module:config:clear ModuleName

# Pulire route
php artisan module:route:clear ModuleName

# Pulire view
php artisan module:view:clear ModuleName
```

## Manutenzione
```bash
# Aggiornare dipendenze
composer update vendor/module-name

# Aggiornare assets
php artisan module:publish ModuleName

# Verificare stato
php artisan module:status ModuleName

# Generare documentazione
php artisan module:doc ModuleName
```

## Note
- Eseguire sempre backup prima di aggiornamenti
- Testare in ambiente staging
- Verificare compatibilità versioni
- Documentare breaking changes 