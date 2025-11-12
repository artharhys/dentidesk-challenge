<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// --- API Transaction Routes ---
// These routes are prefixed with /api automatically by Laravel
Route::prefix('transactions')->group(function () {
    // GET /api/transactions (Listing/Index)
    Route::get('/', [TransactionController::class, 'index'])->name('api.transactions.index');

    // POST /api/transactions (Create/Store)
    Route::post('/', [TransactionController::class, 'store'])->name('api.transactions.store');

    // GET /api/transactions/summary/{month} (Custom Route - must be before {transaction} route)
    Route::get('/summary/{month}', [TransactionController::class, 'monthlySummary'])->name('api.transactions.summary.monthly');

    // DELETE /api/transactions/{transaction} (Delete)
    // Note: This must come after /summary/{month} to avoid route conflicts
    Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('api.transactions.destroy');
});

