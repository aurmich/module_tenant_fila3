<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\PasswordInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegistrationWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.registration';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Dati Personali')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->label('Nome'),
                            TextInput::make('surname')
                                ->required()
                                ->label('Cognome'),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique('users')
                                ->label('Email'),
                        ]),
                    Wizard\Step::make('Credenziali')
                        ->schema([
                            PasswordInput::make('password')
                                ->required()
                                ->label('Password'),
                            PasswordInput::make('password_confirmation')
                                ->required()
                                ->same('password')
                                ->label('Conferma Password'),
                        ]),
                ])
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->form->fill();

        $this->dispatch('registration-completed');
    }
}
