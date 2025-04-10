<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ProfileResource\Pages;

use Filament\Tables;
use Modules\Gdpr\Filament\Resources\ProfileResource;
use Modules\User\Filament\Resources\BaseProfileResource\Pages\ListProfiles as UserListProfiles;

class ListProfiles extends UserListProfiles
{
    protected static string $resource = ProfileResource::class;

    /**
     * @return array<string, Tables\Columns\Column>
     */
    public function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->searchable(),
            'type' => Tables\Columns\TextColumn::make('type')
                ->searchable(),
            'first_name' => Tables\Columns\TextColumn::make('first_name')
                ->searchable(),
            'last_name' => Tables\Columns\TextColumn::make('last_name')
                ->searchable(),
            'full_name' => Tables\Columns\TextColumn::make('full_name')
                ->searchable(),
            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable(),
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'user_id' => Tables\Columns\TextColumn::make('user_id')
                ->searchable(),
            'updated_by' => Tables\Columns\TextColumn::make('updated_by')
                ->searchable(),
            'created_by' => Tables\Columns\TextColumn::make('created_by')
                ->searchable(),
            'deleted_at' => Tables\Columns\TextColumn::make('deleted_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'deleted_by' => Tables\Columns\TextColumn::make('deleted_by')
                ->searchable(),
            'is_active' => Tables\Columns\IconColumn::make('is_active')
                ->boolean(),
        ];
    }
}
