<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS desde CDN - Framework de estilos para diseño responsive -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Estilos personalizados para mejorar la apariencia -->
    <style>
        /* Color de fondo general de la página */
        body {
            background-color: #f8f9fa;
        }
        /* Estilo para las tarjetas (cards) - sin borde y con sombra sutil */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        /* Color verde para valores positivos en el resumen */
        .summary-positive {
            color: #198754;
        }
        /* Color rojo para valores negativos en el resumen */
        .summary-negative {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Contenedor principal con padding vertical -->
    <div class="container py-5">
        <h1 class="display-5 fw-bold mb-4">{{ config('app.name') }}</h1>

        <!-- Mensaje de éxito - Se muestra cuando una operación se completa correctamente -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <!-- Botón para cerrar el mensaje de alerta -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Mensajes de error - Se muestran cuando hay errores de validación -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong>
                <!-- Lista de todos los errores de validación -->
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <!-- Botón para cerrar el mensaje de alerta -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tarjeta de Resumen Mensual - Muestra el balance del mes actual -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title h5 mb-3">Resumen del Mes</h2>
                <!-- Monto ganado en el mes (positivo o negativo) con color dinámico -->
                <div class="display-6 fw-bold {{ $monthly_earnings >= 0 ? 'summary-positive' : 'summary-negative' }}">
                    ${{ number_format($monthly_earnings, 2, ',', '.') }}
                </div>
                <!-- Balance total acumulado de todas las transacciones -->
                <p class="text-muted mt-2 mb-0">Balance Total: ${{ number_format($balance, 2, ',', '.') }}</p>
            </div>
        </div>

        <!-- Formulario para crear nueva transacción -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title h5 mb-4">Nueva Transacción</h2>
                
                <!-- Formulario POST que envía los datos al controlador -->
                <form action="{{ route('transactions.store') }}" method="POST">
                    <!-- Token CSRF para protección contra ataques de falsificación de solicitudes -->
                    @csrf

                    <!-- Campo de descripción de la transacción -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="description" 
                            id="description" 
                            value="{{ old('description') }}"
                            required
                            placeholder="Ej: Venta de producto o Pago de renta"
                        >
                    </div>

                    <!-- Fila con tres columnas: Monto, Tipo y Fecha -->
                    <div class="row mb-3">
                        <!-- Columna para el monto -->
                        <div class="col-md-4">
                            <label for="amount" class="form-label">Monto ($)</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                class="form-control" 
                                name="amount" 
                                id="amount" 
                                value="{{ old('amount') }}"
                                required
                                min="0"
                                placeholder="0.00"
                            >
                        </div>

                        <!-- Columna para el tipo de transacción (Ingreso o Gasto) -->
                        <div class="col-md-4">
                            <label for="type" class="form-label">Tipo</label>
                            <select 
                                class="form-select" 
                                name="type" 
                                id="type" 
                                required
                            >
                                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Ingreso</option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Gasto</option>
                            </select>
                        </div>

                        <!-- Columna para la fecha de la transacción -->
                        <div class="col-md-4">
                            <label for="date" class="form-label">Fecha</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                name="date" 
                                id="date" 
                                value="{{ old('date', date('Y-m-d')) }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Botón para enviar el formulario -->
                    <button type="submit" class="btn btn-primary">
                        Guardar Transacción
                    </button>
                </form>
            </div>
        </div>

        <!-- Lista de transacciones existentes -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title h5 mb-4">Transacciones</h2>
                
                <!-- Verificar si hay transacciones para mostrar -->
                @if($transactions->count() > 0)
                    <!-- Tabla responsive que se adapta a pantallas pequeñas -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <!-- Encabezados de la tabla -->
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <!-- Cuerpo de la tabla con todas las transacciones -->
                            <tbody>
                                <!-- Iterar sobre cada transacción en la colección -->
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <!-- Fecha formateada en formato día/mes/año -->
                                        <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                                        <!-- Descripción de la transacción -->
                                        <td>{{ $transaction->description }}</td>
                                        <!-- Badge (etiqueta) que indica si es Ingreso (verde) o Gasto (rojo) -->
                                        <td>
                                            <span class="badge {{ $transaction->type === 'income' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $transaction->type === 'income' ? 'Ingreso' : 'Gasto' }}
                                            </span>
                                        </td>
                                        <!-- Monto con signo + o - y color según el tipo -->
                                        <td class="fw-semibold {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2, ',', '.') }}
                                        </td>
                                        <!-- Formulario para eliminar la transacción -->
                                        <td>
                                            <!-- Formulario DELETE que envía la solicitud al controlador -->
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                                                @csrf
                                                <!-- Método HTTP DELETE (Laravel lo convierte automáticamente) -->
                                                @method('DELETE')
                                                <!-- Botón de eliminar con confirmación JavaScript -->
                                                <button 
                                                    type="submit"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta transacción?')"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Mensaje cuando no hay transacciones registradas -->
                    <p class="text-muted text-center py-4 mb-0">
                        No hay transacciones. ¡Agrega una para comenzar!
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript desde CDN - Necesario para funcionalidades como alertas dismissibles -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
