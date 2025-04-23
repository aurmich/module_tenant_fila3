# PHPStan Report - Livello 4

## Errori rilevati
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Domain.php: PHPDoc tag @property-read for property Modules\Tenant\Models\Domain::$creator contains unknown class Modules\Broker\Models\Profile. (line 26)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Domain.php: PHPDoc tag @property-read for property Modules\Tenant\Models\Domain::$updater contains unknown class Modules\Broker\Models\Profile. (line 26)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Tenant.php: PHPDoc type array<int, string> of property Modules\Tenant\Models\Tenant::$fillable is not covariant with PHPDoc type list<string> of overridden property Modules\Xot\Models\BaseModel::$fillable. (line 48)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/database/migrations/2024_03_31_000001_create_tenants_table.php: PHPDoc tag @var above a method has no effect. (line 20)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/database/migrations/2024_03_31_000001_create_tenants_table.php: PHPDoc tag @var does not specify variable name. (line 20)

## Soluzioni proposte

> TODO: descrivere soluzioni architetturali e funzionali
