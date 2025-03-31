# Forms Filament

## XotBaseForm

La classe base per tutti i form Filament:

```php
abstract class XotBaseForm extends Form
{
    use TransTrait;

    protected static ?string $model = null;
    protected static ?string $recordTitleAttribute = null;

    // Metodi utili
    public static function getModuleName(): string
    public static function trans(string $key): string
    public static function getModel(): string
    public static function getRecordTitleAttribute(): string
}
```

## Implementazione

### 1. Creazione Form
```php
class ArticleForm extends XotBaseForm
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
        └── Forms/
            ├── ArticleForm.php
            └── CommentForm.php
```

### 3. Funzionalità Base
- Traduzioni integrate
- Model binding
- Validazione automatica
- Layout standard
- Relazioni automatiche

### 4. Best Practices
- Naming: `ModelNameForm`
- Namespace: `Modules\ModuleName\Filament\Forms`
- Implementare sempre `getFormSchema()`
- Utilizzare type hints
- Documentare PHPDoc

### 5. Esempio Completo
```php
declare(strict_types=1);

namespace Modules\Blog\Filament\Forms;

use Modules\Xot\Filament\Forms\XotBaseForm;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;

class ArticleForm extends XotBaseForm
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label(static::trans('title'))
                ->required()
                ->maxLength(255),

            RichEditor::make('content')
                ->label(static::trans('content'))
                ->required(),

            Select::make('status')
                ->label(static::trans('status'))
                ->options([
                    'draft' => static::trans('status.draft'),
                    'published' => static::trans('status.published'),
                ])
                ->required(),
        ];
    }
}
```

## Componenti Form

### 1. Input Base
```php
TextInput::make('title')
    ->label(static::trans('title'))
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'title')
    ->helperText(static::trans('title.help'))
```

### 2. Editor Rich Text
```php
RichEditor::make('content')
    ->label(static::trans('content'))
    ->required()
    ->toolbarButtons([
        'bold',
        'italic',
        'link',
        'orderedList',
        'unorderedList',
    ])
```

### 3. Select
```php
Select::make('category_id')
    ->label(static::trans('category'))
    ->relationship('category', 'name')
    ->required()
    ->searchable()
    ->preload()
```

### 4. Date/Time
```php
DateTimePicker::make('published_at')
    ->label(static::trans('published_at'))
    ->required()
    ->default(now())
    ->timezone('Europe/Rome')
```

### 5. File Upload
```php
FileUpload::make('image')
    ->label(static::trans('image'))
    ->image()
    ->directory('articles')
    ->maxSize(5120)
    ->imageResizeMode('cover')
    ->imageCropAspectRatio('16:9')
```

### 6. Toggle
```php
Toggle::make('is_featured')
    ->label(static::trans('is_featured'))
    ->default(false)
    ->helperText(static::trans('is_featured.help'))
```

## Validazione

### 1. Regole Base
```php
TextInput::make('title')
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'title')
```

### 2. Regole Personalizzate
```php
TextInput::make('slug')
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'slug')
    ->rules([
        'regex:/^[a-z0-9-]+$/',
        function (string $attribute, mixed $value, Closure $fail) {
            if (str_contains($value, '--')) {
                $fail('Lo slug non può contenere trattini consecutivi.');
            }
        },
    ])
```

### 3. Messaggi di Errore
```php
TextInput::make('title')
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'title')
    ->validationMessages([
        'required' => static::trans('validation.required'),
        'max' => static::trans('validation.max'),
        'unique' => static::trans('validation.unique'),
    ])
```

## Relazioni

### 1. Belongs To
```php
Select::make('category_id')
    ->relationship('category', 'name')
    ->required()
    ->searchable()
    ->preload()
```

### 2. Has Many
```php
Repeater::make('comments')
    ->relationship()
    ->schema([
        TextInput::make('content'),
        DateTimePicker::make('created_at'),
    ])
```

### 3. Many To Many
```php
Select::make('tags')
    ->relationship('tags', 'name')
    ->multiple()
    ->searchable()
    ->preload()
```

## Testing

### 1. Form Test
```php
class ArticleFormTest extends TestCase
{
    public function test_can_validate_form()
    {
        $form = new ArticleForm();
        $data = [
            'title' => '',
            'content' => '',
        ];

        $this->assertFalse($form->validate($data));
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare directory Forms
   - Creare classe base
   - Configurare namespace

2. **Implementazione**
   - Definire schema
   - Configurare validazione
   - Gestire relazioni

3. **Testing**
   - Test validazione
   - Test relazioni
   - Test submit

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG 