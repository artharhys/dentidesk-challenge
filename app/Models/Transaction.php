<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'type',
        'amount',
        'date',
    ];

    // Mostrar monto con signo
    public function getSignedAmountAttribute()
    {
        return $this->type === 'expense' ? -$this->amount : $this->amount;
    }

    // Calcula el balance total de una colección de transacciones
    // Balance = suma de ingresos - suma de gastos
    public static function calculateBalance($transactions)
    {
        return $transactions->sum(function ($transaction) {
            return $transaction->type === 'income' ? $transaction->amount : -$transaction->amount;
        });
    }

    // Calcula las ganancias mensuales (ingresos - gastos) para un año y mes específicos
    // Retorna: ['income' => X, 'expense' => Y, 'earnings' => Z]
    public static function getMonthlyEarnings($year = null, $month = null)
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;

        $transactions = self::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $income = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');
        $earnings = $income - $expense;

        return [
            'income' => $income,
            'expense' => $expense,
            'earnings' => $earnings,
        ];
    }

    // Prepara datos para el gráfico de balance a lo largo del tiempo
    // Retorna: ['labels' => [...], 'balances' => [...]]
    public static function prepareChartData($transactions)
    {
        $sortedTransactions = $transactions->sortBy('date');
        $labels = [];
        $balances = [];
        $cumulativeBalance = 0;

        foreach ($sortedTransactions as $transaction) {
            $amount = $transaction->type === 'income' ? $transaction->amount : -$transaction->amount;
            $cumulativeBalance += $amount;
            $labels[] = Carbon::parse($transaction->date)->format('d/m/Y');
            $balances[] = round($cumulativeBalance, 2);
        }

        // Si no hay transacciones, mostrar punto inicial
        if (empty($labels)) {
            $labels[] = now()->format('d/m/Y');
            $balances[] = 0;
        }

        return [
            'labels' => $labels,
            'balances' => $balances,
        ];
    }

    // Calcula el resumen mensual completo (ingresos, gastos, neto)
    // Parámetro: $month en formato YYYY-MM (ej: "2025-11")
    public static function getMonthlySummary(string $month)
    {
        try {
            $date = Carbon::createFromFormat('Y-m', $month);
        } catch (\Exception $e) {
            return null; // Retorna null si el formato es inválido
        }

        $transactions = self::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $net = $totalIncome - $totalExpense;

        return [
            'month' => $date->format('Y-m'),
            'income' => $totalIncome,
            'expense' => $totalExpense,
            'net' => $net,
        ];
    }
}
