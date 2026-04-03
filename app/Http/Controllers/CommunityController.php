<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Parishioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        // Statistics
        $totalCommunities = Community::count();
        $activeCommunities = Community::where('is_active', true)->count();
        $totalMembers = Parishioner::where('status', 'active')->count();
        $totalStudents = Parishioner::students()->where('status', 'active')->count();
        
        // Query with filters
        $query = Community::withCount(['parishioners', 'studentParishioners']);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('academic_programme', 'like', "%{$search}%");
            });
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
            'totalStudents'
        ));
    }

    public function create()
    {
        return view('communities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_programme' => 'required|string|max:255|unique:communities,academic_programme',
            'description' => 'nullable|string',
            'chairperson_name' => 'nullable|string|max:255',
            'chairperson_email' => 'nullable|email|max:255',
            'chairperson_phone' => 'nullable|string|max:20',
            'secretary_name' => 'nullable|string|max:255',
            'secretary_email' => 'nullable|email|max:255',
            'secretary_phone' => 'nullable|string|max:20',
            'treasurer_name' => 'nullable|string|max:255',
            'treasurer_email' => 'nullable|email|max:255',
            'treasurer_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $community = Community::create($validated);

        return redirect()
            ->route('communities.index')
            ->with('success', 'Community created successfully.');
    }

    public function show(Community $community)
    {
        $community->load([
            'parishioners' => function ($query) {
                $query->where('status', 'active')->latest();
            },
            'studentParishioners' => function ($query) {
                $query->where('status', 'active')->latest();
            }
        ]);

        $memberStats = [
            'total_members' => $community->parishioners()->where('status', 'active')->count(),
            'students' => $community->studentParishioners()->count(),
            'employees' => $community->parishioners()->where('member_type', 'employee')->where('status', 'active')->count(),
            'children' => $community->parishioners()->where('member_type', 'child')->where('status', 'active')->count(),
            'alumni' => $community->parishioners()->where('status', 'alumni')->count(),
        ];

        return view('communities.show', compact('community', 'memberStats'));
    }

    public function edit(Community $community)
    {
        return view('communities.edit', compact('community'));
    }

    public function update(Request $request, Community $community)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_programme' => [
                'required',
                'string',
                'max:255',
                Rule::unique('communities', 'academic_programme')->ignore($community->id),
            ],
            'description' => 'nullable|string',
            'chairperson_name' => 'nullable|string|max:255',
            'chairperson_email' => 'nullable|email|max:255',
            'chairperson_phone' => 'nullable|string|max:20',
            'secretary_name' => 'nullable|string|max:255',
            'secretary_email' => 'nullable|email|max:255',
            'secretary_phone' => 'nullable|string|max:20',
            'treasurer_name' => 'nullable|string|max:255',
            'treasurer_email' => 'nullable|email|max:255',
            'treasurer_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $community->update($validated);

        return redirect()
            ->route('communities.index')
            ->with('success', 'Community updated successfully.');
    }

    public function destroy(Community $community)
    {
        // Check if community has members
        if ($community->parishioners()->count() > 0) {
            return redirect()
                ->route('communities.index')
                ->with('error', 'Cannot delete community with members. Please reassign or remove members first.');
        }

        $community->delete();

        return redirect()
            ->route('communities.index')
            ->with('success', 'Community deleted successfully.');
    }
}
