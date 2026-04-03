<?php

namespace App\Http\Controllers;

use App\Models\SpiritualGroup;
use App\Models\Parishioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SpiritualGroupController extends Controller
{
    public function index(Request $request)
    {
        // Statistics
        $totalGroups = SpiritualGroup::count();
        $activeGroups = SpiritualGroup::where('is_active', true)->count();
        $totalMembers = DB::table('parishioner_spiritual_group')
            ->where('role', 'member')
            ->count();
        $totalLeaders = DB::table('parishioner_spiritual_group')
            ->where('role', 'leader')
            ->count();
        
        // Query with filters
        $query = SpiritualGroup::withCount(['parishioners', 'members', 'leaders']);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }
        
        $groups = $query->latest()->paginate(20)->withQueryString();
        
        return view('spiritual-groups.index', compact(
            'groups',
            'totalGroups',
            'activeGroups',
            'totalMembers',
            'totalLeaders'
        ));
    }

    public function create()
    {
        $types = SpiritualGroup::getTypes();
        $parishioners = Parishioner::where('status', 'active')->get();
        return view('spiritual-groups.create', compact('types', 'parishioners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255|in:' . implode(',', array_keys(SpiritualGroup::getTypes())),
            'description' => 'nullable|string',
            'chairperson_name' => 'nullable|string|max:255',
            'chairperson_email' => 'nullable|email|max:255',
            'chairperson_phone' => 'nullable|string|max:20',
            'deputy_chairperson_name' => 'nullable|string|max:255',
            'deputy_chairperson_email' => 'nullable|email|max:255',
            'deputy_chairperson_phone' => 'nullable|string|max:20',
            'secretary_name' => 'nullable|string|max:255',
            'secretary_email' => 'nullable|email|max:255',
            'secretary_phone' => 'nullable|string|max:20',
            'treasurer_name' => 'nullable|string|max:255',
            'treasurer_email' => 'nullable|email|max:255',
            'treasurer_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $group = SpiritualGroup::create($validated);

        return redirect()
            ->route('spiritual-groups.index')
            ->with('success', 'Spiritual group created successfully.');
    }

    public function show(SpiritualGroup $group)
    {
        $group->load([
            'parishioners' => function ($query) {
                $query->withPivot('role', 'joined_at')->latest();
            },
            'members' => function ($query) {
                $query->wherePivot('role', 'member')->latest();
            },
            'leaders' => function ($query) {
                $query->wherePivot('role', 'leader')->latest();
            }
        ]);

        $memberStats = [
            'total_members' => $group->parishioners()->count(),
            'members' => $group->members()->count(),
            'leaders' => $group->leaders()->count(),
        ];

        return view('spiritual-groups.show', compact('group', 'memberStats'));
    }

    public function edit(SpiritualGroup $group)
    {
        $types = SpiritualGroup::getTypes();
        $parishioners = Parishioner::where('status', 'active')->get();
        return view('spiritual-groups.edit', compact('group', 'types', 'parishioners'));
    }

    public function update(Request $request, SpiritualGroup $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255|in:' . implode(',', array_keys(SpiritualGroup::getTypes())),
            'description' => 'nullable|string',
            'chairperson_name' => 'nullable|string|max:255',
            'chairperson_email' => 'nullable|email|max:255',
            'chairperson_phone' => 'nullable|string|max:20',
            'deputy_chairperson_name' => 'nullable|string|max:255',
            'deputy_chairperson_email' => 'nullable|email|max:255',
            'deputy_chairperson_phone' => 'nullable|string|max:20',
            'secretary_name' => 'nullable|string|max:255',
            'secretary_email' => 'nullable|email|max:255',
            'secretary_phone' => 'nullable|string|max:20',
            'treasurer_name' => 'nullable|string|max:255',
            'treasurer_email' => 'nullable|email|max:255',
            'treasurer_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $group->update($validated);

        return redirect()
            ->route('spiritual-groups.index')
            ->with('success', 'Spiritual group updated successfully.');
    }

    public function destroy(SpiritualGroup $group)
    {
        // Check if group has members
        if ($group->parishioners()->count() > 0) {
            return redirect()
                ->route('spiritual-groups.index')
                ->with('error', 'Cannot delete group with members. Please remove members first.');
        }

        $group->delete();

        return redirect()
            ->route('spiritual-groups.index')
            ->with('success', 'Spiritual group deleted successfully.');
    }

    public function addMember(Request $request, SpiritualGroup $group)
    {
        $validated = $request->validate([
            'parishioner_id' => 'required|exists:parishioners,id',
            'role' => 'required|in:member,leader',
        ]);

        // Check if member already exists in group
        $exists = $group->parishioners()
            ->where('parishioner_id', $validated['parishioner_id'])
            ->exists();

        if ($exists) {
            return back()
                ->with('error', 'Member already exists in this group.');
        }

        $group->parishioners()->attach($validated['parishioner_id'], [
            'role' => $validated['role'],
            'joined_at' => now(),
        ]);

        return back()
            ->with('success', 'Member added to group successfully.');
    }

    public function removeMember(Request $request, SpiritualGroup $group, Parishioner $parishioner)
    {
        $group->parishioners()->detach($parishioner->id);

        return back()
            ->with('success', 'Member removed from group successfully.');
    }
}
