<!-- Extender el layout principal -->
@extends('layout.layout')

@section('content')
    <!-- Título de la página -->
    <h1 class="display-5 fw-bold mb-4">Dashboard</h1>

    <!-- Tarjeta de Resumen Mensual - Muestra el balance del mes actual -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title h5 mb-3">Resumen del mes</h2>
            <!-- Monto ganado en el mes (positivo o negativo) con color dinámico -->
            <div class="display-6 fw-bold {{ $monthly_earnings >= 0 ? 'summary-positive' : 'summary-negative' }}">
                ${{ number_format($monthly_earnings, 0, ',', '.') }}
            </div>
            <!-- Balance total acumulado de todas las transacciones -->
            <p class="text-muted mt-2 mb-0">Balance Total: ${{ number_format($balance, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Gráfico de Balance a lo largo del tiempo -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title h5 mb-3">Evolución del Balance</h2>
            <!-- Contenedor para Chart.js -->
            <canvas id="balanceChart" style="max-height: 400px;"></canvas>
        </div>
    </div>
@endsection

<!-- Sección para el gráfico -->
@section('scripts')
    <!-- Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        // Datos del gráfico desde el controlador
        const chartLabels = @json($chart_labels);
        const chartBalances = @json($chart_balances);

        // Configuración del gráfico
        const ctx = document.getElementById('balanceChart').getContext('2d');
        const balanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Balance ($)',
                    data: chartBalances,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Balance ($)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha'
                        }
                    }
                },
                plugins: {
                    legend: {display: false}
                }
            }
        });
    </script>
@endsection

