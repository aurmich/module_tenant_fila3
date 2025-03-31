<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextEntry;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Dental\Models\Dentist;
use Modules\Patient\Models\Patient;

class AppointmentWorkflowSummary extends Component
{
    /**
     * Crea un nuovo componente per il riepilogo del workflow di appuntamento.
     *
     * @param AppointmentWorkflow $workflow Il workflow di appuntamento
     */
    public static function make(AppointmentWorkflow $workflow): Grid
    {
        // Recupera i dati necessari
        $patient = $workflow->patient;
        
        // Recupera il dentista dal workflow
        $stepData = $workflow->step_data ?? [];
        $dentistId = $stepData['dentist_selection']['dentist_id'] ?? null;
        $dentist = $dentistId ? Dentist::find($dentistId) : null;
        
        // Dati di data e ora
        $dateData = $stepData['date_selection'] ?? [];
        
        // Dati del trattamento
        $treatmentData = $stepData['treatment_definition'] ?? [];
        
        return Grid::make()
            ->schema([
                Section::make('Paziente')
                    ->schema([
                        TextEntry::make('patient_name')
                            ->label('Nome')
                            ->state($patient ? $patient->full_name : 'N/A'),
                            
                        TextEntry::make('patient_email')
                            ->label('Email')
                            ->state($patient?->user?->email ?? 'N/A'),
                            
                        TextEntry::make('patient_phone')
                            ->label('Telefono')
                            ->state($patient?->phone ?? 'N/A'),
                    ])
                    ->hidden(fn () => !$patient)
                    ->columns(1),
                    
                Section::make('Dentista')
                    ->schema([
                        TextEntry::make('dentist_name')
                            ->label('Nome')
                            ->state($dentist ? "{$dentist->title} {$dentist->first_name} {$dentist->last_name}" : 'N/A'),
                            
                        TextEntry::make('dentist_specialization')
                            ->label('Specializzazione')
                            ->state($dentist?->specialization ?? 'N/A'),
                    ])
                    ->hidden(fn () => !$dentist)
                    ->columns(1),
                    
                Section::make('Data e Ora')
                    ->schema([
                        TextEntry::make('date')
                            ->label('Data')
                            ->state(isset($dateData['date']) ? \Carbon\Carbon::parse($dateData['date'])->format('d/m/Y') : 'N/A'),
                            
                        TextEntry::make('time')
                            ->label('Orario')
                            ->state(
                                (isset($dateData['start_time']) ? \Carbon\Carbon::parse($dateData['start_time'])->format('H:i') : 'N/A') . 
                                ' - ' . 
                                (isset($dateData['end_time']) ? \Carbon\Carbon::parse($dateData['end_time'])->format('H:i') : 'N/A')
                            ),
                    ])
                    ->columns(1),
                    
                Section::make('Trattamento')
                    ->schema([
                        TextEntry::make('type')
                            ->label('Tipo')
                            ->state(isset($treatmentData['type']) ? match($treatmentData['type']) {
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
                                default => $treatmentData['type'],
                            } : 'N/A'),
                            
                        TextEntry::make('is_emergency')
                            ->label('Emergenza')
                            ->state(isset($treatmentData['is_emergency']) && $treatmentData['is_emergency'] ? 'Sì' : 'No'),
                            
                        TextEntry::make('notes')
                            ->label('Note')
                            ->state($treatmentData['notes'] ?? 'Nessuna nota'),
                    ])
                    ->columns(1),
            ])
            ->columns(2);
    }
}
