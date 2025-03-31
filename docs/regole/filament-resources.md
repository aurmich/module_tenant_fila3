# Regole per le Risorse Filament

## Principi Fondamentali
- **MAI utilizzare** il metodo `->label()` nei componenti Filament
- Le etichette sono gestite automaticamente dal `LangServiceProvider`
- Utilizzare i file di traduzione per definire le etichette dei campi

## Struttura Base
- Tutte le risorse Filament devono essere nella directory `app/Filament/Resources`
- Ogni risorsa deve estendere `Filament\Resources\Resource`
- Ogni risorsa deve implementare i metodi richiesti

## Struttura Directory
```
app/
└── Filament/
    └── Resources/
        ├── PatientResource.php
        ├── DocumentResource.php
        └── AnamnesisResource.php
```

## Implementazione Base
```php
namespace Modules\Patient\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Patient\Models\Patient;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestione Pazienti';
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
```

## Validazione
- Verificare che tutte le risorse siano registrate nel service provider
- Controllare che i modelli referenziati esistano
- Assicurarsi che le pagine CRUD siano implementate
- Verificare i permessi e le policy