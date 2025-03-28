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
            Forms\Components\TextInput::make('import_class')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('row_number')
                ->numeric()
                ->required(),
            Forms\Components\Textarea::make('row_data')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make('error_message')
                ->required()
                ->columnSpanFull(),
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
            'index' => Pages\ListFailedImportRows::route('/'),
            'create' => Pages\CreateFailedImportRow::route('/create'),
            'edit' => Pages\EditFailedImportRow::route('/{record}/edit'),
        ];
    }
}
