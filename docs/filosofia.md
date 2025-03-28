# Filosofia e Regole di SaluteOra

## 1. Type Safety e Modern PHP

### 1.1 Type Hints e Null Safety
```php
// ❌ Da evitare
public function process($obj) {
    if (is_object($obj)) {
        $obj->process();
    }
}

// ✅ Corretto
public function process(?ProcessableInterface $obj): void {
    $obj?->process();
}
```

### 1.2 Union Types e Return Types
```php
// ❌ Da evitare
public function handle($obj) {
    return $obj->toString();
}

// ✅ Corretto
public function handle(object|null $obj): string|null {
    return $obj?->toString();
}
```

## 2. Convenzioni Filament

### 2.1 Visibilità dei Metodi
```php
class PatientResource extends XotBaseResource
{
    // ✅ Metodi pubblici per configurazione
    public function getListTableColumns(): array
    public function getTableFilters(): array
    public function getTableActions(): array
    
    // ✅ Metodi protected per configurazioni di default
    protected function getDefaultTableSortColumn(): ?string
    protected function getDefaultTableSortDirection(): ?string
}
```

### 2.2 Tipizzazione delle Colonne
```php
/**
 * @return array<string, Tables\Columns\Column>
 */
public function getListTableColumns(): array
{
    return [
        'nome' => TextColumn::make('nome')
            ->searchable()
            ->sortable(),
    ];
}
```

## 3. Struttura del Progetto

### 3.1 Namespace
- Core: `Modules\Core`
- Patient: `Modules\Patient`
- Dental: `Modules\Dental`
- ISEE: `Modules\ISEE`

### 3.2 Organizzazione dei File
```
modules/
├── core/
│   ├── Filament/
│   │   ├── Resources/
│   │   ├── Pages/
│   │   └── Widgets/
│   └── Models/
├── patient/
│   ├── Filament/
│   │   ├── Resources/
│   │   ├── Pages/
│   │   └── Widgets/
│   └── Models/
└── ...
```

## 4. Documentazione

### 4.1 PHPDoc Requirements
```php
/**
 * Patient Resource
 * 
 * Gestisce le operazioni CRUD sui pazienti.
 * 
 * @property string $nome Nome del paziente
 * @property string $cognome Cognome del paziente
 * @property string $codice_fiscale Codice fiscale del paziente
 * 
 * @see \Modules\Patient\Models\Patient
 */
class PatientResource extends XotBaseResource
{
    // ...
}
```

### 4.2 Documentazione delle API
- Ogni endpoint deve essere documentato con OpenAPI/Swagger
- Includere esempi di request/response
- Documentare gli errori possibili

## 5. Testing

### 5.1 Test Requirements
- Test unitari per ogni modello
- Test di integrazione per le risorse Filament
- Test e2e per i flussi critici

### 5.2 Esempio di Test
```php
class PatientResourceTest extends TestCase
{
    public function test_can_list_patients(): void
    {
        $this->get(route('filament.resources.patient.index'))
            ->assertSuccessful();
    }
}
```

## 6. Performance

### 6.1 Query Optimization
```php
class PatientResource extends XotBaseResource
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['visits', 'isee'])
            ->latest();
    }
}
```

### 6.2 Cache Implementation
```php
class PatientStatsWidget extends XotBaseWidget
{
    public function getData(): array
    {
        return Cache::remember('patient_stats', 3600, function () {
            return [
                'total' => Patient::count(),
                'active' => Patient::active()->count(),
            ];
        });
    }
}
```

## 7. Sicurezza

### 7.1 Permessi
```php
class PatientResource extends XotBaseResource
{
    public static function canViewAny(): bool
    {
        return auth()?->user()?->can('view_patients');
    }
}
```

### 7.2 Validazione
```php
class PatientForm extends XotBaseForm
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('codice_fiscale')
                ->required()
                ->unique(Patient::class)
                ->rules(['regex:/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/']),
        ];
    }
}
```

## 8. Localizzazione

### 8.1 File di Traduzione
```php
// patient.php
return [
    'resources' => [
        'patient' => [
            'title' => 'Paziente',
            'navigation' => [
                'group' => 'Gestione Pazienti',
                'label' => 'Pazienti',
            ],
        ],
    ],
];
```

### 8.2 Uso delle Traduzioni
```php
class PatientResource extends XotBaseResource
{
    public function getTitle(): string
    {
        return $this->trans('patient.title');
    }
}
```

## 9. Best Practices

### 9.1 Codice
- Utilizzare strict types: `declare(strict_types=1);`
- Definire sempre i tipi di ritorno
- Utilizzare type hints per i parametri
- Utilizzare null-safe operator quando appropriato

### 9.2 Git
- Commit atomici e descrittivi
- Branch naming: feature/, bugfix/, hotfix/
- Pull request con descrizione dettagliata
- Code review obbligatoria

### 9.3 Deployment
- CI/CD pipeline automatizzata
- Test automatici prima del deploy
- Backup automatici del database
- Monitoraggio delle performance 