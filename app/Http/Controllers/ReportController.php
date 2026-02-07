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
use App\Models\SmsCampaign;

class ReportController extends Controller
{
    public function index()
    {
        // Get statistics for the reports dashboard
        $totalIncome = FinanceTransaction::where('type', 'income')->sum('amount');
        $totalExpenses = FinanceTransaction::where('type', 'expense')->sum('amount');
        $totalParishioners = Parishioner::count();
        $totalEvents = Event::count();
        $totalCommunities = Community::count();
        $totalGroups = ApostolicGroup::count();
        $totalLeaders = Leader::where('is_active', true)->count();
        $totalAssets = Asset::count();
        $totalSmsCampaigns = SmsCampaign::count();
        
        return view('reports.index', compact(
            'totalIncome',
            'totalExpenses',
            'totalParishioners',
            'totalEvents',
            'totalCommunities',
            'totalGroups',
            'totalLeaders',
            'totalAssets',
            'totalSmsCampaigns'
        ));
    }
}
