<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Filament\Forms;
use Modules\Activity\Filament\Resources\StoredEventResource\Pages;
use Modules\Activity\Models\StoredEvent;
use Modules\Xot\Filament\Resources\XotBaseResource;

class StoredEventResource extends XotBaseResource
{
    protected static ?string $model = StoredEvent::class;

    public static function getFormSchema(): array
    {
        return [
            'event_class' => Forms\Components\TextInput::make('event_class')
                ->required()
                ->maxLength(255),

            'event_properties' => Forms\Components\KeyValue::make('event_properties')
                ->columnSpanFull(),

            'aggregate_uuid' => Forms\Components\TextInput::make('aggregate_uuid')
                ->maxLength(36),

            'aggregate_version' => Forms\Components\TextInput::make('aggregate_version')
                ->numeric(),

            'meta_data' => Forms\Components\Textarea::make('meta_data')
                ->columnSpanFull(),

            'created_at' => Forms\Components\DateTimePicker::make('created_at')
                ->required(),
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
            'index' => Pages\ListStoredEvents::route('/'),
            'create' => Pages\CreateStoredEvent::route('/create'),
            'edit' => Pages\EditStoredEvent::route('/{record}/edit'),
        ];
    }
}
