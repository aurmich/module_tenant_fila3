# Rapporto PHPStan Livello 8 per il modulo Tenant

Data analisi: 2025-04-15 22:07:27

## Riepilogo

Trovati 2 errori al livello 8.

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
