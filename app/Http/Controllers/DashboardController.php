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
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        
        // Route to appropriate dashboard based on role
        if ($role) {
            // Debug: Log the role information
            \Log::info('User role:', ['user_id' => $user->id, 'role_name' => $role->name, 'role_slug' => $role->slug]);
            
            switch ($role->slug) {
                case 'super_admin':
                case 'chaplain':
                case 'system_admin':
                case 'admin':
                case 'administrator':
                    return $this->superAdminDashboard();
                case 'priest':
                    return $this->priestDashboard();
                case 'secretary':
                    return $this->secretaryDashboard();
                case 'treasurer':
                    return $this->treasurerDashboard();
                case 'church_leader':
                    return $this->churchLeaderDashboard();
                case 'spiritual_coordinator':
                    return $this->spiritualCoordinatorDashboard();
                case 'group_leader':
                    return $this->groupLeaderDashboard();
                case 'event_chairperson':
                    return $this->eventChairpersonDashboard();
                default:
                    // Debug: Log the default case
                    \Log::info('Default case triggered for role:', ['role_slug' => $role->slug]);
                    return $this->memberDashboard();
            }
        }
        
        // Fallback to member dashboard
        return $this->memberDashboard();
    }
    
    private function superAdminDashboard()
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
        
        // Member statistics
        $studentCount = Parishioner::where('member_type', 'student')->count();
        $staffCount = Parishioner::where('member_type', 'employee')->count();
        $newMembersThisMonth = Parishioner::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Financial year contributions
        $totalContributions = $totalIncome;
        
        // Certificate statistics
        $certificatesIssued = \App\Models\Certificate::whereYear('created_at', now()->year)->count();
        
        // Events
        $upcomingEventsCount = Event::where('start_date', '>=', today())
            ->where('start_date', '<=', now()->addDays(7))
            ->count();
        
        // Shop sales (placeholder - would need actual shop model)
        $shopSales = 185000;
        
        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'balance',
            'totalParishioners',
            'studentCount',
            'staffCount',
            'newMembersThisMonth',
            'totalContributions',
            'certificatesIssued',
            'upcomingEventsCount',
            'shopSales'
        ));
    }
    
    private function priestDashboard()
    {
        $totalParishioners = Parishioner::count();
        $sacramentsThisMonth = 28; // Would need actual sacrament model
        $massAttendance = 78; // Would need attendance tracking
        $spiritualGroups = 12; // Would need spiritual groups model
        
        return view('dashboards.priest', compact(
            'totalParishioners',
            'sacramentsThisMonth',
            'massAttendance',
            'spiritualGroups'
        ));
    }
    
    private function secretaryDashboard()
    {
        $pendingDocuments = 15; // Would need document model
        $appointmentsToday = 8; // Would need appointment model
        $communicationsSent = 42; // Would need communication model
        $recordsUpdated = 23; // Would need record tracking
        
        return view('dashboards.secretary', compact(
            'pendingDocuments',
            'appointmentsToday',
            'communicationsSent',
            'recordsUpdated'
        ));
    }
    
    private function treasurerDashboard()
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
        $currentBalance = $totalIncome - $totalExpenses;
        
        // Monthly statistics
        $monthlyIncome = (clone $incomeQuery)
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount') ?? 0;
        
        $monthlyExpenses = (clone $expenseQuery)
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount') ?? 0;
        
        $monthlyNet = $monthlyIncome - $monthlyExpenses;
        
        // Pending receipts
        $pendingReceipts = 18; // Would need receipt model
        
        return view('dashboards.treasurer', compact(
            'totalIncome',
            'totalExpenses',
            'currentBalance',
            'monthlyIncome',
            'monthlyExpenses',
            'monthlyNet',
            'pendingReceipts'
        ));
    }
    
    private function churchLeaderDashboard()
    {
        $communityMembers = 156; // Would need community assignment model
        $activeMembers = 142;
        $groupActivities = 8;
        $attendanceRate = 82;
        $outreachPrograms = 5;
        
        return view('dashboards.church-leader', compact(
            'communityMembers',
            'activeMembers',
            'groupActivities',
            'attendanceRate',
            'outreachPrograms'
        ));
    }
    
    private function spiritualCoordinatorDashboard()
    {
        // Spiritual coordinator specific data
        $assignedProgramme = 'BBICT'; // Would come from user assignment
        $programmeMembers = Parishioner::where('academic_programme', $assignedProgramme)->count();
        $spiritualGroups = 6;
        $upcomingEvents = 3;
        
        return view('dashboards.spiritual-coordinator', compact(
            'assignedProgramme',
            'programmeMembers',
            'spiritualGroups',
            'upcomingEvents'
        ));
    }
    
    private function groupLeaderDashboard()
    {
        // Group leader specific data
        $groupMembers = 25; // Would come from group assignment
        $attendanceRate = 85;
        $upcomingMeetings = 2;
        $activePrograms = 4;
        
        return view('dashboards.group-leader', compact(
            'groupMembers',
            'attendanceRate',
            'upcomingMeetings',
            'activePrograms'
        ));
    }
    
    private function eventChairpersonDashboard()
    {
        // Event chairperson specific data
        $managedEvents = 3; // Would come from event assignment
        $totalAttendees = 156;
        $upcomingEvents = 2;
        $pendingTasks = 8;
        
        return view('dashboards.event-chairperson', compact(
            'managedEvents',
            'totalAttendees',
            'upcomingEvents',
            'pendingTasks'
        ));
    }
    
    private function memberDashboard()
    {
        $user = auth()->user();
        
        // Member specific data
        $profileCompletion = 85; // Would calculate from user profile
        $contributions = 45000; // Would get from user's contribution records
        $certificates = \App\Models\Certificate::where('recipient_name', 'like', '%' . $user->name . '%')->count();
        $upcomingEvents = 5;
        
        return view('dashboards.member', compact(
            'profileCompletion',
            'contributions',
            'certificates',
            'upcomingEvents'
        ));
    }
}

