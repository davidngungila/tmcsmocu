<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Models\Parishioner;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::with('parishioner')->where('is_active', true)->latest()->paginate(20);
        return view('leaders.index', compact('leaders'));
    }

    public function create()
    {
        $parishioners = Parishioner::where('is_active', true)->get();
        return view('leaders.create', compact('parishioners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parishioner_id' => 'required|exists:parishioners,id',
            'position' => 'required|string|max:255',
            'responsibilities' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        Leader::create($validated);

        return redirect()->route('leaders.index')
            ->with('success', 'Leader registered successfully.');
    }

    public function show($id)
    {
        $leader = Leader::with('parishioner')->findOrFail($id);
        return view('leaders.show', compact('leader'));
    }

    public function edit($id)
    {
        $leader = Leader::findOrFail($id);
        $parishioners = Parishioner::where('is_active', true)->get();
        return view('leaders.edit', compact('leader', 'parishioners'));
    }

    public function update(Request $request, $id)
    {
        $leader = Leader::findOrFail($id);

        $validated = $request->validate([
            'parishioner_id' => 'required|exists:parishioners,id',
            'position' => 'required|string|max:255',
            'responsibilities' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $leader->update($validated);

        return redirect()->route('leaders.index')
            ->with('success', 'Leader updated successfully.');
    }

    public function destroy($id)
    {
        $leader = Leader::findOrFail($id);
        $leader->delete();

        return redirect()->route('leaders.index')
            ->with('success', 'Leader deleted successfully.');
    }
}
