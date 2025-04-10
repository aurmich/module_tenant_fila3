<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Pages;

use Filament\Tables;
use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListStoredEvents extends XotBaseListRecords
{
    protected static string $resource = StoredEventResource::class;

    /**
     * @return array<string, Tables\Columns\Column>
     */
    public function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id'),
            'event_class' => Tables\Columns\TextColumn::make('event_class'),
            'event_properties' => Tables\Columns\ViewColumn::make('event_properties')
                ->view('activity::filament.tables.columns.event-properties'),
        ];
    }
}
