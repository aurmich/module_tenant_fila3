<?php

declare(strict_types=1);

namespace Modules\Reporting\Services;

use Modules\Reporting\Models\Report;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Servizio per l'esportazione dei report in vari formati.
 */
class ReportExporter
{
    /**
     * Esporta un report in formato PDF.
     *
     * @param Report $report
     * @return string Path del file PDF generato
     */
    public function exportToPdf(Report $report): string
    {
        $reportData = $report->reportData()->orderBy('group')->orderBy('order')->get();
        $groupedData = $reportData->groupBy('group');
        
        // Genera HTML per il PDF
        $html = view('reporting::exports.pdf', [
            'report' => $report,
            'groupedData' => $groupedData,
        ])->render();
        
        // Nome del file temporaneo
        $filename = 'report_' . $report->id . '_' . Str::slug($report->name) . '_' . Carbon::now()->format('YmdHis') . '.pdf';
        $tempPath = storage_path('app/temp/' . $filename);
        
        // Crea directory se non esiste
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }
        
        // Genera PDF usando Dompdf
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Salva il file
        file_put_contents($tempPath, $dompdf->output());
        
        return $tempPath;
    }
    
    /**
     * Esporta un report in formato CSV.
     *
     * @param Report $report
     * @return string Path del file CSV generato
     */
    public function exportToCsv(Report $report): string
    {
        $reportData = $report->reportData()->orderBy('group')->orderBy('order')->get();
        
        // Nome del file temporaneo
        $filename = 'report_' . $report->id . '_' . Str::slug($report->name) . '_' . Carbon::now()->format('YmdHis') . '.csv';
        $tempPath = storage_path('app/temp/' . $filename);
        
        // Crea directory se non esiste
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }
        
        // Apri file
        $file = fopen($tempPath, 'w');
        
        // Intestazioni
        fputcsv($file, ['Gruppo', 'Descrizione', 'Chiave', 'Valore', 'Tipo Dato']);
        
        // Dati
        foreach ($reportData as $data) {
            fputcsv($file, [
                $data->group,
                $data->description,
                $data->key,
                is_string($data->value) ? $data->value : json_encode($data->value),
                $data->data_type,
            ]);
        }
        
        fclose($file);
        
        return $tempPath;
    }
}
