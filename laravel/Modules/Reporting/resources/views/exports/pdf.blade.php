<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>{{ $report->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .info {
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .section {
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .section h2 {
            color: #1f2937;
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .data-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 5px;
        }
        .data-item h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 16px;
            color: #4b5563;
        }
        .data-value {
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            text-align: left;
            background-color: #f1f5f9;
            padding: 8px 10px;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $report->name }}</h1>
        <p>{{ $report->description }}</p>
    </div>
    
    <div class="info">
        <div class="info-item">
            <span class="info-label">Tipo Report:</span>
            <span>{{ match($report->type) {
                'paziente_demografico' => 'Analisi Demografica Pazienti',
                'visite_per_periodo' => 'Statistiche Visite per Periodo',
                'attivita_odontoiatri' => 'Analisi Attività Odontoiatri',
                'isee_analisi' => 'Analisi ISEE Pazienti',
                default => $report->type,
            } }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Periodo:</span>
            <span>{{ $report->period_start->format('d/m/Y') }} - {{ $report->period_end->format('d/m/Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Generato il:</span>
            <span>{{ $report->last_generated_at ? $report->last_generated_at->format('d/m/Y H:i') : $report->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    
    @foreach($groupedData as $group => $dataItems)
        <div class="section">
            <h2>{{ ucfirst(str_replace('_', ' ', $group)) }}</h2>
            
            @foreach($dataItems as $item)
                <div class="data-item">
                    <h3>{{ $item->description }}</h3>
                    
                    <div class="data-value">
                        @if($item->data_type === 'json' || $item->data_type === 'array')
                            @php
                                $jsonData = json_decode($item->value, true);
                            @endphp
                            
                            @if(is_array($jsonData))
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Chiave</th>
                                            <th>Valore</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jsonData as $key => $value)
                                            <tr>
                                                <td>{{ $key }}</td>
                                                <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                {{ $item->value }}
                            @endif
                        @else
                            {{ $item->value }}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    
    <div class="footer">
        <p>Report generato da: SaluteOra | © {{ date('Y') }} SaluteOra. Tutti i diritti riservati.</p>
    </div>
</body>
</html>
