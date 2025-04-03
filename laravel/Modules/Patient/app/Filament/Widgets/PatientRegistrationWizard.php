<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Support\HtmlString;
use Modules\Patient\Models\Patient;

class PatientRegistrationWizard extends Component
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('Dati Personali')
                    ->icon('heroicon-o-user')
                    ->description('Inserisci i tuoi dati personali')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('surname')
                                    ->label('Cognome')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        TextInput::make('fiscal_code')
                            ->label('Codice Fiscale')
                            ->required()
                            ->maxLength(16)
                            ->unique(Patient::class)
                            ->alpha(),
                        DatePicker::make('birth_date')
                            ->label('Data di Nascita')
                            ->required()
                            ->maxDate(now()),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Patient::class),
                                TextInput::make('phone')
                                    ->label('Telefono')
                                    ->tel()
                                    ->maxLength(255),
                            ]),
                    ]),

                Step::make('Indirizzo')
                    ->icon('heroicon-o-home')
                    ->description('Inserisci il tuo indirizzo')
                    ->schema([
                        TextInput::make('address')
                            ->label('Indirizzo')
                            ->required()
                            ->maxLength(255),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('city')
                                    ->label('Città')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('postal_code')
                                    ->label('CAP')
                                    ->required()
                                    ->maxLength(20),
                                TextInput::make('province')
                                    ->label('Provincia')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        TextInput::make('country')
                            ->label('Paese')
                            ->default('Italia')
                            ->required()
                            ->maxLength(255),
                    ]),

                Step::make('Stato di Salute')
                    ->icon('heroicon-o-heart')
                    ->description('Informazioni sullo stato di salute')
                    ->schema([
                        Toggle::make('is_pregnant')
                            ->label('Sei in stato di gravidanza?')
                            ->inline(false)
                            ->required(),
                        Section::make('Dati ISEE')
                            ->schema([
                                TextInput::make('isee_code')
                                    ->label('Codice ISEE')
                                    ->maxLength(255),
                                TextInput::make('isee_value')
                                    ->label('Valore ISEE')
                                    ->numeric()
                                    ->prefix('€'),
                                DatePicker::make('isee_expiry_date')
                                    ->label('Data Scadenza ISEE')
                                    ->minDate(now()),
                            ])
                            ->collapsible(),
                    ]),

                Step::make('Privacy')
                    ->icon('heroicon-o-document-text')
                    ->description('Consenso al trattamento dei dati')
                    ->schema([
                        Section::make('Informativa sulla Privacy')
                            ->description(new HtmlString('
                                <div class="prose prose-sm">
                                    <p>Ai sensi dell\'art. 13 del Regolamento UE 2016/679 (GDPR), la informiamo che:</p>
                                    <ul>
                                        <li>I dati personali da Lei forniti saranno trattati per le finalità di gestione della Sua registrazione</li>
                                        <li>Il trattamento sarà effettuato con modalità informatizzate e manuali</li>
                                        <li>Il conferimento dei dati è obbligatorio per la registrazione al servizio</li>
                                        <li>I dati non saranno comunicati ad altri soggetti, né saranno oggetto di diffusione</li>
                                    </ul>
                                </div>
                            ')),
                        Toggle::make('privacy_acceptance')
                            ->label('Ho letto e accetto l\'informativa sulla privacy')
                            ->required()
                            ->inline(false),
                    ]),
            ])
                ->submitAction(new HtmlString('
                    <button type="submit" class="filament-button filament-button-size-lg inline-flex items-center justify-center py-2 gap-2 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                        Completa Registrazione
                    </button>
                '))
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $patient = Patient::create($data);

        $this->dispatch('patient-registered', patientId: $patient->id);
    }

    public function render()
    {
        return view('patient::widgets.patient-registration-wizard');
    }
}


