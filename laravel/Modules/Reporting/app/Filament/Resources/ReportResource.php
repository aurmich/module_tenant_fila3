<?php

declare(strict_types=1);

namespace Modules\Reporting\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Reporting\Filament\Resources\ReportResource\Pages;
use Modules\Reporting\Models\Report;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ReportResource extends XotBaseResource
{
    protected static ?string $model = Report::class;

    /**
     * Ottiene lo schema del form per la risorsa Report.
     *
     * @return array<string, Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Nome Report'),
                
            'description' => Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull()
                ->label('Descrizione'),
                
            'type' => Forms\Components\Select::make('type')
                ->options([
                    'paziente_demografico' => 'Analisi Demografica Pazienti',
                    'visite_per_periodo' => 'Statistiche Visite per Periodo',
                    'attivita_odontoiatri' => 'Analisi Attività Odontoiatri',
                    'isee_analisi' => 'Analisi ISEE Pazienti',
                ])
                ->required()
                ->label('Tipo Report'),
                
            'period_start' => Forms\Components\DateTimePicker::make('period_start')
                ->label('Data Inizio')
                ->required(),
                
            'period_end' => Forms\Components\DateTimePicker::make('period_end')
                ->label('Data Fine')
                ->required()
                ->afterOrEqual('period_start'),
                
            'parameters' => Forms\Components\KeyValue::make('parameters')
                ->label('Parametri Aggiuntivi')
                ->keyLabel('Parametro')
                ->valueLabel('Valore')
                ->columnSpanFull(),
        ];
    }

    /**
     * Ottiene le colonne della tabella per la risorsa Report.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public static function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable(),
                
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label('Nome Report'),
                
            'type' => Tables\Columns\TextColumn::make('type')
                ->searchable()
                ->sortable()
                ->label('Tipo Report')
                ->formatStateUsing(fn (string $state): string => match($state) {
                    'paziente_demografico' => 'Analisi Demografica Pazienti',
                    'visite_per_periodo' => 'Statistiche Visite per Periodo',
                    'attivita_odontoiatri' => 'Analisi Attività Odontoiatri',
                    'isee_analisi' => 'Analisi ISEE Pazienti',
                    default => $state,
                }),
                
            'period_start' => Tables\Columns\TextColumn::make('period_start')
                ->dateTime()
                ->sortable()
                ->label('Data Inizio'),
                
            'period_end' => Tables\Columns\TextColumn::make('period_end')
                ->dateTime()
                ->sortable()
                ->label('Data Fine'),
                
            'status' => Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'danger' => 'error',
                    'warning' => 'processing',
                    'success' => 'completed',
                ])
                ->sortable()
                ->label('Stato')
                ->formatStateUsing(fn (string $state): string => match($state) {
                    'pending' => 'In attesa',
                    'processing' => 'In elaborazione',
                    'completed' => 'Completato',
                    'error' => 'Errore',
                    default => $state,
                }),
                
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->label('Data Creazione'),
                
            'creator.name' => Tables\Columns\TextColumn::make('creator.name')
                ->searchable()
                ->sortable()
                ->label('Creato da'),
        ];
    }

    /**
     * Definisce le azioni per la tabella delle risorse.
     *
     * @return array<Tables\Actions\Action>
     */
    public static function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('view_details')
                ->label('Visualizza Dettagli')
                ->icon('heroicon-o-eye')
                ->url(fn (Report $record): string => static::getUrl('view', ['record' => $record])),
                
            Tables\Actions\Action::make('regenerate')
                ->label('Rigenera Report')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function (Report $record) {
                    // Logica per rigenerare il report
                    $record->update(['status' => 'pending']);
                    
                    // Esecuzione asincrona dell'azione con Spatie QueueableAction
                    $parameters = $record->parameters ?? [];
                    $parameters['name'] = $record->name;
                    $parameters['description'] = $record->description;
                    $parameters['period_start'] = $record->period_start;
                    $parameters['period_end'] = $record->period_end;
                    
                    app(\Modules\Reporting\Actions\GenerateReportAction::class)
                        ->onQueue('reports')
                        ->execute($record, $parameters);
                }),
        ];
    }
    
    /**
     * Configura l'elenco dei filtri disponibili per la tabella.
     *
     * @return array<Tables\Filters\Filter>
     */
    public static function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('type')
                ->options([
                    'paziente_demografico' => 'Analisi Demografica Pazienti',
                    'visite_per_periodo' => 'Statistiche Visite per Periodo',
                    'attivita_odontoiatri' => 'Analisi Attività Odontoiatri',
                    'isee_analisi' => 'Analisi ISEE Pazienti',
                ])
                ->label('Tipo Report'),
                
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'In attesa',
                    'processing' => 'In elaborazione',
                    'completed' => 'Completato',
                    'error' => 'Errore',
                ])
                ->label('Stato'),
                
            Tables\Filters\Filter::make('period')
                ->form([
                    Forms\Components\DatePicker::make('created_from')
                        ->label('Creato dal'),
                    Forms\Components\DatePicker::make('created_until')
                        ->label('Creato fino al'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
        ];
    }
}
