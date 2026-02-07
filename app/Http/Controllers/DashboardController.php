<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceTransaction;
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
        // Calculate totals
        $totalIncome = FinanceTransaction::where('type', 'income')->sum('amount') ?? 0;
        $totalExpenses = FinanceTransaction::where('type', 'expense')->sum('amount') ?? 0;
        $balance = $totalIncome - $totalExpenses;
        $totalParishioners = Parishioner::count();
        
        // Monthly statistics
        $monthlyIncome = FinanceTransaction::where('type', 'income')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount') ?? 0;
        
        $monthlyExpenses = FinanceTransaction::where('type', 'expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount') ?? 0;
        
        // Weekly statistics
        $weeklyIncome = FinanceTransaction::where('type', 'income')
            ->whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('amount') ?? 0;
        
        $weeklyExpenses = FinanceTransaction::where('type', 'expense')
            ->whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('amount') ?? 0;
        
        // Today's statistics
        $todayIncome = FinanceTransaction::where('type', 'income')
            ->whereDate('transaction_date', today())
            ->sum('amount') ?? 0;
        
        $todayExpenses = FinanceTransaction::where('type', 'expense')
            ->whereDate('transaction_date', today())
            ->sum('amount') ?? 0;
        
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
            $incomeTrend[] = [
                'date' => $date->format('M d'),
                'amount' => FinanceTransaction::where('type', 'income')
                    ->whereDate('transaction_date', $date)
                    ->sum('amount') ?? 0
            ];
        }
        
        // Last 7 days expenses trend
        $expensesTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $expensesTrend[] = [
                'date' => $date->format('M d'),
                'amount' => FinanceTransaction::where('type', 'expense')
                    ->whereDate('transaction_date', $date)
                    ->sum('amount') ?? 0
            ];
        }
        
        return view('dashboard', compact(
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

