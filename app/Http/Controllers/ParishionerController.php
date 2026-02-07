<?php

namespace App\Http\Controllers;

use App\Models\Parishioner;
use Illuminate\Http\Request;

class ParishionerController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'wanafunzi');
        
        $parishioners = Parishioner::where('type', $type)
            ->latest()
            ->paginate(20);
        
        return view('parishioners.index', compact('parishioners', 'type'));
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
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'occupation' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Parishioner::create($validated);

        return redirect()->route('parishioners.index', ['type' => $validated['type']])
            ->with('success', 'Parishioner registered successfully.');
    }

    public function show($id)
    {
        $parishioner = Parishioner::with(['communities', 'apostolicGroups'])->findOrFail($id);
        return view('parishioners.show', compact('parishioner'));
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
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'occupation' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

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
