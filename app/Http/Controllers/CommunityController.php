<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Parishioner;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::with('leader')->latest()->paginate(20);
        return view('communities.index', compact('communities'));
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
