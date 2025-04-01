<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Resources\PatientResource\Pages;

use Modules\Patient\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\XotBaseResource\Pages\XotBaseListRecords;

class ListPatients extends XotBaseListRecords
{
    protected static string $resource = PatientResource::class;

    public function getListTableColumns(): array
    {
        return [
            'id' => \Filament\Tables\Columns\TextColumn::make('id')
                ->sortable(),
            'name' => \Filament\Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'surname' => \Filament\Tables\Columns\TextColumn::make('surname')
                ->searchable()
                ->sortable(),
            'fiscal_code' => \Filament\Tables\Columns\TextColumn::make('fiscal_code')
                ->searchable(),
            'birth_date' => \Filament\Tables\Columns\TextColumn::make('birth_date')
                ->date()
                ->sortable(),
            'email' => \Filament\Tables\Columns\TextColumn::make('email')
                ->searchable(),
            'phone' => \Filament\Tables\Columns\TextColumn::make('phone'),
            'created_at' => \Filament\Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => \Filament\Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
