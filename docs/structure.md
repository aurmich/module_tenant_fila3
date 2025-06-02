# Modulo Tenant

Data: 2025-04-23 19:09:56

## Informazioni generali

- **Namespace principale**: Modules\\Tenant
Modules\\Tenant\\Database\\Factories
Modules\\Tenant\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_tenant_fila3
Marco Xot
- **Dipendenze**: repositories_comment type path url ../User type path url ../Media type path url ../Xot extra laravel providers Modules\\Tenant\\Providers\\TenantServiceProvider Modules\\Tenant\\Providers\\Filament\\AdminPanelProvider 
- **Totale file PHP**: 45
- **Totale classi/interfacce**: 22

## Struttura delle directory

```

.git
.git/branches
.git/hooks
.git/info
.git/logs
.git/logs/refs
.git/logs/refs/heads
.git/logs/refs/remotes
.git/logs/refs/remotes/aurmich
.git/objects
.git/objects/01
.git/objects/02
.git/objects/03
.git/objects/04
.git/objects/05
.git/objects/06
.git/objects/07
.git/objects/08
.git/objects/0a
.git/objects/0b
.git/objects/0c
.git/objects/0f
.git/objects/10
.git/objects/11
.git/objects/12
.git/objects/13
.git/objects/14
.git/objects/16
.git/objects/19
.git/objects/1a
.git/objects/1b
.git/objects/1d
.git/objects/1e
.git/objects/21
.git/objects/23
.git/objects/24
.git/objects/25
.git/objects/28
.git/objects/2a
.git/objects/2b
.git/objects/2d
.git/objects/2e
.git/objects/2f
.git/objects/30
.git/objects/31
.git/objects/33
.git/objects/34
.git/objects/36
.git/objects/39
.git/objects/3a
.git/objects/3b
.git/objects/3c
.git/objects/3f
.git/objects/40
.git/objects/41
.git/objects/42
.git/objects/44
.git/objects/49
.git/objects/4b
.git/objects/4c
.git/objects/4e
.git/objects/4f
.git/objects/51
.git/objects/52
.git/objects/53
.git/objects/54
.git/objects/56
.git/objects/58
.git/objects/59
.git/objects/5a
.git/objects/5b
.git/objects/5c
.git/objects/5d
.git/objects/5e
.git/objects/5f
.git/objects/60
.git/objects/61
.git/objects/62
.git/objects/63
.git/objects/65
.git/objects/66
.git/objects/69
.git/objects/6a
.git/objects/6c
.git/objects/6d
.git/objects/6e
.git/objects/71
.git/objects/72
.git/objects/73
.git/objects/75
.git/objects/76
.git/objects/78
.git/objects/79
.git/objects/7b
.git/objects/7c
.git/objects/7f
.git/objects/80
.git/objects/81
.git/objects/82
.git/objects/83
.git/objects/84
.git/objects/89
.git/objects/8b
.git/objects/90
.git/objects/93
.git/objects/95
.git/objects/97
.git/objects/99
.git/objects/9a
.git/objects/9c
.git/objects/9d
.git/objects/9e
.git/objects/9f
.git/objects/a0
.git/objects/a2
.git/objects/a3
.git/objects/a4
.git/objects/a5
.git/objects/a6
.git/objects/a7
.git/objects/a8
.git/objects/a9
.git/objects/ab
.git/objects/ac
.git/objects/af
.git/objects/b0
.git/objects/b1
.git/objects/b3
.git/objects/b4
.git/objects/b5
.git/objects/b6
.git/objects/b7
.git/objects/b9
.git/objects/bb
.git/objects/bd
.git/objects/c2
.git/objects/c4
.git/objects/c5
.git/objects/c7
.git/objects/c9
.git/objects/ca
.git/objects/cb
.git/objects/cd
.git/objects/cf
.git/objects/d1
.git/objects/d2
.git/objects/d3
.git/objects/d4
.git/objects/d5
.git/objects/d6
.git/objects/d7
.git/objects/d9
.git/objects/dc
.git/objects/dd
.git/objects/de
.git/objects/df
.git/objects/e0
.git/objects/e1
.git/objects/e2
.git/objects/e5
.git/objects/e6
.git/objects/e8
.git/objects/e9
.git/objects/eb
.git/objects/ec
.git/objects/ee
.git/objects/f0
.git/objects/f1
.git/objects/f3
.git/objects/f4
.git/objects/f7
.git/objects/f8
.git/objects/f9
.git/objects/fe
.git/objects/ff
.git/objects/info
.git/objects/pack
.git/refs
.git/refs/heads
.git/refs/remotes
.git/refs/remotes/aurmich
.git/refs/tags
.github
.github/workflows
.vscode
_docs
app
app/Actions
app/Actions/Domains
app/Console
app/Console/Commands
app/Enums
app/Filament
app/Filament/Filament
app/Filament/Filament/Resources
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/DomainResource
app/Filament/Resources/DomainResource/Pages
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Middleware
app/Http/Requests
app/Models
app/Models/Policies
app/Models/Traits
app/Providers
app/Providers/Filament
app/Services
app/Traits
app/View
app/View/Components
app/View/View
app/View/View/Components
bashscripts
config
database
database/Factories
database/Migrations
database/Seeders
database/factories
database/migrations
database/seeders
docs
docs/en
docs/it
docs/it/config
docs/it/links
docs/models
docs/models/traits
docs/phpstan
docs/traits
lang
lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/img
resources/svg
resources/svg/navigation
resources/views
resources/views/admin
resources/views/admin/dashboard
resources/views/components
resources/views/filament
resources/views/filament/pages
resources/views/layouts
routes
tests
tests/Feature
tests/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Tenant\\": "app/",
            "Modules\\Tenant\\Database\\Factories\\": "database/factories/",
            "Modules\\Tenant\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "scripts": {
        "post-autoload-dump1": [
            "@php vendor/bin/testbench package:discover --ansi"
        ],
        "post-update-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate"
        ],
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "phpstan/extension-installer": true,
            "pestphp/pest-plugin": true,
```

## Dipendenze da altri moduli

-       1 Modules\Xot\Traits\Updater;
-       1 Modules\Xot\Providers\XotBaseServiceProvider;
-       1 Modules\Xot\Providers\XotBaseRouteServiceProvider;
-       1 Modules\Xot\Providers\Filament\XotBasePanelProvider;
-       1 Modules\Xot\Models\BaseModel;
-       1 Modules\Xot\Filament\Resources\XotBaseResource;
-       1 Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
-       1 Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
-       1 Modules\Xot\Database\Migrations\XotBaseMigration;
-       1 Modules\User\Models\User;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)


## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](../../../Gdpr/docs/structure.md)
* [structure.md](../../../Notify/docs/structure.md)
* [structure.md](../../../Xot/docs/structure.md)
* [structure.md](../../../Xot/docs/base/structure.md)
* [structure.md](../../../Xot/docs/config/structure.md)
* [structure.md](../../../User/docs/structure.md)
* [structure.md](../../../UI/docs/structure.md)
* [structure.md](../../../Lang/docs/structure.md)
* [structure.md](../../../Job/docs/structure.md)
* [structure.md](../../../Media/docs/structure.md)
* [structure.md](../../../Tenant/docs/structure.md)
* [structure.md](../../../Activity/docs/structure.md)
* [structure.md](../../../Cms/docs/structure.md)
* [structure.md](../../../Cms/docs/themes/structure.md)
* [structure.md](../../../Cms/docs/components/structure.md)

