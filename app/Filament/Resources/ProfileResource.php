<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms;
use Modules\Gdpr\Filament\Resources\ProfileResource\Pages;
use Modules\Gdpr\Models\Profile;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ProfileResource extends XotBaseResource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('type')
                ->maxLength(255)
                ->default(null),
            Forms\Components\TextInput::make('first_name')
                ->maxLength(191)
                ->default(null),
            Forms\Components\TextInput::make('last_name')
                ->maxLength(191)
                ->default(null),
            Forms\Components\TextInput::make('full_name')
                ->maxLength(191)
                ->default(null),
            Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(191)
                ->default(null),
            Forms\Components\TextInput::make('user_id')
                ->maxLength(36)
                ->default(null),
            Forms\Components\TextInput::make('updated_by')
                ->maxLength(36)
                ->default(null),
            Forms\Components\TextInput::make('created_by')
                ->maxLength(36)
                ->default(null),
            Forms\Components\TextInput::make('deleted_by')
                ->maxLength(36)
                ->default(null),
            Forms\Components\Toggle::make('is_active')
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
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
