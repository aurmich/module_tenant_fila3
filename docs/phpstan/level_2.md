<<<<<<< Updated upstream


=======

=======

>>>>>>> aurmich/dev

=======

>>>>>>> aurmich/dev
=======

>>>>>>> aurmich/dev

=======
>>>>>>> aurmich/dev
>>>>>>> aurmich/dev
# Rapporto PHPStan Livello 2 per il modulo Tenant

Data analisi: 2025-04-15 22:06:48

## Riepilogo

Trovati 2 errori al livello 2.

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


=======
aurmich/dev
=======

>>>>>>> aurmich/dev

=======
aurmich/dev
>>>>>>> aurmich/dev
=======
aurmich/dev
>>>>>>> aurmich/dev

=======
>>>>>>> aurmich/dev
>>>>>>> aurmich/dev
=======
# Analisi PHPStan Livello 2 per il modulo Tenant

Data: Wed Apr 23 21:24:04 CEST 2025

## Errore di esecuzione

```
Note: Using configuration file /var/www/html/_bases/base_quaeris_fila3_mono/laravel/phpstan.neon.
  0/40 [░░░░░░░░░░░░░░░░░░░░░░░░░░░░]   0%[1G[2K 20/40 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓░░░░░░░░░░░░░░]  50%[1G[2K 40/40 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

{"totals":{"errors":0,"file_errors":4},"files":{"/var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/app/Models/Domain.php":{"errors":2,"messages":[{"message":"PHPDoc tag @property-read for property Modules\\Tenant\\Models\\Domain::$creator contains unknown class Modules\\Broker\\Models\\Profile.","line":26,"ignorable":true,"tip":"Learn more at https://phpstan.org/user-guide/discovering-symbols","identifier":"class.notFound"},{"message":"PHPDoc tag @property-read for property Modules\\Tenant\\Models\\Domain::$updater contains unknown class Modules\\Broker\\Models\\Profile.","line":26,"ignorable":true,"tip":"Learn more at https://phpstan.org/user-guide/discovering-symbols","identifier":"class.notFound"}]},"/var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/Tenant/database/migrations/2024_03_31_000001_create_tenants_table.php":{"errors":2,"messages":[{"message":"PHPDoc tag @var above a method has no effect.","line":20,"ignorable":true,"identifier":"varTag.misplaced"},{"message":"PHPDoc tag @var does not specify variable name.","line":20,"ignorable":true,"identifier":"varTag.noVariable"}]}},"errors":[]}```
>>>>>>> Stashed changes
