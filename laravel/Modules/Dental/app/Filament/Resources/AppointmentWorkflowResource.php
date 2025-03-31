<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Pages;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Dental\Models\Dentist;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AppointmentWorkflowResource extends XotBaseResource
{
    protected static ?string $model = AppointmentWorkflow::class;
    protected static ?string $label = 'Workflow Prenotazione';
    protected static ?string $pluralLabel = 'Workflow Prenotazioni';
    protected static ?string $slug = 'appointment-workflows';

    /**
     * Ottiene lo schema del form per la resource AppointmentWorkflow.
     *
     * @return array<string, Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'patient_id' => Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'last_name', fn (Builder $query) => $query->orderBy('last_name'))
                ->searchable(['first_name', 'last_name', 'fiscal_code', 'email'])
                ->preload()
                ->required()
                ->label('Paziente'),
                
            'status' => Forms\Components\Select::make('status')
                ->options([
                    AppointmentWorkflow::STATUS_DRAFT => 'Bozza',
                    AppointmentWorkflow::STATUS_PATIENT_INFO => 'Informazioni Paziente Completate',
                    AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'Dentista Selezionato',
                    AppointmentWorkflow::STATUS_DATE_SELECTED => 'Data Selezionata',
                    AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'Trattamento Definito',
                    AppointmentWorkflow::STATUS_CONFIRMED => 'Confermato',
                    AppointmentWorkflow::STATUS_CANCELLED => 'Cancellato',
                ])
                ->required()
                ->label('Stato'),
                
            'current_step' => Forms\Components\Select::make('current_step')
                ->options(AppointmentWorkflow::getSteps())
                ->required()
                ->label('Passo Corrente'),
                
            'started_at' => Forms\Components\DateTimePicker::make('started_at')
                ->label('Data Inizio'),
                
            'completed_at' => Forms\Components\DateTimePicker::make('completed_at')
                ->label('Data Completamento'),
                
            'last_interaction_at' => Forms\Components\DateTimePicker::make('last_interaction_at')
                ->label('Ultima Interazione'),
                
            'step_data' => Forms\Components\KeyValue::make('step_data')
                ->keyLabel('Chiave')
                ->valueLabel('Valore')
                ->columnSpanFull()
                ->label('Dati Workflow'),
        ];
    }

    /**
     * Ottiene le colonne della tabella per la resource AppointmentWorkflow.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public static function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable(),
                
            'patient.full_name' => Tables\Columns\TextColumn::make('patient.full_name')
                ->label('Paziente')
                ->searchable(['patients.first_name', 'patients.last_name'])
                ->sortable(),
                
            'status' => Tables\Columns\BadgeColumn::make('status')
                ->label('Stato')
                ->colors([
                    'primary' => AppointmentWorkflow::STATUS_DRAFT,
                    'secondary' => AppointmentWorkflow::STATUS_PATIENT_INFO,
                    'warning' => AppointmentWorkflow::STATUS_DENTIST_SELECTED,
                    'warning' => AppointmentWorkflow::STATUS_DATE_SELECTED,
                    'warning' => AppointmentWorkflow::STATUS_TREATMENT_DEFINED,
                    'success' => AppointmentWorkflow::STATUS_CONFIRMED,
                    'danger' => AppointmentWorkflow::STATUS_CANCELLED,
                ])
                ->formatStateUsing(fn (string $state): string => match($state) {
                    AppointmentWorkflow::STATUS_DRAFT => 'Bozza',
                    AppointmentWorkflow::STATUS_PATIENT_INFO => 'Info Paziente',
                    AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'Dentista Selezionato',
                    AppointmentWorkflow::STATUS_DATE_SELECTED => 'Data Selezionata',
                    AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'Trattamento Definito',
                    AppointmentWorkflow::STATUS_CONFIRMED => 'Confermato',
                    AppointmentWorkflow::STATUS_CANCELLED => 'Cancellato',
                    default => $state,
                }),
                
            'current_step' => Tables\Columns\TextColumn::make('current_step')
                ->label('Passo Corrente')
                ->formatStateUsing(fn (string $state): string => AppointmentWorkflow::getSteps()[$state] ?? $state),
                
            'started_at' => Tables\Columns\TextColumn::make('started_at')
                ->dateTime()
                ->label('Data Inizio')
                ->sortable(),
                
            'last_interaction_at' => Tables\Columns\TextColumn::make('last_interaction_at')
                ->dateTime()
                ->label('Ultima Interazione')
                ->sortable(),
                
            'completed_at' => Tables\Columns\TextColumn::make('completed_at')
                ->dateTime()
                ->label('Data Completamento')
                ->sortable(),
        ];
    }

    /**
     * Ottiene le azioni per la tabella AppointmentWorkflow.
     *
     * @return array<string, Tables\Actions\Action>
     */
    public static function getTableActions(): array
    {
        return [
            'continue' => Tables\Actions\Action::make('continue')
                ->label('Continua Workflow')
                ->icon('heroicon-o-play')
                ->color('primary')
                ->url(fn (AppointmentWorkflow $record): string => static::getUrl('workflow', ['record' => $record->id]))
                ->visible(fn (AppointmentWorkflow $record): bool => !$record->isCompleted() && !$record->isCancelled()),
                
            'cancel' => Tables\Actions\Action::make('cancel')
                ->label('Cancella Workflow')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (AppointmentWorkflow $record): void {
                    $record->status = AppointmentWorkflow::STATUS_CANCELLED;
                    $record->save();
                    
                    activity()
                        ->performedOn($record)
                        ->log('Workflow prenotazione cancellato');
                })
                ->visible(fn (AppointmentWorkflow $record): bool => !$record->isCompleted() && !$record->isCancelled()),
                
            'view' => Tables\Actions\ViewAction::make(),
        ];
    }

    /**
     * Ottiene i filtri per la tabella AppointmentWorkflow.
     *
     * @return array<int, Tables\Filters\Filter>
     */
    public static function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    AppointmentWorkflow::STATUS_DRAFT => 'Bozza',
                    AppointmentWorkflow::STATUS_PATIENT_INFO => 'Informazioni Paziente Completate',
                    AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'Dentista Selezionato',
                    AppointmentWorkflow::STATUS_DATE_SELECTED => 'Data Selezionata',
                    AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'Trattamento Definito',
                    AppointmentWorkflow::STATUS_CONFIRMED => 'Confermato',
                    AppointmentWorkflow::STATUS_CANCELLED => 'Cancellato',
                ])
                ->label('Stato'),
                
            Tables\Filters\Filter::make('date_range')
                ->form([
                    Forms\Components\DatePicker::make('started_from')
                        ->label('Iniziato dal'),
                    Forms\Components\DatePicker::make('started_until')
                        ->label('Iniziato fino al'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['started_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('started_at', '>=', $date),
                        )
                        ->when(
                            $data['started_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('started_at', '<=', $date),
                        );
                }),
        ];
    }
}
