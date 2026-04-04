<?php

namespace App\Http\Controllers;

use App\Models\Parishioner;
use Illuminate\Http\Request;

class ParishionerController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');
        
        // Statistics for all members
        $totalParishioners = Parishioner::count();
        $activeParishioners = Parishioner::where('is_active', true)->count();
        $inactiveParishioners = Parishioner::where('is_active', false)->count();
        
        // Member type counts - use member_type if available, fallback to type
        $studentCount = Parishioner::where('member_type', 'student')->count();
        $employeeCount = Parishioner::where('member_type', 'employee')->count();
        $childCount = Parishioner::where('member_type', 'child')->count();
        
        // Gender counts
        $maleParishioners = Parishioner::where('gender', 'male')->count();
        $femaleParishioners = Parishioner::where('gender', 'female')->count();
        
        // Query with filters
        $query = Parishioner::query();
        
        // Type filter
        if ($type) {
            $query->where('member_type', $type);
        }
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }
        
        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->get('gender'));
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }
        
        // Academic programme filter
        if ($request->filled('academic_programme')) {
            $query->where('academic_programme', $request->get('academic_programme'));
        }
        
        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->get('department'));
        }
        
        // Year of study filter
        if ($request->filled('year_of_study')) {
            $query->where('year_of_study', $request->get('year_of_study'));
        }
        
        $parishioners = $query->latest()->paginate(20)->withQueryString();
        
        return view('parishioners.index', compact(
            'parishioners', 
            'type',
            'totalParishioners',
            'activeParishioners',
            'inactiveParishioners',
            'studentCount',
            'employeeCount',
            'childCount',
            'maleParishioners',
            'femaleParishioners'
        ));
    }

    public function create()
    {
        return view('parishioners.create');
    }

    /**
     * Show import form
     */
    public function import()
    {
        return view('parishioners.import');
    }

    /**
     * Handle import submission
     */
    public function importStore(Request $request)
    {
        // TODO: Implement import logic
        return redirect()->route('parishioners.index')->with('success', 'Import completed successfully!');
    }

    /**
     * Show member types configuration
     */
    public function memberTypes()
    {
        $studentCount = Parishioner::where('member_type', 'student')->count();
        $employeeCount = Parishioner::where('member_type', 'employee')->count();
        $childCount = Parishioner::where('member_type', 'child')->count();
        
        $activeStudentCount = Parishioner::where('member_type', 'student')->where('is_active', true)->count();
        $activeEmployeeCount = Parishioner::where('member_type', 'employee')->where('is_active', true)->count();
        $activeChildCount = Parishioner::where('member_type', 'child')->where('is_active', true)->count();
        
        return view('parishioners.member-types', compact(
            'studentCount', 'employeeCount', 'childCount',
            'activeStudentCount', 'activeEmployeeCount', 'activeChildCount'
        ));
    }

    /**
     * Show manage members page
     */
    public function manage()
    {
        $totalMembers = Parishioner::count();
        $activeMembers = Parishioner::where('is_active', true)->count();
        $inactiveMembers = Parishioner::where('is_active', false)->count();
        $newThisMonth = Parishioner::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $recentMembers = Parishioner::latest()->take(5)->get();
        
        return view('parishioners.manage', compact(
            'totalMembers', 'activeMembers', 'inactiveMembers', 'newThisMonth', 'recentMembers'
        ));
    }

    /**
     * Export parishioners
     */
    public function export(Request $request)
    {
        // TODO: Implement export logic
        return response()->download('export.xlsx');
    }

    /**
     * Bulk activate parishioners
     */
    public function bulkActivate(Request $request)
    {
        $ids = $request->input('ids', []);
        Parishioner::whereIn('id', $ids)->update(['is_active' => true]);
        
        return back()->with('success', 'Members activated successfully!');
    }

    /**
     * Bulk deactivate parishioners
     */
    public function bulkDeactivate(Request $request)
    {
        $ids = $request->input('ids', []);
        Parishioner::whereIn('id', $ids)->update(['is_active' => false]);
        
        return back()->with('success', 'Members deactivated successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:wanafunzi,wafanyakazi',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'occupation' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);
        
        // Set contact_number from phone if provided
        if (isset($validated['phone']) && !isset($validated['contact_number'])) {
            $validated['contact_number'] = $validated['phone'];
        }

        Parishioner::create($validated);

        return redirect()->route('parishioners.index', ['type' => $validated['type']])
            ->with('success', 'Parishioner registered successfully.');
    }

    public function show($id)
    {
        // Only load relationships that we know exist
        $parishioner = Parishioner::with([
            'community', 
            'leaderPositions',
            'financialYears'
        ])->findOrFail($id);
        
        // Try to load other relationships separately to avoid errors
        try {
            $parishioner->load('spiritualGroups');
        } catch (\Exception $e) {
            // Skip if relationship doesn't exist
        }
        try {
            $parishioner->load('events');
        } catch (\Exception $e) {
            // Skip if relationship doesn't exist
        }
        try {
            $parishioner->load('eventAttendances.event');
        } catch (\Exception $e) {
            // Skip if relationship doesn't exist
        }
        
        // Get statistics
        try {
            $communitiesCount = $parishioner->spiritualGroups()->wherePivot('is_active', true)->count();
        } catch (\Exception $e) {
            $communitiesCount = 0;
        }
        try {
            $groupsCount = $parishioner->spiritualGroups()->wherePivot('is_active', true)->count();
        } catch (\Exception $e) {
            $groupsCount = 0;
        }
        try {
            $eventsAttended = $parishioner->eventAttendances()->where('attended', true)->count();
        } catch (\Exception $e) {
            $eventsAttended = 0;
        }
        try {
            $isLeader = $parishioner->leaderPositions()->where('is_active', true)->exists();
        } catch (\Exception $e) {
            $isLeader = false;
        }
        try {
            $totalEvents = $parishioner->events()->count();
        } catch (\Exception $e) {
            $totalEvents = 0;
        }
        
        // Get financial contributions
        $contributions = \App\Models\FinanceTransaction::where('parishioner_id', $parishioner->id)
            ->where('type', 'income')
            ->latest()
            ->take(10)
            ->get();
        $totalContributions = \App\Models\FinanceTransaction::where('parishioner_id', $parishioner->id)
            ->where('type', 'income')
            ->sum('amount');
        
        // Get recent activities
        try {
            $recentEvents = $parishioner->eventAttendances()->with('event')->latest('checked_in_at')->limit(5)->get();
        } catch (\Exception $e) {
            $recentEvents = collect([]);
        }
        try {
            $recentCommunities = $parishioner->spiritualGroups()->wherePivot('is_active', true)->latest('parishioner_apostolic_group.joined_at')->limit(5)->get();
        } catch (\Exception $e) {
            $recentCommunities = collect([]);
        }
        try {
            $recentGroups = $parishioner->spiritualGroups()->wherePivot('is_active', true)->latest('parishioner_apostolic_group.joined_at')->limit(5)->get();
        } catch (\Exception $e) {
            $recentGroups = collect([]);
        }
        
        // Get active communities and groups
        try {
            $activeCommunities = $parishioner->spiritualGroups()->wherePivot('is_active', true)->get();
        } catch (\Exception $e) {
            $activeCommunities = collect([]);
        }
        try {
            $activeGroups = $parishioner->spiritualGroups()->wherePivot('is_active', true)->get();
        } catch (\Exception $e) {
            $activeGroups = collect([]);
        }
        
        // Get leader positions
        try {
            $leaderPositions = $parishioner->leaderPositions()->where('is_active', true)->get();
        } catch (\Exception $e) {
            $leaderPositions = collect([]);
        }
        
        // Get current financial year status
        $currentYearStatus = $parishioner->getCurrentYearStatus();
        
        return view('parishioners.show', compact(
            'parishioner',
            'communitiesCount',
            'groupsCount',
            'eventsAttended',
            'isLeader',
            'totalEvents',
            'recentEvents',
            'recentCommunities',
            'recentGroups',
            'activeCommunities',
            'activeGroups',
            'leaderPositions',
            'contributions',
            'totalContributions',
            'currentYearStatus'
        ));
    }

    public function edit($id)
    {
        $parishioner = Parishioner::findOrFail($id);
        return view('parishioners.edit', compact('parishioner'));
    }

    public function update(Request $request, $id)
    {
        $parishioner = Parishioner::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:wanafunzi,wafanyakazi',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'occupation' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);
        
        // Set contact_number from phone if provided
        if (isset($validated['phone']) && !isset($validated['contact_number'])) {
            $validated['contact_number'] = $validated['phone'];
        }

        $parishioner->update($validated);

        return redirect()->route('parishioners.index', ['type' => $parishioner->type])
            ->with('success', 'Parishioner updated successfully.');
    }

    public function destroy($id)
    {
        $parishioner = Parishioner::findOrFail($id);
        $parishioner->delete();

        return redirect()->route('parishioners.index', ['type' => $parishioner->type])
            ->with('success', 'Parishioner deleted successfully.');
    }
    
    /**
     * Display parishioner directory.
     */
    public function directory()
    {
        $parishioners = Parishioner::orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('middle_name', 'asc')
            ->paginate(20);
        return view('parishioners.directory', compact('parishioners'));
    }
}
