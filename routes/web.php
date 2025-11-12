<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// Redirige la raiz al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Ruta del dashboard
Route::get('/dashboard', [TransactionController::class, 'dashboard'])->name('dashboard');

// Ruta del registro
Route::get('/registro', [TransactionController::class, 'registro'])->name('registro');

// Rutas RESTful de transacciones (prefijo /transactions)
// IMPORTANTE: Las rutas específicas deben ir antes de las dinámicas
Route::prefix('transactions')->group(function () {
    
    // Ruta para listar todas las transacciones (web/API)
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');

    // Ruta para crear nueva transacción
    // Requiere: description, type (income/expense), amount, date
    Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');

    // Resumen mensual, debe ir antes de /{transaction}
    // Parámetro: {month} en formato YYYY-MM (ej: 2025-11)
    Route::get('/summary/{month}', [TransactionController::class, 'monthlySummary'])->name('transactions.summary.monthly');

    // Formulario de edición (retorna JSON con datos de la transacción)
    Route::get('/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');

    // Ruta para actualizar transacción existente
    Route::put('/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::patch('/{transaction}', [TransactionController::class, 'update']);

    // Ruta para eliminar transacción, debe ir al final para evitar conflictos
    Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});
