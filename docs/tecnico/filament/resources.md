# Resources Filament

## XotBaseResource

La classe base per tutte le risorse Filament:

```php
abstract class XotBaseResource extends FilamentResource
{
    use NavigationLabelTrait;

    protected static ?string $model = null;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    // Metodi principali
    abstract public static function getFormSchema(): array;
    
    // Metodi utili
    public static function getModuleName(): string
    public static function getModel(): string
    public static function getNavigationBadge(): ?string
    public static function getPages(): array
    public static function getRelations(): array
}
```

## Implementazione

### 1. Creazione Resource
```php
class ArticleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Resources/
            ├── ArticleResource.php
            └── RelationManagers/
                └── CommentsRelationManager.php
```

### 3. Funzionalità Base
- Rilevamento automatico del modello
- Badge di navigazione
- Pagine standard (List, Create, Edit, View)
- Relation managers automatici
- Traduzioni integrate

### 4. Best Practices
- Naming: `ModelNameResource`
- Namespace: `Modules\ModuleName\Filament\Resources`
- Implementare sempre `getFormSchema()`
- Utilizzare type hints
- Documentare PHPDoc

### 5. Esempio Completo
```php
declare(strict_types=1);

namespace Modules\Blog\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ArticleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }

    public static function getNavigationGroup(): string
    {
        return 'Blog';
    }
}
```

## Relation Managers

### 1. Creazione
```php
class CommentsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'comments';
    protected static ?string $recordTitleAttribute = 'title';
}
```

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Resources/
            └── ArticleResource/
                └── RelationManagers/
                    └── CommentsRelationManager.php
```

### 3. Best Practices
- Naming: `RelatedModelRelationManager`
- Definire sempre `$relationship`
- Definire `$recordTitleAttribute`
- Utilizzare type hints
- Documentare PHPDoc

## Testing

### 1. Resource Test
```php
class ArticleResourceTest extends TestCase
{
    public function test_can_list_articles()
    {
        // Test implementation
    }
}
```

### 2. Relation Manager Test
```php
class CommentsRelationManagerTest extends TestCase
{
    public function test_can_list_comments()
    {
        // Test implementation
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare directory Resources
   - Creare classe base
   - Configurare namespace

2. **Implementazione**
   - Definire schema form
   - Configurare navigazione
   - Aggiungere relation managers

3. **Testing**
   - Test resource
   - Test relation managers
   - Test navigazione

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG 