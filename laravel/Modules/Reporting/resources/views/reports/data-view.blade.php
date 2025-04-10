@php
    $report = $getRecord();
    $groupedData = $report->reportData()
        ->orderBy('group')
        ->orderBy('order')
        ->get()
        ->groupBy('group');
@endphp

@if($report->status !== 'completed')
    <div class="p-6 text-center">
        <div class="text-lg font-medium text-gray-500">
            @if($report->status === 'pending')
                <x-filament::icon icon="heroicon-o-clock" class="w-8 h-8 mx-auto text-gray-400" />
                <p class="mt-2">Il report è in attesa di essere generato.</p>
            @elseif($report->status === 'processing')
                <x-filament::loading-indicator class="w-8 h-8 mx-auto text-primary-500" />
                <p class="mt-2">Il report è in fase di elaborazione.</p>
            @else
                <x-filament::icon icon="heroicon-o-exclamation-circle" class="w-8 h-8 mx-auto text-danger-500" />
                <p class="mt-2">Si è verificato un errore durante la generazione del report.</p>
            @endif
        </div>
    </div>
@elseif($groupedData->isEmpty())
    <div class="p-6 text-center">
        <x-filament::icon icon="heroicon-o-document" class="w-8 h-8 mx-auto text-gray-400" />
        <p class="mt-2 text-lg font-medium text-gray-500">Nessun dato disponibile per questo report.</p>
    </div>
@else
    @foreach($groupedData as $group => $data)
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">{{ ucfirst(str_replace('_', ' ', $group)) }}</h3>
            
            @if(count($data) > 10 && $data->first()->data_type === 'json')
                {{-- Per grandi set di dati JSON, mostro un grafico --}}
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <div id="chart-{{ Str::slug($group) }}" class="h-60"></div>
                </div>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const chartData = {!! json_encode($data->first()->value) !!};
                        if (typeof chartData === 'string') {
                            try {
                                const parsedData = JSON.parse(chartData);
                                const labels = Object.keys(parsedData);
                                const values = Object.values(parsedData);
                                
                                new Chart(
                                    document.getElementById('chart-{{ Str::slug($group) }}'), 
                                    {
                                        type: 'bar',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                label: '{{ ucfirst(str_replace('_', ' ', $group)) }}',
                                                data: values,
                                                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                                                borderColor: 'rgb(79, 70, 229)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        precision: 0
                                                    }
                                                }
                                            }
                                        }
                                    }
                                );
                            } catch (e) {
                                console.error('Errore nel parsing dei dati JSON:', e);
                            }
                        }
                    });
                </script>
            @else
                {{-- Per altri tipi di dati, mostro una griglia di card --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($data as $item)
                        <div class="bg-white rounded-lg shadow p-4">
                            <h4 class="font-medium text-gray-900 mb-2">{{ $item->description }}</h4>
                            
                            @if($item->data_type === 'json' || $item->data_type === 'array')
                                @php
                                    $jsonValue = is_string($item->value) ? json_decode($item->value, true) : $item->value;
                                @endphp
                                
                                @if(is_array($jsonValue) && count($jsonValue) <= 5)
                                    <ul class="space-y-1 text-sm">
                                        @foreach($jsonValue as $key => $val)
                                            <li class="flex justify-between">
                                                <span class="text-gray-600">{{ $key }}</span>
                                                <span class="font-medium">{{ is_array($val) ? json_encode($val) : $val }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-sm text-gray-600 max-h-40 overflow-y-auto">
                                        <pre class="whitespace-pre-wrap">{{ json_encode($jsonValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                @endif
                            @elseif($item->data_type === 'integer' || $item->data_type === 'float')
                                <p class="text-2xl font-bold text-primary-600">{{ number_format((float)$item->value, $item->data_type === 'float' ? 2 : 0, ',', '.') }}</p>
                            @elseif($item->data_type === 'percentage')
                                <div class="flex items-center">
                                    <p class="text-2xl font-bold text-primary-600">{{ number_format((float)$item->value, 1, ',', '.') }}%</p>
                                    <div class="ml-4 flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary-600 rounded-full" style="width: {{ min((float)$item->value, 100) }}%"></div>
                                    </div>
                                </div>
                            @elseif($item->data_type === 'date' || $item->data_type === 'datetime')
                                <p class="text-lg font-medium text-gray-900">
                                    {{ $item->data_type === 'date' 
                                        ? \Carbon\Carbon::parse($item->value)->format('d/m/Y')
                                        : \Carbon\Carbon::parse($item->value)->format('d/m/Y H:i') 
                                    }}
                                </p>
                            @else
                                <p class="text-lg text-gray-900">{{ $item->value }}</p>
                            @endif
                            
                            @if($item->metadata)
                                <div class="mt-2 text-xs text-gray-500">
                                    @php
                                        $metadata = is_string($item->metadata) ? json_decode($item->metadata, true) : $item->metadata;
                                    @endphp
                                    
                                    @if(is_array($metadata) && isset($metadata['note']))
                                        <p class="italic">Nota: {{ $metadata['note'] }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
    
    <x-reporting-chart-assets />
@endif
