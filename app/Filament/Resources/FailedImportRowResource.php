<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Filament\Forms;
use Modules\Job\Filament\Resources\FailedImportRowResource\Pages;
use Modules\Job\Models\FailedImportRow;
use Modules\Xot\Filament\Resources\XotBaseResource;

class FailedImportRowResource extends XotBaseResource
{
    protected static ?string $model = FailedImportRow::class;

    public static function getFormSchema(): array
    {
        return [
            'import_class' => Forms\Components\TextInput::make('import_class')
                ->required()
                ->maxLength(255),
            'row_number' => Forms\Components\TextInput::make('row_number')
                ->numeric()
                ->required(),
            'row_data' => Forms\Components\Textarea::make('row_data')
                ->required()
                ->columnSpanFull(),
            'error_message' => Forms\Components\Textarea::make('error_message')
                ->required()
                ->columnSpanFull(),
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }
}
