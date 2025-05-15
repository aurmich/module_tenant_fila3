<<<<<<< HEAD






>>>>>>> aurmich/dev



>>>>>>> aurmich/dev


>>>>>>> aurmich/dev


>>>>>>> aurmich/dev
>>>>>>> aurmich/dev
# Rapporto PHPStan Livello 9 per il modulo Tenant

Data analisi: 2025-04-15 22:07:33

## Riepilogo

Trovati 2 errori al livello 9.

## Errori e suggerimenti

### File: `/var/www/html/saluteora/laravel/Modules/Tenant/app/Models/Domain.php`

#### Linea 26: PHPDoc tag @property-read for property Modules\Tenant\Models\Domain::$creator contains unknown class Modules\Broker\Models\Profile.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

#### Linea 26: PHPDoc tag @property-read for property Modules\Tenant\Models\Domain::$updater contains unknown class Modules\Broker\Models\Profile.

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

## Risorse utili

- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)
- [Tipi in PHP](https://www.php.net/manual/en/language.types.declarations.php)
- [PSR-12: Standard di codifica](https://www.php-fig.org/psr/psr-12/)



aurmich/dev


>>>>>>> aurmich/dev


aurmich/dev
>>>>>>> aurmich/dev

aurmich/dev
>>>>>>> aurmich/dev


>>>>>>> aurmich/dev
>>>>>>> aurmich/dev
=======
# PHPStan Report - Livello 9

## Errori rilevati
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Domain.php: PHPDoc tag @property-read for property Modules\Tenant\Models\Domain::$creator contains unknown class Modules\Broker\Models\Profile. (line 26)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Domain.php: PHPDoc tag @property-read for property Modules\Tenant\Models\Domain::$updater contains unknown class Modules\Broker\Models\Profile. (line 26)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Tenant.php: PHPDoc type array<int, string> of property Modules\Tenant\Models\Tenant::$fillable is not covariant with PHPDoc type list<string> of overridden property Modules\Xot\Models\BaseModel::$fillable. (line 48)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Tenant.php: Method Modules\Tenant\Models\Tenant::getUrlAttribute() should return string but returns mixed. (line 119)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/database/migrations/2024_03_31_000001_create_tenants_table.php: PHPDoc tag @var above a method has no effect. (line 20)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/database/migrations/2024_03_31_000001_create_tenants_table.php: PHPDoc tag @var does not specify variable name. (line 20)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/tests/Unit/DomainTest.php: Cannot access offset 'name' on mixed. (line 44)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/tests/Unit/DomainTest.php: Cannot access offset 'name' on mixed. (line 45)

## Soluzioni proposte

> TODO: descrivere soluzioni architetturali e funzionali
>>>>>>> eb32fae (.)
