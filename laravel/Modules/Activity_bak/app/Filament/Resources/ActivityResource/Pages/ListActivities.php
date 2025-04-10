<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * @see ActivityResource
 */
class ListActivities extends XotBaseListRecords
{
    protected static string $resource = ActivityResource::class;

    public function getListTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable()
                ->label('ID'),

            'description' => TextColumn::make('description')
                ->searchable()
                ->label('Description'),

            'subject_type' => TextColumn::make('subject_type')
                ->searchable()
                ->label('Subject Type'),

            'subject_id' => TextColumn::make('subject_id')
                ->sortable()
                ->label('Subject ID'),

            'causer_type' => TextColumn::make('causer_type')
                ->searchable()
                ->label('Causer Type'),

            'causer_id' => TextColumn::make('causer_id')
                ->sortable()
                ->label('Causer ID'),

            'created_at' => TextColumn::make('created_at')
                ->sortable()
                ->dateTime()
                ->label('Created At'),

        ];
    }
}
