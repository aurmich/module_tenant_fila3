<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Forms;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Modules\Dental\Actions\CheckPatientEligibilityAction;
use Modules\Dental\Actions\SendAppointmentNotificationAction;
use Modules\Dental\Filament\Components\AppointmentWorkflowProgress;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\PatientIsee;

/**
 * Classe che gestisce il form per la verifica dell'idoneità al programma SaluteOra.
 * Una paziente è idonea se:
 * - È in stato di gravidanza
 * - Ha un ISEE inferiore a 20.000€
 */
class EligibilityCheckForm
{
    /**
     * Valore massimo ISEE per essere idonei.
     */
    public const MAX_ISEE_VALUE = 20000;
    
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
        $patientId = $workflow->patient_id;
        $patient = $patientId ? Patient::find($patientId) : null;
        
        if (!$patient) {
            return [
                AppointmentWorkflowProgress::make($workflow, $currentStepIndex, $steps),
                Forms\Components\Section::make('Errore')
                    ->schema([
                        Forms\Components\Placeholder::make('error')
                            ->label('Paziente non trovata')
                            ->content('Impossibile procedere con la verifica idoneità: nessuna paziente selezionata.')
                            ->columnSpan(2),
                    ]),
            ];
        }
        
        // Recupera l'ultimo ISEE registrato per la paziente
        $latestIsee = PatientIsee::where('patient_id', $patientId)
            ->where('valid_until', '>=', now())
            ->orderByDesc('created_at')
            ->first();
            
        $hasValidIsee = (bool) $latestIsee;
        $isVerified = $workflow->step_data['eligibility_check']['is_verified'] ?? false;
        $isEligible = $workflow->step_data['eligibility_check']['is_eligible'] ?? false;
        
        $components = [
            AppointmentWorkflowProgress::make($workflow, $currentStepIndex, $steps),
            
            Forms\Components\Section::make('Informazioni Paziente')
                ->schema([
                    Forms\Components\TextEntry::make('patient_name')
                        ->label('Nome completo')
                        ->state($patient->full_name),
                        
                    Forms\Components\TextEntry::make('patient_email')
                        ->label('Email')
                        ->state($patient->user?->email ?? 'N/D'),
                        
                    Forms\Components\TextEntry::make('patient_birth_date')
                        ->label('Data di nascita')
                        ->state($patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'N/D'),
                        
                    Forms\Components\TextEntry::make('patient_pregnancy_status')
                        ->label('Stato di gravidanza')
                        ->state(fn () => $patient->pregnancy_status ? 'Sì' : 'No')
                        ->badge()
                        ->color(fn (string $state): string => $state === 'Sì' ? 'success' : 'danger'),
                ])
                ->columns(2),
        ];
        
        // Se la verifica è già stata completata, mostriamo i risultati
        if ($isVerified) {
            $components[] = Forms\Components\Section::make('Risultato Verifica Idoneità')
                ->schema([
                    Forms\Components\Placeholder::make('eligibility_result')
                        ->label('Stato Idoneità')
                        ->content(fn () => $isEligible ? 'Idonea' : 'Non Idonea')
                        ->extraAttributes(['class' => $isEligible ? 'text-success-600 font-bold' : 'text-danger-600 font-bold']),
                        
                    Forms\Components\TextEntry::make('isee_value')
                        ->label('Valore ISEE')
                        ->state(fn () => $workflow->step_data['eligibility_check']['isee_value'] ?? 'N/D')
                        ->money('EUR'),
                        
                    Forms\Components\TextEntry::make('isee_validity')
                        ->label('Validità ISEE')
                        ->state(fn () => $workflow->step_data['eligibility_check']['isee_expiry_date'] ?? 'N/D'),
                        
                    Forms\Components\TextEntry::make('verification_date')
                        ->label('Data Verifica')
                        ->state(fn () => $workflow->step_data['eligibility_check']['verification_date'] ?? now()->format('d/m/Y')),
                        
                    Forms\Components\TextEntry::make('verification_reason')
                        ->label('Note')
                        ->state(fn () => $workflow->step_data['eligibility_check']['reason'] ?? ($isEligible ? 'Tutte le condizioni soddisfatte' : 'Requisiti non soddisfatti'))
                        ->columnSpan(2),
                        
                    Forms\Components\Hidden::make('is_verified')
                        ->default(true),
                        
                    Forms\Components\Hidden::make('is_eligible')
                        ->default($isEligible),
                ])
                ->columns(2);
        } else {
            // Form per la verifica dell'idoneità
            $components[] = Forms\Components\Section::make('Verifica Idoneità')
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\TextInput::make('isee_value')
                                ->label('Valore ISEE')
                                ->numeric()
                                ->required()
                                ->default($latestIsee?->value)
                                ->placeholder('Inserire valore ISEE')
                                ->helperText('Per essere idonea al programma, il valore ISEE deve essere inferiore a ' . number_format(self::MAX_ISEE_VALUE, 2, ',', '.') . '€')
                                ->extraAttributes(['max' => 100000])
                                ->columnSpan(1),
                                
                            Forms\Components\DatePicker::make('isee_expiry_date')
                                ->label('Scadenza ISEE')
                                ->required()
                                ->default($latestIsee?->valid_until)
                                ->minDate(now())
                                ->helperText('Data di scadenza della dichiarazione ISEE')
                                ->columnSpan(1),
                                
                            Forms\Components\Checkbox::make('confirm_pregnancy')
                                ->label('Conferma stato di gravidanza')
                                ->default($patient->pregnancy_status)
                                ->required()
                                ->helperText('Conferma che la paziente è attualmente in stato di gravidanza (requisito essenziale per l\'idoneità)')
                                ->columnSpan(2),
                                
                            Forms\Components\Checkbox::make('consent_to_verify')
                                ->label('Consenso alla verifica')
                                ->required()
                                ->helperText('La paziente acconsente alla verifica dei dati ISEE e alla memorizzazione delle informazioni nel sistema')
                                ->columnSpan(2),
                                
                            Forms\Components\Hidden::make('is_verified')
                                ->default(false),
                                
                            Forms\Components\Hidden::make('is_eligible')
                                ->default(false),
                        ])
                        ->columns(2),
                            
                    Forms\Components\Actions::make([
                        Forms\Components\Actions\Action::make('verify_eligibility')
                            ->label('Verifica Idoneità')
                            ->icon('heroicon-m-check-circle')
                            ->color('primary')
                            ->action(function (Forms\Set $set, Forms\Get $get, ?Forms\Components\Actions\Action $component): void {
                                try {
                                    // Ottiene i dati dal form
                                    $iseeValue = (float) $get('isee_value');
                                    $iseeExpiryDate = $get('isee_expiry_date');
                                    $confirmPregnancy = (bool) $get('confirm_pregnancy');
                                    $consentToVerify = (bool) $get('consent_to_verify');
                                    
                                    if (!$iseeValue || !$iseeExpiryDate || !$confirmPregnancy || !$consentToVerify) {
                                        Notification::make()
                                            ->title('Dati mancanti')
                                            ->body('Tutti i campi sono obbligatori per completare la verifica')
                                            ->danger()
                                            ->send();
                                        return;
                                    }
                                    
                                    // Ottiene il paziente
                                    $patient = Patient::find($workflow->patient_id);
                                    if (!$patient) {
                                        Notification::make()
                                            ->title('Paziente non trovata')
                                            ->body('Impossibile completare la verifica: paziente non trovata')
                                            ->danger()
                                            ->send();
                                        return;
                                    }
                                    
                                    // Aggiorna lo stato di gravidanza
                                    $patient->pregnancy_status = $confirmPregnancy;
                                    $patient->save();
                                    
                                    // Crea o aggiorna il record ISEE
                                    PatientIsee::updateOrCreate(
                                        ['patient_id' => $patient->id],
                                        [
                                            'value' => $iseeValue,
                                            'valid_until' => $iseeExpiryDate,
                                            'verified' => true,
                                            'verification_date' => now(),
                                        ]
                                    );
                                    
                                    // Verifica l'idoneità
                                    $eligibilityCheck = app(CheckPatientEligibilityAction::class)
                                        ->execute($patient);
                                        
                                    $isEligible = $eligibilityCheck['eligible'] ?? false;
                                    $reason = $eligibilityCheck['reason'] ?? ($isEligible 
                                        ? 'Tutte le condizioni soddisfatte' 
                                        : 'Requisiti non soddisfatti');
                                        
                                    // Aggiorna i campi nascosti
                                    $set('is_verified', true);
                                    $set('is_eligible', $isEligible);
                                    $set('reason', $reason);
                                    $set('verification_date', now()->format('d/m/Y'));
                                    
                                    // Invia notifica
                                    app(SendAppointmentNotificationAction::class)->execute(
                                        'eligibility_check',
                                        $workflow,
                                        [
                                            'eligible' => $isEligible,
                                            'reason' => $reason,
                                            'isee_value' => $iseeValue,
                                        ]
                                    );
                                    
                                    // Mostra notifica all'utente
                                    $notificationTitle = $isEligible 
                                        ? 'Paziente idonea al programma' 
                                        : 'Paziente non idonea al programma';
                                        
                                    $notification = Notification::make()
                                        ->title($notificationTitle)
                                        ->body($reason);
                                        
                                    if ($isEligible) {
                                        $notification->success();
                                    } else {
                                        $notification->warning();
                                    }
                                    
                                    $notification->send();
                                    
                                    $component?->livewire?->dispatch('refresh');
                                } catch (\Exception $e) {
                                    Log::error('Errore durante la verifica idoneità', [
                                        'error' => $e->getMessage(),
                                        'workflow_id' => $workflow->id,
                                        'patient_id' => $workflow->patient_id,
                                    ]);
                                    
                                    Notification::make()
                                        ->title('Errore verifica')
                                        ->body('Si è verificato un errore durante la verifica: ' . $e->getMessage())
                                        ->danger()
                                        ->send();
                                }
                            })
                            ->requiresConfirmation()
                            ->modalHeading('Conferma verifica idoneità')
                            ->modalDescription('Questa operazione verificherà l\'idoneità della paziente al programma SaluteOra. Confermi di procedere?')
                            ->modalSubmitActionLabel('Conferma')
                            ->visible(fn (Forms\Get $get): bool => $get('consent_to_verify') && !$get('is_verified')),
                    ]),
                ]);
        }
        
        return $components;
    }
}
