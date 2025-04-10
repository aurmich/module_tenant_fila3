<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Modules\Activity\Filament\Resources\SnapshotResource\Pages;
use Modules\Activity\Models\Snapshot;
use Modules\Xot\Filament\Resources\XotBaseResource;

class SnapshotResource extends XotBaseResource
{
    protected static ?string $model = Snapshot::class;

    public static function getFormSchema(): array
    {
        return [
            'model_type' => TextInput::make('model_type')
                ->required()
                ->maxLength(255),
            'model_id' => TextInput::make('model_id')
                ->numeric()
                ->required(),
            'state' => KeyValue::make('state')
                ->columnSpanFull(),
            'created_by_type' => TextInput::make('created_by_type')
                ->maxLength(255),
            'created_by_id' => TextInput::make('created_by_id')
                ->numeric(),
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
            'index' => Pages\ListSnapshots::route('/'),
            'create' => Pages\CreateSnapshot::route('/create'),
            'edit' => Pages\EditSnapshot::route('/{record}/edit'),
        ];
    }
}
