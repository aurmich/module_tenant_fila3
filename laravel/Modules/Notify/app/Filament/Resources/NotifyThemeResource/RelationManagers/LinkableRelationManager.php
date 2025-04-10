<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
<<<<<<< HEAD
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
=======
use Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;
>>>>>>> origin/dev

class LinkableRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'linkable';

    protected static ?string $recordTitleAttribute = 'id';

<<<<<<< HEAD
    public function getFormSchema(): array
    {
        return [
            TextInput::make('id')
                ->required()
                ->maxLength(255),
        ];
=======
    public function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    TextInput::make('id')
                        ->required()
                        ->maxLength(255),
                ]
            );
>>>>>>> origin/dev
    }
}
