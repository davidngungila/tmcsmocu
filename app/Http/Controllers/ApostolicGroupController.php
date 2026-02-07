<?php

namespace App\Http\Controllers;

use App\Models\ApostolicGroup;
use App\Models\Parishioner;
use Illuminate\Http\Request;

class ApostolicGroupController extends Controller
{
    public function index()
    {
        $groups = ApostolicGroup::with('leader')->latest()->paginate(20);
        return view('apostolic-groups.index', compact('groups'));
    }

    public function create()
    {
        $parishioners = Parishioner::where('is_active', true)->get();
        return view('apostolic-groups.create', compact('parishioners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:parishioners,id',
        ]);

        ApostolicGroup::create($validated);

        return redirect()->route('apostolic-groups.index')
            ->with('success', 'Apostolic group created successfully.');
    }

    public function show($id)
    {
        $group = ApostolicGroup::with(['leader', 'parishioners'])->findOrFail($id);
        return view('apostolic-groups.show', compact('group'));
    }

    public function edit($id)
    {
        $group = ApostolicGroup::findOrFail($id);
        $parishioners = Parishioner::where('is_active', true)->get();
        return view('apostolic-groups.edit', compact('group', 'parishioners'));
    }

    public function update(Request $request, $id)
    {
        $group = ApostolicGroup::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:parishioners,id',
            'is_active' => 'boolean',
        ]);

        $group->update($validated);

        return redirect()->route('apostolic-groups.index')
            ->with('success', 'Apostolic group updated successfully.');
    }

    public function destroy($id)
    {
        $group = ApostolicGroup::findOrFail($id);
        $group->delete();

        return redirect()->route('apostolic-groups.index')
            ->with('success', 'Apostolic group deleted successfully.');
    }
}
