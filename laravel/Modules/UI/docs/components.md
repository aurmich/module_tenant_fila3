# Componenti UI

## Form Components

### CustomSelect
```php
CustomSelect::make('field_name')
    ->label('trans.key')
    ->relationship('relation', 'column')
    ->searchable()
    ->preload()
    ->required()
```

#### Caratteristiche
- Ricerca asincrona
- Precaricamento opzionale
- Supporto per relazioni multiple
- Validazione integrata
- Cache dei risultati

### MoneyInput
```php
use Modules\UI\Forms\Components\MoneyInput;

MoneyInput::make('premio_lordo')
    ->currency('EUR')
    ->step(0.01)
    ->minValue(0)
    ->required()
```

#### Caratteristiche
- Formattazione automatica
- Supporto multi valuta
- Validazione numerica
- Gestione decimali
- Maschere di input

### DateRangePicker
```php
use Modules\UI\Forms\Components\DateRangePicker;

DateRangePicker::make('periodo')
    ->displayFormat('d/m/Y')
    ->minDate(today())
    ->required()
```

#### Caratteristiche
- Selezione range date
- Formati personalizzabili
- Localizzazione
- Validazione range
- Calendario popup

### FileUpload
```php
use Modules\UI\Forms\Components\FileUpload;

FileUpload::make('documento')
    ->disk('s3')
    ->directory('documenti')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(5120) // 5MB
```

## Table Components

### CustomDataTable
```php
use Modules\UI\Tables\Components\CustomDataTable;

CustomDataTable::make()
    ->paginated(true)
    ->searchable(['nome', 'email'])
    ->sortable(['created_at'])
    ->bulkActions([
        'delete' => 'Elimina',
        'export' => 'Esporta'
    ])
```

#### Caratteristiche
- Ordinamento colonne
- Filtri avanzati
- Azioni personalizzabili
- Paginazione
- Export dati

### StatusBadge
```php
use Modules\UI\Tables\Components\StatusBadge;

StatusBadge::make('stato')
    ->colors([
        'danger' => 'annullato',
        'warning' => 'sospeso',
        'success' => 'attivo'
    ])
```

#### Caratteristiche
- Colori dinamici
- Icone integrate
- Stati personalizzabili
- Tooltips
- Animazioni

### ActionButtons
```php
use Modules\UI\Tables\Components\ActionButtons;

ActionButtons::make()
    ->actions([
        'view' => [
            'icon' => 'heroicon-o-eye',
            'url' => fn ($record) => route('view', $record)
        ],
        'edit' => [
            'icon' => 'heroicon-o-pencil',
            'url' => fn ($record) => route('edit', $record)
        ]
    ])
```

## Chart Components

### LineChart
```php
use Modules\UI\Charts\Components\LineChart;

LineChart::make()
    ->datasets([
        [
            'label' => 'Vendite',
            'data' => [10, 20, 30],
            'borderColor' => '#4CAF50'
        ]
    ])
    ->labels(['Gen', 'Feb', 'Mar'])
    ->options([
        'responsive' => true,
        'maintainAspectRatio' => false
    ])
```

#### Caratteristiche
- Dati dinamici
- Zoom e pan
- Tooltips interattivi
- Responsive
- Temi personalizzabili

### PieChart
```php
use Modules\UI\Charts\Components\PieChart;

PieChart::make()
    ->datasets([
        [
            'data' => [30, 50, 20],
            'backgroundColor' => ['#4CAF50', '#2196F3', '#FFC107']
        ]
    ])
    ->labels(['A', 'B', 'C'])
```

#### Caratteristiche
- Legenda interattiva
- Animazioni
- Doughnut mode
- Labels personalizzabili
- Export immagine

### StatsOverview
```php
use Modules\UI\Charts\Components\StatsOverview;

StatsOverview::make()
    ->stats([
        [
            'label' => 'Totale Polizze',
            'value' => 1234,
            'icon' => 'heroicon-o-document-text',
            'color' => 'primary'
        ],
        [
            'label' => 'Premi Totali',
            'value' => '€ 123.456',
            'icon' => 'heroicon-o-currency-euro',
            'color' => 'success'
        ]
    ])
```

## Layout Components

### AdminLayout
```php
use Modules\UI\Layouts\Components\AdminLayout;

AdminLayout::make()
    ->title('Dashboard')
    ->breadcrumbs([
        'Home' => route('home'),
        'Dashboard' => null
    ])
    ->notifications(true)
```

#### Caratteristiche
- Sidebar collassabile
- Breadcrumbs
- Notifiche
- Tema dark/light
- Responsive

### PrintLayout
```php
use Modules\UI\Layouts\Components\PrintLayout;

PrintLayout::make()
    ->orientation('portrait')
    ->pageSize('a4')
    ->margins([
        'top' => 20,
        'right' => 15,
        'bottom' => 20,
        'left' => 15
    ])
```

#### Caratteristiche
- Ottimizzato per stampa
- Header/footer personalizzabili
- Paginazione
- Stili CSS print
- No elementi UI

## Componenti Base

### Forms
```blade
<x-ui::form>
  <x-ui::input name="email" type="email" />
  <x-ui::button type="submit">Invia</x-ui::button>
</x-ui::form>
```

### Tables
```blade
<x-ui::table>
  <x-ui::th>Nome</x-ui::th>
  <x-ui::td>{{ $user->name }}</x-ui::td>
</x-ui::table>
```

### Cards
```blade
<x-ui::card>
  <x-ui::card-header>Titolo</x-ui::card-header>
  <x-ui::card-body>Contenuto</x-ui::card-body>
</x-ui::card>
```

## Componenti Complessi

### Modal
```blade
<x-ui::modal id="my-modal">
  <x-slot name="title">Titolo Modal</x-slot>
  <x-slot name="content">Contenuto Modal</x-slot>
</x-ui::modal>
```

### Dropdown
```blade
<x-ui::dropdown>
  <x-ui::dropdown-item>Opzione 1</x-ui::dropdown-item>
  <x-ui::dropdown-item>Opzione 2</x-ui::dropdown-item>
</x-ui::dropdown>
```

## Layout

### Grid
```blade
<x-ui::grid cols="3">
  <div>Colonna 1</div>
  <div>Colonna 2</div>
  <div>Colonna 3</div>
</x-ui::grid>
```

### Container
```blade
<x-ui::container>
  <x-ui::row>
    <x-ui::col>Contenuto</x-ui::col>
  </x-ui::row>
</x-ui::container>
```

## Utility

### Alert
```blade
<x-ui::alert type="success">
  Operazione completata con successo!
</x-ui::alert>
```

### Badge
```blade
<x-ui::badge type="warning">
  Nuovo
</x-ui::badge>
```

### FilterDropdown
```php
use Modules\UI\Components\FilterDropdown;

FilterDropdown::make('stato')
    ->options([
        'attivo' => 'Attivo',
        'sospeso' => 'Sospeso',
        'annullato' => 'Annullato'
    ])
    ->multiple()
    ->searchable()
```

### Modal
```php
use Modules\UI\Components\Modal;

Modal::make('conferma')
    ->title('Conferma Operazione')
    ->content('Sei sicuro di voler procedere?')
    ->actions([
        'confirm' => [
            'label' => 'Conferma',
            'color' => 'primary'
        ],
        'cancel' => [
            'label' => 'Annulla',
            'color' => 'secondary'
        ]
    ])
```

## Best Practices
1. Utilizzare i componenti esistenti invece di crearne di nuovi
2. Mantenere la consistenza nelle props e negli slot
3. Documentare eventuali modifiche o estensioni
4. Testare la responsività su diversi dispositivi

## Temi
- I componenti supportano i temi tramite Tailwind
- Utilizzare le classi di utility per personalizzazioni
- Rispettare le variabili CSS definite nel tema 

## Configurazione Globale

### Tema
```php
// config/ui.php
return [
    'theme' => [
        'colors' => [
            'primary' => '#4CAF50',
            'secondary' => '#2196F3',
            'success' => '#4CAF50',
            'danger' => '#F44336',
            'warning' => '#FFC107'
        ],
        'fonts' => [
            'base' => 'Inter',
            'mono' => 'JetBrains Mono'
        ]
    ]
];
```

### Personalizzazione
```php
// Pubblicare assets
php artisan vendor:publish --tag=ui-assets

// Pubblicare configurazione
php artisan vendor:publish --tag=ui-config

// Pubblicare views
php artisan vendor:publish --tag=ui-views
```

# Componenti in SaluteOra

I componenti sono elementi riutilizzabili che possono essere utilizzati in qualsiasi vista del tema. Ogni tema può definire i propri componenti.

## Struttura dei Componenti

I componenti sono organizzati in:

```
resources/views/components/
├── blocks/
│   ├── hero/
│   ├── feature_sections/
│   ├── stats/
│   └── cta/
├── forms/
│   ├── input.blade.php
│   ├── label.blade.php
│   └── error.blade.php
└── ui/
    ├── button.blade.php
    ├── card.blade.php
    └── modal.blade.php
```

## Componenti Base

### Button
```blade
@props(['type' => 'button', 'variant' => 'primary'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
>
    {{ $slot }}
</button>
```

### Card
```blade
@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg']) }}>
    @if($title)
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">{{ $title }}</h2>
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
```

### Modal
```blade
@props(['show' => false])

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
            aria-hidden="true"
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
        >
            {{ $slot }}
        </div>
    </div>
</div>
```

## Componenti Form

### Input
```blade
@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
```

### Label
```blade
@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
```

### Error
```blade
@props(['message'])

@if ($message)
    <p {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>
        {{ $message }}
    </p>
@endif
```

## Best Practices

1. **Props**: Definisci solo i props necessari
2. **Validazione**: Valida sempre i dati in input
3. **Accessibilità**: Assicurati che i componenti siano accessibili
4. **Responsive**: Rendi i componenti responsive
5. **Performance**: Ottimizza le performance
6. **Manutenibilità**: Mantieni il codice pulito e documentato
7. **Consistenza**: Mantieni uno stile coerente
8. **Riutilizzo**: Crea componenti riutilizzabili 