<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions and the current balance.
     * Returns a view for web requests or JSON for API requests.
     */
    public function index(Request $request)
    {
        // Fetch all transactions, ordered by date descending
        $transactions = Transaction::orderBy('date', 'desc')->get();

        // Calculate the balance: Income is positive, Expense is negative.
        $balance = $transactions->sum(fn($t) => $t->type === 'income' ? $t->amount : -$t->amount);

        // Calculate monthly earnings for current month
        $currentMonth = now()->format('Y-m');
        $monthlyTransactions = Transaction::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->get();
        
        $monthlyIncome = $monthlyTransactions->where('type', 'income')->sum('amount');
        $monthlyExpense = $monthlyTransactions->where('type', 'expense')->sum('amount');
        $monthlyEarnings = $monthlyIncome - $monthlyExpense;

        $data = [
            'transactions' => $transactions,
            'balance' => $balance,
            'monthly_earnings' => $monthlyEarnings,
        ];

        // Check if this is an API request (route name starts with 'api.' or request expects JSON)
        $isApiRequest = $request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson();

        if ($isApiRequest) {
            return response()->json($data);
        }

        // Web Response - return a Blade view for web requests
        return view('transactions.index', $data);
    }

    // ... rest of the controller methods (store, destroy, monthlySummary) ...
    // They are already returning JSON, which is correct for API endpoints.

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        // Your validation is correct and robust!
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            // The 'min:0' rule is important for amounts
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::create($validated);

        // Check if this is an API request
        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            // Return the newly created resource with a 201 Created status
            return response()->json([
                'message' => 'Transaction created successfully.',
                'transaction' => $transaction
            ], 201);
        }

        // For web requests, redirect back with success message
        return redirect()->route('transactions.index')
            ->with('success', 'Transacción creada exitosamente.');
    }

    /**
     * Remove the specified transaction from storage.
     * Elimina la transacción especificada del almacenamiento.
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        // Eloquent's model binding (Transaction $transaction) is correctly used here.
        // El enlace automático del modelo de Eloquent encuentra la transacción por su ID
        $transaction->delete();

        // Verificar si es una petición de API
        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            // Para API, retornar 204 No Content sin cuerpo de respuesta
            return response()->noContent();
        }

        // Para peticiones web, redirigir de vuelta con mensaje de éxito
        return redirect()->route('transactions.index')
            ->with('success', 'Transacción eliminada exitosamente.');
    }

    /**
     * Calculate monthly income, expense, and net balance for a given month/year.
     * The input parameter $month should be in YYYY-MM format (e.g., 2025-08).
     */
    public function monthlySummary(string $month)
    {
        try {
            // Parse the input string into a Carbon date object
            $date = Carbon::createFromFormat('Y-m', $month);
        } catch (\Exception $e) {
            // Handle invalid date format input
            return response()->json(['error' => 'Invalid month format. Please use YYYY-MM.'], 400);
        }

        // Filter transactions for the specified year and month
        $transactions = Transaction::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $net = $totalIncome - $totalExpense;

        return response()->json([
            'month' => $date->format('Y-m'),
            'income' => $totalIncome,
            'expense' => $totalExpense,
            'net' => $net,
        ]);
    }
}
