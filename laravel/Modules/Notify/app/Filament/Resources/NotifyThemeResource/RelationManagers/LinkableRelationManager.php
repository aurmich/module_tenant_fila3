<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
<<<<<<< HEAD
use Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;
=======
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
>>>>>>> aa7e3755 (.)

class LinkableRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'linkable';

    protected static ?string $recordTitleAttribute = 'id';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('id')
                ->required()
                ->maxLength(255),
        ];
    }
}
