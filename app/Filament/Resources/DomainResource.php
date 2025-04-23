<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Modules\Tenant\Filament\Resources\DomainResource\Pages;
use Modules\Tenant\Models\Domain;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DomainResource extends XotBaseResource
{
    protected static ?string $model = Domain::class;

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> de24ed2 (fix: auto resolve conflict)
    public static function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->required()
                ->string()
                ->maxLength(255),
            'brand' => TextInput::make('brand')
                ->required()
                ->string()
                ->maxLength(255),
            'category' => TextInput::make('category')
                ->required()
                ->string()
                ->maxLength(255),
            'description' => RichEditor::make('description')
                ->required()
                ->string(),
            'price' => TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('$'),
            'rating' => TextInput::make('rating')
                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(5),
<<<<<<< HEAD
=======
=======
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            // Define your form schema here
            TextInput::make('title'),
            TextInput::make('brand'),
            TextInput::make('category'),
            RichEditor::make('description'),
            TextInput::make('price')
                ->prefix('$'),
            TextInput::make('rating')
                ->numeric(),
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDomains::route('/'),
            'create' => Pages\CreateDomain::route('/create'),
            'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}
