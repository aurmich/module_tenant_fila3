# Modulo Reporting - SaluteOra

## Introduzione
Il modulo Reporting fornisce funzionalità complete per la generazione, gestione e visualizzazione di report statistici e analitici all'interno della piattaforma SaluteOra.

## Caratteristiche Principali
- Creazione di vari tipi di report personalizzabili
- Generazione asincrona per report complessi tramite Spatie QueueableAction
- Esportazione in formato PDF e CSV
- Dashboard con statistiche e dati rilevanti
- Visualizzazione interattiva dei dati con grafici
- Interfaccia completamente basata su Filament

## Struttura del Modulo

### Models
- `Report`: Gestisce le informazioni principali del report (nome, tipo, periodo, stato)
- `ReportData`: Memorizza i dati specifici associati ai report

### Actions
- `GenerateReportAction`: Azione asincrona per la generazione di report in background

### Services
- `ReportGenerator`: Gestisce la logica di generazione dei dati per i report
- `ReportExporter`: Gestisce l'esportazione dei report in vari formati

### Filament Resources
- `ReportResource`: Resource Filament per la gestione CRUD dei report
  - `ListReports`: Pagina per visualizzare elenco dei report
  - `CreateReport`: Pagina per creare nuovi report
  - `EditReport`: Pagina per modificare report esistenti
  - `ViewReport`: Pagina per visualizzare i dettagli di un report

### Filament Widgets
- `ReportsOverviewWidget`: Widget per dashboard con panoramica dei report
- `ClinicalStatsWidget`: Widget per statistiche cliniche

## Tipi di Report Supportati
- **Analisi Demografica Pazienti**: Statistiche sulla distribuzione demografica dei pazienti
- **Statistiche Visite per Periodo**: Analisi delle visite effettuate in un determinato periodo
- **Analisi Attività Odontoiatri**: Statistiche sull'attività e produttività degli odontoiatri
- **Analisi ISEE Pazienti**: Analisi della distribuzione ISEE dei pazienti

## Utilizzo

### Generazione Report
La generazione dei report avviene in modo asincrono tramite Spatie Laravel-Queueable-Action:

```php
app(\Modules\Reporting\Actions\GenerateReportAction::class)
    ->onQueue('reports')
    ->execute($report, $parameters);
```

### Esportazione Report
I report possono essere esportati in formato PDF e CSV:

```php
$exporter = app(\Modules\Reporting\Services\ReportExporter::class);
$pdfPath = $exporter->exportToPdf($report);
$csvPath = $exporter->exportToCsv($report);
```

## Dipendenze
- Filament per l'interfaccia amministrativa
- Spatie Laravel-Queueable-Action per le operazioni asincrone
- DOMPDF per la generazione di PDF
- Chart.js per la visualizzazione di grafici

## Considerazioni Tecniche
- Il modulo utilizza esclusivamente Filament per le interfacce amministrative
- Le operazioni pesanti vengono gestite in modo asincrono
- I dati vengono memorizzati in modo strutturato per facilitare l'analisi
- La visualizzazione è ottimizzata per una facile comprensione dei dati

## Licenza
Questo modulo è parte del progetto SaluteOra e soggetto alle stesse condizioni di licenza del progetto principale.
