# Widgets Filament

## XotBaseWidget

La classe base per tutti i widget Filament:

```php
abstract class XotBaseWidget extends Widget
{
    use TransTrait;

    protected static ?string $heading = null;
    protected static ?int $sort = null;
    protected static ?string $pollingInterval = null;

    // Metodi utili
    public static function getModuleName(): string
    public static function trans(string $key): string
    public static function getHeading(): string
    public static function getSort(): int
}
```

## Implementazione

### 1. Creazione Widget
```php
class ArticleStatsWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Statistiche Articoli';
    protected static ?int $sort = 1;
}
```

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Widgets/
            ├── ArticleStatsWidget.php
            └── RecentArticlesWidget.php
```

### 3. Views
```
Module/
└── resources/
    └── views/
        └── filament/
            └── widgets/
                ├── article-stats.blade.php
                └── recent-articles.blade.php
```

### 4. Funzionalità Base
- Traduzioni integrate
- Ordinamento automatico
- Polling automatico
- Layout standard
- Cache support

### 5. Best Practices
- Naming: `ModelNameWidget`
- Namespace: `Modules\ModuleName\Filament\Widgets`
- Definire sempre `$heading`
- Utilizzare type hints
- Documentare PHPDoc

### 6. Esempio Completo
```php
declare(strict_types=1);

namespace Modules\Blog\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class ArticleStatsWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Statistiche Articoli';
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '10s';

    public function getStats(): array
    {
        return [
            'total' => Article::count(),
            'published' => Article::published()->count(),
            'draft' => Article::draft()->count(),
        ];
    }
}
```

## Tipi di Widget

### 1. Stats Overview
```php
class ArticleStatsWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Statistiche Articoli';
    
    public function getStats(): array
    {
        return [
            'total' => Article::count(),
            'published' => Article::published()->count(),
        ];
    }
}
```

### 2. Chart Widget
```php
class ArticleViewsChartWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Visualizzazioni Articoli';
    
    public function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Visualizzazioni',
                    'data' => Article::views()->get(),
                ],
            ],
        ];
    }
}
```

### 3. Table Widget
```php
class RecentArticlesWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Articoli Recenti';
    
    public function getArticles()
    {
        return Article::latest()->take(5)->get();
    }
}
```

## Views Blade

### 1. Stats View
```blade
<x-filament-widgets::widget>
    <div class="grid grid-cols-3 gap-4">
        @foreach($stats as $key => $value)
            <div class="p-4 bg-white rounded-lg shadow">
                <h3 class="text-lg font-medium">
                    {{ trans('blog::article.stats.' . $key) }}
                </h3>
                <p class="text-2xl font-bold">
                    {{ $value }}
                </p>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
```

### 2. Chart View
```blade
<x-filament-widgets::widget>
    <div class="h-64">
        <canvas id="article-views-chart"></canvas>
    </div>
</x-filament-widgets::widget>
```

### 3. Table View
```blade
<x-filament-widgets::widget>
    <x-filament::table>
        <x-slot name="header">
            <x-filament::table.header-cell>
                {{ trans('blog::article.title') }}
            </x-filament::table.header-cell>
        </x-slot>

        @foreach($articles as $article)
            <x-filament::table.row>
                <x-filament::table.cell>
                    {{ $article->title }}
                </x-filament::table.cell>
            </x-filament::table.row>
        @endforeach
    </x-filament::table>
</x-filament-widgets::widget>
```

## Testing

### 1. Widget Test
```php
class ArticleStatsWidgetTest extends TestCase
{
    public function test_can_render_widget()
    {
        $widget = new ArticleStatsWidget();
        $this->assertIsArray($widget->getStats());
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare directory Widgets
   - Creare views
   - Configurare namespace

2. **Implementazione**
   - Definire logica
   - Creare views
   - Configurare layout

3. **Testing**
   - Test rendering
   - Test dati
   - Test cache

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG 