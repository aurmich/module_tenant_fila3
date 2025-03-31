<?php

declare(strict_types=1);

namespace Modules\Reporting\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Reporting\Models\Report;
use Illuminate\Support\Facades\DB;

class ReportsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $tenantId = tenant()->id;
        
        // Conteggio report per stato
        $reportsByStatus = Report::where('tenant_id', $tenantId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        // Ottiene il conteggio per ogni stato o zero se non esistente
        $completedCount = $reportsByStatus['completed'] ?? 0;
        $pendingCount = $reportsByStatus['pending'] ?? 0;
        $processingCount = $reportsByStatus['processing'] ?? 0;
        $errorCount = $reportsByStatus['error'] ?? 0;
        
        // Calcolo percentuale completati sul totale
        $totalReports = $completedCount + $pendingCount + $processingCount + $errorCount;
        $completionRate = $totalReports > 0 
            ? round(($completedCount / $totalReports) * 100, 1) 
            : 0;
            
        // Ottiene il report più recente
        $latestReport = Report::where('tenant_id', $tenantId)
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Conteggio report per tipo
        $reportsByType = Report::where('tenant_id', $tenantId)
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
            
        // Formatta i dati per il tipo di report
        $typeLabels = [
            'paziente_demografico' => 'Demografico Pazienti',
            'visite_per_periodo' => 'Visite per Periodo',
            'attivita_odontoiatri' => 'Attività Odontoiatri',
            'isee_analisi' => 'Analisi ISEE',
        ];
        
        $typeStats = [];
        foreach ($reportsByType as $type => $count) {
            $label = $typeLabels[$type] ?? $type;
            $typeStats[] = "{$label}: {$count}";
        }
        
        return [
            Stat::make('Report Completati', (string)$completedCount)
                ->description('Tasso di completamento: ' . $completionRate . '%')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart($this->getCompletionTrend()),
                
            Stat::make('Report in Elaborazione', (string)($pendingCount + $processingCount))
                ->description($pendingCount . ' in attesa, ' . $processingCount . ' in elaborazione')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
                
            Stat::make('Report per Tipo', implode(', ', $typeStats))
                ->description($latestReport 
                    ? 'Ultimo: ' . $latestReport->name . ' (' . $latestReport->created_at->diffForHumans() . ')'
                    : 'Nessun report creato')
                ->descriptionIcon('heroicon-m-document-chart-bar')
                ->color('gray'),
        ];
    }
    
    /**
     * Ottiene i dati del trend di completamento dei report.
     *
     * @return array<int>
     */
    protected function getCompletionTrend(): array
    {
        $tenantId = tenant()->id;
        
        // Ottiene i conteggi giornalieri degli ultimi 7 giorni
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            
            $count = Report::where('tenant_id', $tenantId)
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->count();
                
            $counts[] = $count;
        }
        
        return $counts;
    }
}
