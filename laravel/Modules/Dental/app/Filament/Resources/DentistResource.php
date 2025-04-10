<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Dental\Models\Dentist;
use Modules\Dental\Filament\Resources\DentistResource\Pages;

class DentistResource extends XotBaseResource
{
    protected static ?string $model = Dentist::class;
    
    public static function getFormSchema(): array
    {
        return [
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),
                
            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
                
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
                
            'phone' => Forms\Components\TextInput::make('phone')
                ->tel()
                ->maxLength(20),
                
            'specialization' => Forms\Components\TextInput::make('specialization')
                ->maxLength(255),
                
            'registration_number' => Forms\Components\TextInput::make('registration_number')
                ->required()
                ->maxLength(50),
                
            'is_active' => Forms\Components\Toggle::make('is_active')
                ->default(true),
                
            'notes' => Forms\Components\Textarea::make('notes')
                ->maxLength(1000)
                ->columnSpanFull(),
        ];
    }
    
    public static function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                
            'full_name' => Tables\Columns\TextColumn::make('full_name')
                ->searchable(['first_name', 'last_name'])
                ->sortable(),
                
            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
                
            'phone' => Tables\Columns\TextColumn::make('phone')
                ->searchable(),
                
            'specialization' => Tables\Columns\TextColumn::make('specialization')
                ->searchable(),
                
            'registration_number' => Tables\Columns\TextColumn::make('registration_number')
                ->searchable(),
                
            'is_active' => Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
                
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
