<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\EventResource\Pages;

use Filament\Tables;
use Modules\Gdpr\Filament\Resources\EventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListEvents extends XotBaseListRecords
{
    protected static string $resource = EventResource::class;

    public function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'treatment_id' => Tables\Columns\TextColumn::make('treatment_id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'consent_id' => Tables\Columns\TextColumn::make('consent.id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'subject_id' => Tables\Columns\TextColumn::make('subject_id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'ip' => Tables\Columns\TextColumn::make('ip')
                ->searchable(),
            'action' => Tables\Columns\TextColumn::make('action')
                ->searchable(),
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
