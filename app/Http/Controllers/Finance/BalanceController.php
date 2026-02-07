<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function index()
    {
        $totalIncome = FinanceTransaction::where('type', 'income')->sum('amount') ?? 0;
        $totalExpenses = FinanceTransaction::where('type', 'expense')->sum('amount') ?? 0;
        $balance = $totalIncome - $totalExpenses;
        
        // Income by category
        $incomeByCategory = FinanceTransaction::where('type', 'income')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
        
        // Expenses by category
        $expensesByCategory = FinanceTransaction::where('type', 'expense')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
        
        // Recent transactions
        $recentTransactions = FinanceTransaction::with('creator')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('finance.balance', compact(
            'totalIncome',
            'totalExpenses',
            'balance',
            'incomeByCategory',
            'expensesByCategory',
            'recentTransactions'
        ));
    }
}
