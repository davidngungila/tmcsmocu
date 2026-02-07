<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('finance.reports.index');
    }

    public function daily()
    {
        $date = request('date', now()->format('Y-m-d'));
        $transactions = FinanceTransaction::whereDate('transaction_date', $date)
            ->with('creator')
            ->latest()
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        
        return view('finance.reports.daily', compact('transactions', 'income', 'expenses', 'date'));
    }

    public function monthly()
    {
        $month = request('month', now()->format('Y-m'));
        $transactions = FinanceTransaction::whereYear('transaction_date', Carbon::parse($month)->year)
            ->whereMonth('transaction_date', Carbon::parse($month)->month)
            ->with('creator')
            ->latest()
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        
        return view('finance.reports.monthly', compact('transactions', 'income', 'expenses', 'month'));
    }

    public function annual()
    {
        $year = request('year', now()->year);
        $transactions = FinanceTransaction::whereYear('transaction_date', $year)
            ->with('creator')
            ->latest()
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        
        // Monthly breakdown
        $monthlyData = FinanceTransaction::select(
            DB::raw('MONTH(transaction_date) as month'),
            DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
            DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
        )
        ->whereYear('transaction_date', $year)
        ->groupBy('month')
        ->get();
        
        return view('finance.reports.annual', compact('transactions', 'income', 'expenses', 'year', 'monthlyData'));
    }
}
