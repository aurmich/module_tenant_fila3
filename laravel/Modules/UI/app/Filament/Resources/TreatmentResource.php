<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages;
use Modules\Gdpr\Models\Treatment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TreatmentResource extends XotBaseResource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Toggle::make('active')
                ->required(),
            Forms\Components\Toggle::make('required')
                ->required(),
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(191),
            Forms\Components\Textarea::make('description')
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('documentVersion')
                ->maxLength(191)
                ->default(null),
            Forms\Components\TextInput::make('documentUrl')
                ->maxLength(191)
                ->default(null),
            Forms\Components\TextInput::make('weight')
                ->required()
                ->numeric(),
        ];
    }

    public function getListTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('id')
            //
            //     ->searchable(),
            Tables\Columns\IconColumn::make('active')
                ->boolean(),
            Tables\Columns\IconColumn::make('required')
                ->boolean(),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('documentVersion')
                ->searchable(),
            Tables\Columns\TextColumn::make('documentUrl')
                ->searchable(),
            Tables\Columns\TextColumn::make('weight')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
