<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms;
use Modules\Gdpr\Filament\Resources\EventResource\Pages;
use Modules\Gdpr\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('treatment_id')
                ->maxLength(36)
                ->default(null),
            Forms\Components\Select::make('consent_id')
                ->relationship('consent', 'id'),
            Forms\Components\TextInput::make('subject_id')
                ->required()
                ->maxLength(191),
            Forms\Components\TextInput::make('ip')
                ->required()
                ->maxLength(191),
            Forms\Components\TextInput::make('action')
                ->required()
                ->maxLength(191),
            Forms\Components\Textarea::make('payload')
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
