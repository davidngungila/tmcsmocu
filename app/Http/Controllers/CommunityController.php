<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Parishioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        // Statistics
        $totalCommunities = Community::count();
        $activeCommunities = Community::where('is_active', true)->count();
        $totalMembers = \DB::table('parishioner_community')
            ->where('is_active', true)
            ->count();
        $communitiesWithLeaders = Community::whereNotNull('leader_id')->count();
        
        // Query with filters
        $query = Community::with(['leader', 'parishioners']);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }
        
        $communities = $query->latest()->paginate(20)->withQueryString();
        
        return view('communities.index', compact(
            'communities',
            'totalCommunities',
            'activeCommunities',
            'totalMembers',
            'communitiesWithLeaders'
        ));
    }

    public function create()
    {
        $parishioners = Parishioner::where('is_active', true)->get();
        return view('communities.create', compact('parishioners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:parishioners,id',
        ]);

        Community::create($validated);

        return redirect()->route('communities.index')
            ->with('success', 'Community created successfully.');
    }

    public function show($id)
    {
        $community = Community::with(['leader', 'parishioners'])->findOrFail($id);
        return view('communities.show', compact('community'));
    }

    public function edit($id)
    {
        $community = Community::findOrFail($id);
        $parishioners = Parishioner::where('is_active', true)->get();
        return view('communities.edit', compact('community', 'parishioners'));
    }

    public function update(Request $request, $id)
    {
        $community = Community::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:parishioners,id',
            'is_active' => 'boolean',
        ]);

        $community->update($validated);

        return redirect()->route('communities.index')
            ->with('success', 'Community updated successfully.');
    }

    public function destroy($id)
    {
        $community = Community::findOrFail($id);
        $community->delete();

        return redirect()->route('communities.index')
            ->with('success', 'Community deleted successfully.');
    }
}
