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
<<<<<<< HEAD
    protected static null|string $model = Domain::class;

    #[\Override]
=======
    protected static ?string $model = Domain::class;

>>>>>>> 1cbc182 (.)
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
<<<<<<< HEAD
            'description' => RichEditor::make('description')->required()->string(),
=======
            'description' => RichEditor::make('description')
                ->required()
                ->string(),
>>>>>>> 1cbc182 (.)
            'price' => TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('$'),
            'rating' => TextInput::make('rating')
                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(5),
        ];
    }

<<<<<<< HEAD
    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
=======
    public static function getRelations(): array
    {
        return [
        ];
    }

>>>>>>> 1cbc182 (.)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDomains::route('/'),
            'create' => Pages\CreateDomain::route('/create'),
            'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}
