<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Forms;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Modules\Dental\Filament\Components\AppointmentWorkflowProgress;
use Modules\Dental\Filament\Components\AppointmentWorkflowSummary;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Dental\Models\Dentist;
use Modules\Patient\Models\Patient;
use Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Forms\EligibilityCheckForm;

/**
 * Classe che gestisce i form per i vari passi del workflow di appuntamento.
 */
class WorkflowForms
{
    /**
     * Ottiene lo schema per il passo di informazioni paziente.
     *
     * @param AppointmentWorkflow $workflow
     * @param int $currentStepIndex
     * @param array<string, string> $steps
     * 
     * @return array<Component>
     */
    public static function getPatientInfoStepSchema(
        AppointmentWorkflow $workflow,
        int $currentStepIndex,
        array $steps
    ): array {
        $patientId = $workflow->patient_id;
        $patient = $patientId ? Patient::find($patientId) : null;
        
        $components = [
            AppointmentWorkflowProgress::make($workflow, $currentStepIndex, $steps),
        ];
        
        if ($patient) {
            // Se il paziente è già associato, mostriamo solo le informazioni
            $components[] = Forms\Components\Section::make('Informazioni Paziente')
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\TextEntry::make('patient_name')
                                ->label('Nome completo')
                                ->state($patient->full_name),
                                
                            Forms\Components\TextEntry::make('patient_email')
                                ->label('Email')
                                ->state($patient->user?->email ?? 'N/A'),
                                
                            Forms\Components\TextEntry::make('patient_fiscal_code')
                                ->label('Codice Fiscale')
                                ->state($patient->fiscal_code),
                                
                            Forms\Components\TextEntry::make('patient_birth_date')
                                ->label('Data di nascita')
                                ->state($patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'N/A'),
                        ])
                        ->columns(2),
                ]);
                
            $components[] = Forms\Components\Hidden::make('patient_id')
                ->default($patientId);
        } else {
            // Altrimenti, mostriamo un selettore di pazienti
            $components[] = Forms\Components\Section::make('Seleziona Paziente')
                ->schema([
                    Forms\Components\Select::make('patient_id')
                        ->label('Paziente')
                        ->relationship('patient', 'last_name', fn (Builder $query) => $query->orderBy('last_name'))
                        ->searchable(['first_name', 'last_name', 'fiscal_code', 'email'])
                        ->preload()
                        ->required()
                        ->helperText('Seleziona il paziente per cui creare l\'appuntamento'),
                ]);
        }
        
        return $components;
    }
    
    /**
     * Ottiene lo schema per il passo di selezione dentista.
     *
     * @param AppointmentWorkflow $workflow
     * @param int $currentStepIndex
     * @param array<string, string> $steps
     * 
     * @return array<Component>
     */
    /**
     * Ottiene lo schema per il passo di verifica idoneità.
     *
     * @param AppointmentWorkflow $workflow
     * @param int $currentStepIndex
     * @param array<string, string> $steps
     * 
     * @return array<Component>
     */
    public static function getEligibilityCheckStepSchema(
        AppointmentWorkflow $workflow,
        int $currentStepIndex,
        array $steps
    ): array {
        return EligibilityCheckForm::getEligibilityCheckStepSchema($workflow, $currentStepIndex, $steps);
    }
    
    /**
     * Ottiene lo schema per il passo di selezione dentista.
     *
     * @param AppointmentWorkflow $workflow
     * @param int $currentStepIndex
     * @param array<string, string> $steps
     * 
     * @return array<Component>
     */
    public static function getDentistSelectionStepSchema(
        AppointmentWorkflow $workflow,
        int $currentStepIndex,
        array $steps
    ): array {
        return [
            AppointmentWorkflowProgress::make($workflow, $currentStepIndex, $steps),
            
            Forms\Components\Section::make('Seleziona Dentista')
                ->schema([
                    Forms\Components\Radio::make('dentist_id')
                        ->label('Seleziona il dentista per l\'appuntamento')
                        ->options(function () {
                            return Dentist::where('tenant_id', tenant()->id)
                                ->where('is_active', true)
                                ->get()
                                ->mapWithKeys(function ($dentist) {
                                    return [$dentist->id => "{$dentist->title} {$dentist->first_name} {$dentist->last_name} - {$dentist->specialization}"];
                                })
                                ->toArray();
                        })
                        ->required()
                        ->columns(1),
                ])
                ->columnSpanFull(),
                
            Forms\Components\Section::make('Note')
                ->schema([
                    Forms\Components\Textarea::make('dentist_preference_notes')
                        ->label('Note sulla preferenza del dentista')
                        ->rows(3)
                        ->maxLength(1000)
                        ->helperText('Inserisci eventuali note sulla preferenza del dentista (opzionale)'),
                ]),
        ];
    }
    
    /**
     * Ottiene lo schema per il passo di selezione data e ora.
     *
     * @param AppointmentWorkflow $workflow
     * @param int $currentStepIndex
     * @param array<string, string> $steps
     * 
     * @return array<Component>
     */
    public static function getDateSelectionStepSchema(
        AppointmentWorkflow $workflow,
        int $currentStepIndex,
        array $steps
    ): array {
        return [
            AppointmentWorkflowProgress::make($workflow, $currentStepIndex, $steps),
            
            Forms\Components\Section::make('Seleziona Data e Ora')
                ->schema([
                    Forms\Components\DatePicker::make('date')
                        ->label('Data dell\'appuntamento')
                        ->required()
                        ->minDate(now())
                        ->displayFormat('d/m/Y')
                        ->closeOnDateSelection(),
                        
                    Forms\Components\TimePicker::make('start_time')
                        ->label('Ora di inizio')
                        ->required()
                        ->seconds(false)
                        ->minutesStep(15),
                        
                    Forms\Components\TimePicker::make('end_time')
                        ->label('Ora di fine')
                        ->required()
                        ->seconds(false)
                        ->minutesStep(15)
                        ->after('start_time'),
                ]),
                
            Forms\Components\Section::make('Preferenze')
                ->schema([
                    Forms\Components\Checkbox::make('flexible_time')
                        ->label('Sono flessibile con data e ora')
                        ->helperText('Seleziona questa opzione se sei disponibile in orari diversi da quelli indicati'),
                    
                    Forms\Components\Textarea::make('date_notes')
                        ->label('Note sulla disponibilità')
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Inserisci eventuali note sulla tua disponibilità (opzionale)'),
                ]),
        ];
    }
    
    /**
     * Ottiene lo schema per il passo di definizione trattamento.
     *
     * @param AppointmentWorkflow $workflow
     * @param int $currentStepIndex
     * @param array<string, string> $steps
     * 
     * @return array<Component>
     */
    public static function getTreatmentDefinitionStepSchema(
        AppointmentWorkflow $workflow,
        int $currentStepIndex,
        array $steps
    ): array {
        return [
            AppointmentWorkflowProgress::make($workflow, $currentStepIndex, $steps),
            
            Forms\Components\Section::make('Tipo di Trattamento')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->label('Tipo di appuntamento')
                        ->options([
                            'check-up' => 'Check-up generale',
                            'cleaning' => 'Pulizia dei denti',
                            'extraction' => 'Estrazione',
                            'filling' => 'Otturazione',
                            'root-canal' => 'Trattamento canalare',
                            'whitening' => 'Sbiancamento',
                            'implant' => 'Impianto dentale',
                            'braces' => 'Apparecchio ortodontico',
                            'crown' => 'Corona dentale',
                            'consultation' => 'Consulenza',
                            'emergency' => 'Emergenza',
                            'other' => 'Altro',
                        ])
                        ->required(),
                        
                    Forms\Components\Checkbox::make('is_emergency')
                        ->label('È un\'emergenza')
                        ->helperText('Seleziona questa opzione se si tratta di un\'emergenza'),
                ]),
                
            Forms\Components\Section::make('Dettagli Trattamento')
                ->schema([
                    Forms\Components\Textarea::make('treatment_plan')
                        ->label('Piano di trattamento')
                        ->helperText('Descrivi brevemente il piano di trattamento, se già noto')
                        ->rows(3),
                        
                    Forms\Components\Textarea::make('notes')
                        ->label('Note aggiuntive')
                        ->helperText('Inserisci eventuali note aggiuntive per il dentista')
                        ->rows(3)
                        ->maxLength(1000),
                ]),
        ];
    }
    
    /**
     * Ottiene lo schema per il passo di conferma.
     *
     * @param AppointmentWorkflow $workflow
     * @param int $currentStepIndex
     * @param array<string, string> $steps
     * 
     * @return array<Component>
     */
    public static function getConfirmationStepSchema(
        AppointmentWorkflow $workflow,
        int $currentStepIndex,
        array $steps
    ): array {
        return [
            AppointmentWorkflowProgress::make($workflow, $currentStepIndex, $steps),
            
            Forms\Components\Section::make('Riepilogo Appuntamento')
                ->schema([
                    AppointmentWorkflowSummary::make($workflow),
                ]),
                
            Forms\Components\Section::make('Conferma')
                ->schema([
                    Forms\Components\Checkbox::make('confirmed')
                        ->label('Confermo che le informazioni sopra riportate sono corrette')
                        ->required()
                        ->helperText('Seleziona questa opzione per confermare l\'appuntamento'),
                        
                    Forms\Components\Textarea::make('final_notes')
                        ->label('Note finali')
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Inserisci eventuali note finali (opzionale)'),
                ]),
        ];
    }
}
