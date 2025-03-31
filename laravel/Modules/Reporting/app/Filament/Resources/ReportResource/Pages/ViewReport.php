<?php

declare(strict_types=1);

namespace Modules\Reporting\Filament\Resources\ReportResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Modules\Reporting\Filament\Resources\ReportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Modules\Reporting\Models\Report;
use Modules\Reporting\Models\ReportData;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Collection;

class ViewReport extends XotBaseViewRecord
{
    protected static string $resource = ReportResource::class;

    /**
     * Configura l'infolist per visualizzare i dettagli del report.
     *
     * @param Infolist $infolist
     * @return Infolist
     */
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informazioni Report')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nome Report'),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Descrizione')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('type')
                            ->label('Tipo Report')
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'paziente_demografico' => 'Analisi Demografica Pazienti',
                                'visite_per_periodo' => 'Statistiche Visite per Periodo',
                                'attivita_odontoiatri' => 'Analisi Attività Odontoiatri',
                                'isee_analisi' => 'Analisi ISEE Pazienti',
                                default => $state,
                            }),
                        Infolists\Components\TextEntry::make('period_start')
                            ->label('Periodo Dal')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('period_end')
                            ->label('Periodo Al')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Stato')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'pending' => 'In attesa',
                                'processing' => 'In elaborazione',
                                'completed' => 'Completato',
                                'error' => 'Errore',
                                default => $state,
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'completed' => 'success',
                                'processing' => 'warning',
                                'pending' => 'info',
                                'error' => 'danger',
                                default => 'secondary',
                            }),
                        Infolists\Components\TextEntry::make('creator.name')
                            ->label('Creato da'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Data Creazione')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('last_generated_at')
                            ->label('Ultima Generazione')
                            ->dateTime(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Parametri Report')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('parameters')
                            ->label('Parametri')
                            ->columnSpanFull()
                            ->schema([
                                Infolists\Components\TextEntry::make('key')
                                    ->label('Parametro'),
                                Infolists\Components\TextEntry::make('value')
                                    ->label('Valore'),
                            ]),
                    ])
                    ->collapsible(),

                // Sezione dinamica per i dati del report
                Infolists\Components\Section::make('Dati Report')
                    ->schema([
                        Infolists\Components\TextEntry::make('report_data')
                            ->label('')
                            ->columnSpanFull()
                            ->html()
                            ->state(function (Report $record): HtmlString {
                                // Raggruppa i dati del report per gruppo
                                $groupedData = $record->reportData()
                                    ->orderBy('group')
                                    ->orderBy('order')
                                    ->get()
                                    ->groupBy('group');

                                $html = '';

                                // Genera l'HTML per ogni gruppo di dati
                                foreach ($groupedData as $group => $data) {
                                    $groupTitle = ucfirst(str_replace('_', ' ', $group));
                                    $html .= "<h3 class='text-lg font-medium text-gray-900 mt-4'>{$groupTitle}</h3>";
                                    $html .= "<div class='grid grid-cols-1 md:grid-cols-2 gap-4 mt-2'>";

                                    foreach ($data as $item) {
                                        $html .= $this->renderReportDataItem($item);
                                    }

                                    $html .= "</div>";
                                }

                                return new HtmlString($html);
                            }),
                    ]),
            ]);
    }

    /**
     * Genera l'HTML per un elemento di dati del report.
     *
     * @param ReportData $item
     * @return string
     */
    protected function renderReportDataItem(ReportData $item): string
    {
        $title = $item->description;
        $value = $item->value;
        $dataType = $item->data_type;

        // Formatta l'output in base al tipo di dato
        $html = "<div class='bg-white p-4 rounded shadow-sm'>";
        $html .= "<h4 class='text-sm font-medium text-gray-600'>{$title}</h4>";

        if ($dataType === 'json' || $dataType === 'array') {
            // Converte i dati JSON in array
            $jsonData = json_decode($value, true);

            if (count($jsonData) <= 5) {
                // Per insiemi di dati piccoli, mostra una semplice lista
                $html .= "<ul class='mt-2 space-y-1'>";
                foreach ($jsonData as $key => $val) {
                    $html .= "<li class='text-sm'><span class='font-medium'>{$key}:</span> {$val}</li>";
                }
                $html .= "</ul>";
            } else {
                // Per set di dati più grandi, mostra un grafico semplice
                $html .= "<div class='mt-2 h-40' id='chart-{$item->id}'></div>";
                $html .= "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const data = " . json_encode($jsonData) . ";
                        const labels = Object.keys(data);
                        const values = Object.values(data);
                        
                        new Chart(document.getElementById('chart-{$item->id}'), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: '{$title}',
                                    data: values,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>";
            }
        } elseif ($dataType === 'integer' || $dataType === 'float') {
            $html .= "<div class='mt-1 text-xl font-bold text-gray-900'>{$value}</div>";
        } else {
            $html .= "<div class='mt-1 text-gray-900'>{$value}</div>";
        }

        $html .= "</div>";

        return $html;
    }

    /**
     * Definisce le azioni disponibili nell'intestazione della pagina.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('regenerate')
                ->label('Rigenera Report')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function () {
                    $record = $this->getRecord();
                    $record->update(['status' => 'pending']);
                    
                    // Prepara i parametri per la rigenerazione
                    $parameters = $record->parameters ?? [];
                    $parameters['name'] = $record->name;
                    $parameters['description'] = $record->description;
                    $parameters['period_start'] = $record->period_start;
                    $parameters['period_end'] = $record->period_end;
                    
                    // Esecuzione asincrona dell'azione con Spatie QueueableAction
                    app(\Modules\Reporting\Actions\GenerateReportAction::class)
                        ->onQueue('reports')
                        ->execute($record, $parameters);
                    
                    $this->notify('success', 'Rigenerazione del report avviata in background');
                    $this->redirect(static::getResource()::getUrl('view', ['record' => $record]));
                }),
            Actions\Action::make('download_pdf')
                ->label('Scarica PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function (Report $record) {
                    $exporter = app(\Modules\Reporting\Services\ReportExporter::class);
                    $pdfPath = $exporter->exportToPdf($record);
                    
                    return response()->download(
                        $pdfPath,
                        "report_{$record->id}_{$record->type}.pdf",
                        ['Content-Type' => 'application/pdf']
                    )->deleteFileAfterSend(true);
                }),
            Actions\Action::make('export_csv')
                ->label('Esporta CSV')
                ->icon('heroicon-o-table-cells')
                ->action(function (Report $record) {
                    $exporter = app(\Modules\Reporting\Services\ReportExporter::class);
                    $csvPath = $exporter->exportToCsv($record);
                    
                    return response()->download(
                        $csvPath,
                        "report_{$record->id}_{$record->type}.csv",
                        ['Content-Type' => 'text/csv']
                    )->deleteFileAfterSend(true);
                }),
        ];
    }
}
