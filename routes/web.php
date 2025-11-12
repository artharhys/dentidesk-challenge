<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// --- Homepage Route ---
// 1. You already imported TransactionController, so use the short syntax.
// 2. This route is often aliased to 'home' or left alone.
Route::get('/', [TransactionController::class, 'index'])->name('home');

// --- Standard Transaction Routes (RESTful Subset) ---
// 1. Use the short syntax (TransactionController::class).
// 2. You can group routes for better organization and performance.
Route::prefix('transactions')->group(function () {
    // GET /transactions (Listing/Index)
    // Note: This route points to the same controller method as the homepage.
    // Both routes work, but they have different names to avoid conflicts.
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');

    // POST /transactions (Create/Store)
    Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');

    // GET /transactions/summary/{month} (Custom Route - must be before {transaction} route)
    Route::get('/summary/{month}', [TransactionController::class, 'monthlySummary'])->name('transactions.summary.monthly');

    // DELETE /transactions/{transaction} (Delete)
    // Using a named route here is highly recommended for generating URLs.
    // Note: This must come after /summary/{month} to avoid route conflicts
    Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});

// --- Optional: Use Route::resource() for CRUD routes (The Laravel Way) ---
/*
If you have a full set of CRUD actions (index, create, store, show, edit, update, destroy),
the cleanest approach is to use a resource route.

Example:
Route::resource('transactions', TransactionController::class);

This one line replaces:
GET    /transactions          -> index
POST   /transactions          -> store
GET    /transactions/create   -> create
GET    /transactions/{transaction}   -> show
PUT/PATCH /transactions/{transaction} -> update
DELETE /transactions/{transaction} -> destroy
GET    /transactions/{transaction}/edit -> edit
*/
