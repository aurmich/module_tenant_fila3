# Regole Fondamentali SaluteOra

## XotBaseResource
- ✅ SEMPRE estendere `XotBaseResource` invece di `Resource`
- ✅ SEMPRE usare `getFormSchema(): array` invece di `form(Form $form): Form`
- ❌ NON definire `$navigationIcon`, `$navigationGroup`, `$navigationSort`
- ❌ NON definire `table()`, `getTableColumns()`, `getTableFilters()`
- ✅ SEMPRE definire `protected static ?string $model`

## XotBaseListRecords
- ✅ SEMPRE estendere `XotBaseListRecords` invece di `ListRecords`
- ✅ SEMPRE usare `getListTableColumns()` invece di `getTableColumns()`
- ✅ SEMPRE usare `getListTableFilters()` invece di `getTableFilters()`
- ✅ SEMPRE usare `getListTableActions()` invece di `getTableActions()`
- ✅ SEMPRE usare `getListTableBulkActions()` invece di `getTableBulkActions()`

## Traduzioni
- ❌ NON usare `->label()` nei componenti
- ✅ SEMPRE definire le traduzioni nei file di lingua
- ✅ SEMPRE seguire la struttura standard delle traduzioni

## Namespace
- ✅ SEMPRE usare `Modules\{Module}\Filament\Resources`
- ✅ SEMPRE importare da `Modules\Xot\Filament\Resources`

## Metodi Statici
- ✅ `getFormSchema()` deve essere `public static`
- ✅ `$model` deve essere `protected static ?string`
- ❌ NON usare `$this` nei metodi statici 