<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    
     // Lista todas las transacciones y calcula el balance total
     // Retorna vista para web o JSON para API
     
    public function index(Request $request)
    {
        $transactions = Transaction::orderBy('date', 'desc')->get();
        $balance = Transaction::calculateBalance($transactions);
        $monthlyEarnings = Transaction::getMonthlyEarnings();

        $data = [
            'transactions' => $transactions,
            'balance' => $balance,
            'monthly_earnings' => $monthlyEarnings['earnings'],
        ];

        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            return response()->json($data);
        }

        return view('index', $data);
    }

    
     // Muestra el dashboard con resumen mensual y gráfico de balance.
     
    public function dashboard(Request $request)
    {
        $transactions = Transaction::orderBy('date', 'desc')->get();
        $balance = Transaction::calculateBalance($transactions);
        $monthlyEarnings = Transaction::getMonthlyEarnings();
        $chartData = Transaction::prepareChartData($transactions);

        $data = [
            'balance' => $balance,
            'monthly_earnings' => $monthlyEarnings['earnings'],
            'chart_labels' => $chartData['labels'],
            'chart_balances' => $chartData['balances'],
        ];

        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            return response()->json($data);
        }

        return view('dashboard', $data);
    }


     // Muestra la página de registro con formulario y lista de transacciones
     
    public function registro(Request $request)
    {
        $transactions = Transaction::orderBy('date', 'desc')->get();

        $data = [
            'transactions' => $transactions,
        ];

        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            return response()->json($data);
        }

        return view('registro', $data);
    }

    
     // Crea una nueva transacción
     // Valida: description, type (income/expense), amount (min:0), date

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::create($validated);

        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'message' => 'Transaction created successfully.',
                'transaction' => $transaction
            ], 201);
        }

        return redirect()->route('registro')
            ->with('success', 'Transacción creada exitosamente.');
    }

    
     // Retorna los datos de una transacción para edición (JSON).
     
    public function edit(Request $request, Transaction $transaction)
    {
        return response()->json($transaction);
    }

    
     // Actualiza una transacción existente
     // Valida los mismos campos que store
     
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $transaction->update($validated);

        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'message' => 'Transaction updated successfully.',
                'transaction' => $transaction
            ], 200);
        }

        return redirect()->route('registro')
            ->with('success', 'Transacción actualizada exitosamente.');
    }

    
     // Elimina una transacción
     // API retorna 204, web redirige a registro
     
    public function destroy(Request $request, Transaction $transaction)
    {
        $transaction->delete();

        if ($request->routeIs('api.*') || $request->wantsJson() || $request->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('registro')
            ->with('success', 'Transacción eliminada exitosamente.');
    }

    
     // Calcula resumen mensual (ingresos, gastos, neto)
     // Parámetro: $month formato: YYYY-MM 
     
    public function monthlySummary(string $month)
    {
        $summary = Transaction::getMonthlySummary($month);

        if ($summary === null) {
            return response()->json(['error' => 'Invalid month format. Please use YYYY-MM.'], 400);
        }

        return response()->json($summary);
    }
}
