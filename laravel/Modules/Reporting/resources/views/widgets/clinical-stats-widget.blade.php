<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            Statistiche Cliniche
        </x-slot>

        <x-slot name="headerEnd">
            <x-filament::badge color="success">
                Aggiornato: {{ now()->format('d/m/Y H:i') }}
            </x-filament::badge>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Riepilogo pazienti -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Pazienti</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Totale pazienti</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ number_format($totalPatients, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nuovi questo mese</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ number_format($newPatientsThisMonth, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">ISEE medio</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ number_format($averageIsee ?? 0, 2, ',', '.') }} €</p>
                    </div>
                </div>
            </div>

            <!-- Riepilogo appuntamenti -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Appuntamenti</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Totale appuntamenti</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ number_format($totalAppointments, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Appuntamenti del mese</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ number_format($appointmentsThisMonth, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tasso completamento</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ $completionRate }}%</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">In attesa</p>
                        <p class="text-2xl font-semibold text-primary-600">{{ number_format($pendingAppointments, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafici e dati dettagliati -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Distribuzione ISEE -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Distribuzione ISEE</h3>
                <div class="space-y-2">
                    @foreach($patientsByIseeRange as $range => $count)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $range }} €</span>
                                <span class="text-sm font-medium text-gray-700">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $percentage = $totalPatients > 0 ? ($count / $totalPatients) * 100 : 0;
                                @endphp
                                <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Distribuzione geografica -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Distribuzione Geografica (Top 5)</h3>
                <div class="space-y-2">
                    @foreach($patientsByCity as $city => $count)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $city }}</span>
                                <span class="text-sm font-medium text-gray-700">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $percentage = $totalPatients > 0 ? ($count / $totalPatients) * 100 : 0;
                                @endphp
                                <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Trend appuntamenti mensili -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Trend Appuntamenti {{ date('Y') }}</h3>
                <div class="h-60">
                    <canvas id="appointmentsTrendChart"></canvas>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('appointmentsTrendChart').getContext('2d');
                        
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode(array_keys($appointmentsByMonth)) !!},
                                datasets: [{
                                    label: 'Appuntamenti',
                                    data: {!! json_encode(array_values($appointmentsByMonth)) !!},
                                    fill: false,
                                    borderColor: '#4f46e5',
                                    tension: 0.1
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
                        });
                    });
                </script>
            </div>

            <!-- Trend pazienti mensili -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Trend Nuovi Pazienti {{ date('Y') }}</h3>
                <div class="h-60">
                    <canvas id="patientsTrendChart"></canvas>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('patientsTrendChart').getContext('2d');
                        
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode(array_keys($patientsByMonth)) !!},
                                datasets: [{
                                    label: 'Nuovi Pazienti',
                                    data: {!! json_encode(array_values($patientsByMonth)) !!},
                                    backgroundColor: '#4f46e5'
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
                        });
                    });
                </script>
            </div>
        </div>
    </x-filament::section>
</x-filament::widget>
