<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Modules\Notify\Filament\Resources\ContactResource\Pages;
use Modules\Notify\Models\Contact;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ContactResource extends XotBaseResource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->hint(static::trans('fields.name.hint'))
                ->required()
                ->maxLength(255),
            'email' => TextInput::make('email')
                ->hint(static::trans('fields.email.hint'))
                ->email()
                ->required()
                ->maxLength(255),
            'phone' => TextInput::make('phone')
                ->hint(static::trans('fields.phone.hint'))
                ->tel()
                ->maxLength(255),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
