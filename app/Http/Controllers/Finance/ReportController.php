<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use App\Models\FinancialYear;
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
        $activeYear = FinancialYear::getActive();
        
        $query = FinanceTransaction::whereDate('transaction_date', $date);
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $transactions = $query->with('creator')
            ->latest()
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        
        return view('finance.reports.daily', compact('transactions', 'income', 'expenses', 'date', 'activeYear'));
    }

    public function monthly()
    {
        $month = request('month', now()->format('Y-m'));
        $activeYear = FinancialYear::getActive();
        
        $query = FinanceTransaction::whereYear('transaction_date', Carbon::parse($month)->year)
            ->whereMonth('transaction_date', Carbon::parse($month)->month);
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $transactions = $query->with('creator')
            ->latest()
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        
        return view('finance.reports.monthly', compact('transactions', 'income', 'expenses', 'month', 'activeYear'));
    }

    public function annual()
    {
        $activeYear = FinancialYear::getActive();
        $year = request('year', $activeYear ? $activeYear->start_date->year : now()->year);
        
        $query = FinanceTransaction::whereYear('transaction_date', $year);
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $transactions = $query->with('creator')
            ->latest()
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        
        // Monthly breakdown
        $monthlyQuery = FinanceTransaction::select(
            DB::raw('MONTH(transaction_date) as month'),
            DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
            DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
        )
        ->whereYear('transaction_date', $year);
        
        if ($activeYear) {
            $monthlyQuery->where('financial_year_id', $activeYear->id);
        }
        
        $monthlyData = $monthlyQuery->groupBy('month')->get();
        
        return view('finance.reports.annual', compact('transactions', 'income', 'expenses', 'year', 'monthlyData', 'activeYear'));
    }

    public function dailyPdf()
    {
        $date = request('date', now()->format('Y-m-d'));
        $activeYear = FinancialYear::getActive();
        
        $query = FinanceTransaction::whereDate('transaction_date', $date);
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $transactions = $query->with(['creator', 'parishioner', 'financialYear'])
            ->latest()
            ->get();
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        
        // Group by category
        $incomeByCategory = $transactions->where('type', 'income')->groupBy('category')->map(function ($items) {
            return [
                'total' => $items->sum('amount'),
                'count' => $items->count()
            ];
        });
        
        $expensesByCategory = $transactions->where('type', 'expense')->groupBy('category')->map(function ($items) {
            return [
                'total' => $items->sum('amount'),
                'count' => $items->count()
            ];
        });
        
        // Top contributors
        $topContributors = $transactions->where('type', 'income')
            ->whereNotNull('parishioner_id')
            ->groupBy('parishioner_id')
            ->map(function ($items) {
                return [
                    'parishioner' => $items->first()->parishioner,
                    'total' => $items->sum('amount'),
                    'count' => $items->count()
                ];
            })
            ->sortByDesc('total')
            ->take(10)
            ->values();
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('reports.pdf.financial', compact(
            'transactions',
            'totalIncome',
            'totalExpenses',
            'date',
            'activeYear',
            'incomeByCategory',
            'expensesByCategory',
            'topContributors'
        ))->setPaper('a4', 'portrait')
          ->setOption('enable-local-file-access', true)
          ->setOption('isHtml5ParserEnabled', true)
          ->setOption('isRemoteEnabled', true);
        
        return $pdf->download('financial-report-daily-' . $date . '.pdf');
    }

    public function monthlyPdf()
    {
        $month = request('month', now()->format('Y-m'));
        $activeYear = FinancialYear::getActive();
        
        $query = FinanceTransaction::whereYear('transaction_date', Carbon::parse($month)->year)
            ->whereMonth('transaction_date', Carbon::parse($month)->month);
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $transactions = $query->with(['creator', 'parishioner', 'financialYear'])
            ->latest()
            ->get();
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        
        // Group by category
        $incomeByCategory = $transactions->where('type', 'income')->groupBy('category')->map(function ($items) {
            return [
                'total' => $items->sum('amount'),
                'count' => $items->count()
            ];
        });
        
        $expensesByCategory = $transactions->where('type', 'expense')->groupBy('category')->map(function ($items) {
            return [
                'total' => $items->sum('amount'),
                'count' => $items->count()
            ];
        });
        
        // Top contributors
        $topContributors = $transactions->where('type', 'income')
            ->whereNotNull('parishioner_id')
            ->groupBy('parishioner_id')
            ->map(function ($items) {
                return [
                    'parishioner' => $items->first()->parishioner,
                    'total' => $items->sum('amount'),
                    'count' => $items->count()
                ];
            })
            ->sortByDesc('total')
            ->take(10)
            ->values();
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('reports.pdf.financial', compact(
            'transactions',
            'totalIncome',
            'totalExpenses',
            'month',
            'activeYear',
            'incomeByCategory',
            'expensesByCategory',
            'topContributors'
        ))->setPaper('a4', 'portrait')
          ->setOption('enable-local-file-access', true)
          ->setOption('isHtml5ParserEnabled', true)
          ->setOption('isRemoteEnabled', true);
        
        return $pdf->download('financial-report-monthly-' . $month . '.pdf');
    }

    public function annualPdf()
    {
        $activeYear = FinancialYear::getActive();
        $year = request('year', $activeYear ? $activeYear->start_date->year : now()->year);
        
        $query = FinanceTransaction::whereYear('transaction_date', $year);
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $transactions = $query->with(['creator', 'parishioner', 'financialYear'])
            ->latest()
            ->get();
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        
        // Group by category
        $incomeByCategory = $transactions->where('type', 'income')->groupBy('category')->map(function ($items) {
            return [
                'total' => $items->sum('amount'),
                'count' => $items->count()
            ];
        });
        
        $expensesByCategory = $transactions->where('type', 'expense')->groupBy('category')->map(function ($items) {
            return [
                'total' => $items->sum('amount'),
                'count' => $items->count()
            ];
        });
        
        // Top contributors
        $topContributors = $transactions->where('type', 'income')
            ->whereNotNull('parishioner_id')
            ->groupBy('parishioner_id')
            ->map(function ($items) {
                return [
                    'parishioner' => $items->first()->parishioner,
                    'total' => $items->sum('amount'),
                    'count' => $items->count()
                ];
            })
            ->sortByDesc('total')
            ->take(10)
            ->values();
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('reports.pdf.financial', compact(
            'transactions',
            'totalIncome',
            'totalExpenses',
            'year',
            'activeYear',
            'incomeByCategory',
            'expensesByCategory',
            'topContributors'
        ))->setPaper('a4', 'portrait')
          ->setOption('enable-local-file-access', true)
          ->setOption('isHtml5ParserEnabled', true)
          ->setOption('isRemoteEnabled', true);
        
        return $pdf->download('financial-report-annual-' . $year . '.pdf');
    }
}
