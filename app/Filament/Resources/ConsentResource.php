<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Gdpr\Filament\Resources\ConsentResource\Pages;
use Modules\Gdpr\Models\Consent;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ConsentResource extends XotBaseResource
{
    protected static ?string $model = Consent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('treatment_id')
                ->relationship('treatment', 'name')
                ->required(),
            Forms\Components\TextInput::make('subject_id')
                ->required()
                ->maxLength(191),
        ];
    }

    public function getListTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')

                ->searchable(),
            Tables\Columns\TextColumn::make('treatment.name')
                ->searchable(),
            Tables\Columns\TextColumn::make('subject_id')
                ->searchable(),
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
            'index' => Pages\ListConsents::route('/'),
            'create' => Pages\CreateConsent::route('/create'),
            'edit' => Pages\EditConsent::route('/{record}/edit'),
        ];
    }
}
