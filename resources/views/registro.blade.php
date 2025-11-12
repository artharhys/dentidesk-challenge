<!-- Extender el layout principal -->
@extends('layout.layout')

@section('content')
    <!-- Título de la página -->
    <h1 class="display-5 fw-bold mb-4">Registro de Transacciones</h1>

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
                        placeholder="Descripción"
                    >
                </div>

                <!-- Fila con tres columnas: Monto, Tipo y Fecha -->
                <div class="row mb-3">
                    <!-- Columna para el monto -->
                    <div class="col-md-4">
                        <label for="amount" class="form-label">Monto ($)</label>
                        <input 
                            type="number" 
                            step="1" 
                            class="form-control" 
                            name="amount" 
                            id="amount" 
                            value="{{ old('amount') }}"
                            required
                            min="0"
                            placeholder="0"
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
                                        {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <!-- Acciones: Editar y Eliminar -->
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Botón para editar la transacción -->
                                            <button 
                                                type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editTransactionModal"
                                                data-transaction-id="{{ $transaction->id }}"
                                                data-transaction-description="{{ $transaction->description }}"
                                                data-transaction-amount="{{ $transaction->amount }}"
                                                data-transaction-type="{{ $transaction->type }}"
                                                data-transaction-date="{{ $transaction->date }}"
                                                onclick="loadTransactionData(this)"
                                            >
                                                Editar
                                            </button>
                                            
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
                                        </div>
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

    <!-- Modal para editar transacción -->
    <div class="modal fade" id="editTransactionModal" tabindex="-1" aria-labelledby="editTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransactionModalLabel">Editar Transacción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Formulario para editar la transacción -->
                <form id="editTransactionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Campo de descripción -->
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Descripción</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="description" 
                                id="edit_description" 
                                required
                                placeholder="Ej: Venta de producto o Pago de renta"
                            >
                        </div>

                        <!-- Fila con tres columnas: Monto, Tipo y Fecha -->
                        <div class="row mb-3">
                            <!-- Columna para el monto -->
                            <div class="col-md-4">
                                <label for="edit_amount" class="form-label">Monto ($)</label>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    class="form-control" 
                                    name="amount" 
                                    id="edit_amount" 
                                    required
                                    min="0"
                                    placeholder="0.00"
                                >
                            </div>

                            <!-- Columna para el tipo de transacción -->
                            <div class="col-md-4">
                                <label for="edit_type" class="form-label">Tipo</label>
                                <select 
                                    class="form-select" 
                                    name="type" 
                                    id="edit_type" 
                                    required
                                >
                                    <option value="income">Ingreso</option>
                                    <option value="expense">Gasto</option>
                                </select>
                            </div>

                            <!-- Columna para la fecha -->
                            <div class="col-md-4">
                                <label for="edit_date" class="form-label">Fecha</label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    name="date" 
                                    id="edit_date" 
                                    required
                                >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- Sección para scripts adicionales -->
@section('scripts')
    <script>
        // Función para cargar los datos de la transacción en el modal
        // Load transaction data into the modal
        function loadTransactionData(button) {
            // Obtener los datos desde los atributos data del botón
            // Get data from button's data attributes
            const id = button.getAttribute('data-transaction-id');
            const description = button.getAttribute('data-transaction-description');
            const amount = button.getAttribute('data-transaction-amount');
            const type = button.getAttribute('data-transaction-type');
            const date = button.getAttribute('data-transaction-date');
            
            // Establecer la acción del formulario con el ID de la transacción
            // Set form action with transaction ID
            document.getElementById('editTransactionForm').action = '{{ url('transactions') }}/' + id;
            
            // Llenar los campos del formulario con los datos de la transacción
            // Fill form fields with transaction data
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_amount').value = amount;
            document.getElementById('edit_type').value = type;
            document.getElementById('edit_date').value = date;
        }
    </script>
@endsection

