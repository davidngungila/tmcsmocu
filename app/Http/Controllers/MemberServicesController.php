<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Certificate;
use App\Models\Contribution;
use App\Models\Event;

class MemberServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show member's contributions
     */
    public function contributions()
    {
        $user = auth()->user();
        $contributions = Contribution::where('user_id', $user->id)
            ->with(['financialYear', 'type'])
            ->orderBy('date', 'desc')
            ->paginate(20);

        $totalContributions = Contribution::where('user_id', $user->id)->sum('amount');
        $thisYearContributions = Contribution::where('user_id', $user->id)
            ->whereYear('date', now()->year)
            ->sum('amount');

        return view('member-services.contributions', compact(
            'contributions',
            'totalContributions',
            'thisYearContributions'
        ));
    }

    /**
     * Show member's events
     */
    public function events()
    {
        $user = auth()->user();
        $events = Event::whereHas('attendees', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['attendees' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->orderBy('start_date', 'desc')
        ->paginate(15);

        $upcomingEvents = Event::whereHas('attendees', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('start_date', '>=', now())
        ->orderBy('start_date', 'asc')
        ->limit(5)
        ->get();

        $pastEvents = Event::whereHas('attendees', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('start_date', '<', now())
        ->orderBy('start_date', 'desc')
        ->limit(5)
        ->get();

        return view('member-services.events', compact(
            'events',
            'upcomingEvents',
            'pastEvents'
        ));
    }

    /**
     * Show member directory
     */
    public function directory(Request $request)
    {
        $query = User::with('role')
            ->where('id', '!=', auth()->id())
            ->whereNotNull('role_id');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $members = $query->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $roles = \App\Models\Role::orderBy('display_name')->get();

        return view('member-services.directory', compact('members', 'roles'));
    }

    /**
     * Show member profile details
     */
    public function profileDetails($id)
    {
        $member = User::with(['role', 'activityLogs' => function($query) {
            $query->latest()->limit(10);
        }])->findOrFail($id);

        // Check if user has permission to view (basic member info is public)
        if (!auth()->user()->canViewMemberProfile($member)) {
            abort(403, 'You do not have permission to view this profile.');
        }

        $contributions = Contribution::where('user_id', $member->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        $certificates = Certificate::where('user_id', $member->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('member-services.profile-details', compact(
            'member',
            'contributions',
            'certificates'
        ));
    }
}
