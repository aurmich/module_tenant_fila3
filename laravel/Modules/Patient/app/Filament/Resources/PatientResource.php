<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Modules\Patient\Models\Patient;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Patient\Filament\Resources\PatientResource\Pages;

class PatientResource extends XotBaseResource
{
    protected static ?string $model = Patient::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            'surname' => Forms\Components\TextInput::make('surname')
                ->required()
                ->maxLength(255),
            'fiscal_code' => Forms\Components\TextInput::make('fiscal_code')
                ->required()
                ->maxLength(16),
            'birth_date' => Forms\Components\DatePicker::make('birth_date')
                ->required(),
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            'phone' => Forms\Components\TextInput::make('phone')
                ->tel()
                ->maxLength(255),
            'address' => Forms\Components\Textarea::make('address')
                ->maxLength(65535)
                ->columnSpanFull(),
            'city' => Forms\Components\TextInput::make('city')
                ->maxLength(255),
            'postal_code' => Forms\Components\TextInput::make('postal_code')
                ->maxLength(20),
            'province' => Forms\Components\TextInput::make('province')
                ->maxLength(255),
            'country' => Forms\Components\TextInput::make('country')
                ->maxLength(255),
            'is_pregnant' => Forms\Components\Toggle::make('is_pregnant')
                ->label('Gestante'),
            'isee_code' => Forms\Components\TextInput::make('isee_code')
                ->label('Codice ISEE')
                ->maxLength(255),
            'isee_value' => Forms\Components\TextInput::make('isee_value')
                ->label('Valore ISEE')
                ->numeric()
                ->prefix('€'),
            'isee_expiry_date' => Forms\Components\DatePicker::make('isee_expiry_date')
                ->label('Data scadenza ISEE'),
            'notes' => Forms\Components\Textarea::make('notes')
                ->label('Note')
                ->columnSpanFull(),
        ];
    }

    // I metodi getRelations() e getPages() sono stati rimossi perché:
    // 1. getRelations() restituisce un array vuoto
    // 2. getPages() contiene solo route standard
    // Secondo le regole del progetto questi metodi sono ridondanti quando estendi XotBaseResource
} 