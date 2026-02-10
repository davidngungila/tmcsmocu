<?php

namespace App\Http\Controllers;

use App\Models\Parishioner;
use Illuminate\Http\Request;

class ParishionerController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'wanafunzi');
        
        // Statistics
        $totalParishioners = Parishioner::where('type', $type)->count();
        $activeParishioners = Parishioner::where('type', $type)->where('is_active', true)->count();
        $maleParishioners = Parishioner::where('type', $type)->where('gender', 'male')->count();
        $femaleParishioners = Parishioner::where('type', $type)->where('gender', 'female')->count();
        
        // Monthly registrations
        $monthlyRegistrations = Parishioner::where('type', $type)
            ->whereMonth('registration_date', now()->month)
            ->whereYear('registration_date', now()->year)
            ->count();
        
        // Query with filters
        $query = Parishioner::where('type', $type);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
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
        
        $parishioners = $query->latest('registration_date')->paginate(20)->withQueryString();
        
        return view('parishioners.index', compact(
            'parishioners', 
            'type',
            'totalParishioners',
            'activeParishioners',
            'maleParishioners',
            'femaleParishioners',
            'monthlyRegistrations'
        ));
    }

    public function create()
    {
        return view('parishioners.create');
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
        $parishioner = Parishioner::with([
            'communities', 
            'apostolicGroups', 
            'events', 
            'eventAttendances.event',
            'leaderPositions',
            'financialYears'
        ])->findOrFail($id);
        
        // Get statistics
        $communitiesCount = $parishioner->communities()->wherePivot('is_active', true)->count();
        $groupsCount = $parishioner->apostolicGroups()->wherePivot('is_active', true)->count();
        $eventsAttended = $parishioner->eventAttendances()->where('attended', true)->count();
        $isLeader = $parishioner->leaderPositions()->where('is_active', true)->exists();
        $totalEvents = $parishioner->events()->count();
        
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
        $recentEvents = $parishioner->eventAttendances()->with('event')->latest('checked_in_at')->limit(5)->get();
        $recentCommunities = $parishioner->communities()->wherePivot('is_active', true)->latest('parishioner_community.joined_date')->limit(5)->get();
        $recentGroups = $parishioner->apostolicGroups()->wherePivot('is_active', true)->latest('parishioner_apostolic_group.joined_date')->limit(5)->get();
        
        // Get active communities and groups
        $activeCommunities = $parishioner->communities()->wherePivot('is_active', true)->get();
        $activeGroups = $parishioner->apostolicGroups()->wherePivot('is_active', true)->get();
        
        // Get leader positions
        $leaderPositions = $parishioner->leaderPositions()->where('is_active', true)->get();
        
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
}
