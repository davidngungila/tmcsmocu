<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceTransaction;
use App\Models\FinancialYear;
use App\Models\Parishioner;
use App\Models\Event;
use App\Models\Community;
use App\Models\ApostolicGroup;
use App\Models\Leader;
use App\Models\Asset;
use App\Models\SacramentSale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $activeYear = FinancialYear::getActive();
        
        // Base query for transactions
        $incomeQuery = FinanceTransaction::where('type', 'income');
        $expenseQuery = FinanceTransaction::where('type', 'expense');
        
        // Filter by active financial year if exists
        if ($activeYear) {
            $incomeQuery->where('financial_year_id', $activeYear->id);
            $expenseQuery->where('financial_year_id', $activeYear->id);
        }
        
        // Calculate totals
        $totalIncome = $incomeQuery->sum('amount') ?? 0;
        $totalExpenses = $expenseQuery->sum('amount') ?? 0;
        $balance = $totalIncome - $totalExpenses;
        $totalParishioners = Parishioner::count();
        
        // Monthly statistics
        $monthlyIncome = (clone $incomeQuery)
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount') ?? 0;
        
        $monthlyExpenses = (clone $expenseQuery)
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount') ?? 0;
        
        // Weekly statistics
        $weeklyIncome = (clone $incomeQuery)
            ->whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('amount') ?? 0;
        
        $weeklyExpenses = (clone $expenseQuery)
            ->whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('amount') ?? 0;
        
        // Today's statistics
        $todayIncome = (clone $incomeQuery)
            ->whereDate('transaction_date', today())
            ->sum('amount') ?? 0;
        
        $todayExpenses = (clone $expenseQuery)
            ->whereDate('transaction_date', today())
            ->sum('amount') ?? 0;
        
        // Income by category
        $incomeByCategory = (clone $incomeQuery)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
        
        // Expenses by category
        $expensesByCategory = (clone $expenseQuery)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
        
        // Recent transactions
        $recentQuery = FinanceTransaction::query();
        if ($activeYear) {
            $recentQuery->where('financial_year_id', $activeYear->id);
        }
        $recentTransactions = $recentQuery->with('creator')
            ->latest()
            ->limit(10)
            ->get();
        
        // Upcoming events
        $upcomingEvents = Event::where('start_date', '>=', today())
            ->where('is_active', true)
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();
        
        // Statistics
        $totalEvents = Event::count();
        $totalCommunities = Community::count();
        $totalApostolicGroups = ApostolicGroup::count();
        $totalLeaders = Leader::where('is_active', true)->count();
        $totalAssets = Asset::count();
        $totalSacraments = SacramentSale::sum('amount') ?? 0;
        
        // Student vs Worker parishioners
        $studentParishioners = Parishioner::where('type', 'wanafunzi')->count();
        $workerParishioners = Parishioner::where('type', 'wafanyakazi')->count();
        
        // Last 7 days income trend
        $incomeTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trendQuery = FinanceTransaction::where('type', 'income')
                ->whereDate('transaction_date', $date);
            if ($activeYear) {
                $trendQuery->where('financial_year_id', $activeYear->id);
            }
            $incomeTrend[] = [
                'date' => $date->format('M d'),
                'amount' => $trendQuery->sum('amount') ?? 0
            ];
        }
        
        // Last 7 days expenses trend
        $expensesTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trendQuery = FinanceTransaction::where('type', 'expense')
                ->whereDate('transaction_date', $date);
            if ($activeYear) {
                $trendQuery->where('financial_year_id', $activeYear->id);
            }
            $expensesTrend[] = [
                'date' => $date->format('M d'),
                'amount' => $trendQuery->sum('amount') ?? 0
            ];
        }
        
        return view('dashboard', compact(
            'activeYear',
            'totalIncome',
            'totalExpenses',
            'balance',
            'totalParishioners',
            'recentTransactions',
            'monthlyIncome',
            'monthlyExpenses',
            'weeklyIncome',
            'weeklyExpenses',
            'todayIncome',
            'todayExpenses',
            'incomeByCategory',
            'expensesByCategory',
            'upcomingEvents',
            'totalEvents',
            'totalCommunities',
            'totalApostolicGroups',
            'totalLeaders',
            'totalAssets',
            'totalSacraments',
            'studentParishioners',
            'workerParishioners',
            'incomeTrend',
            'expensesTrend'
        ));
    }
}

