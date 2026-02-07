<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\SacramentSale;
use Illuminate\Http\Request;

class SacramentController extends Controller
{
    public function index()
    {
        $sacraments = SacramentSale::with('creator')
            ->latest()
            ->paginate(20);
        
        // Get all sacraments for statistics (not paginated)
        $allSacraments = SacramentSale::all();
        
        return view('finance.sacraments.index', compact('sacraments', 'allSacraments'));
    }

    public function create()
    {
        return view('finance.sacraments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sacrament_type' => 'required|in:ubatizo,kipaimara,ndoa,misa_maalum',
            'customer_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        SacramentSale::create($validated);

        return redirect()->route('finance.sacraments.index')
            ->with('success', 'Sacrament sale recorded successfully.');
    }

    public function show($id)
    {
        $sacrament = SacramentSale::findOrFail($id);
        return view('finance.sacraments.show', compact('sacrament'));
    }

    public function edit($id)
    {
        $sacrament = SacramentSale::findOrFail($id);
        return view('finance.sacraments.edit', compact('sacrament'));
    }

    public function update(Request $request, $id)
    {
        $sacrament = SacramentSale::findOrFail($id);

        $validated = $request->validate([
            'sacrament_type' => 'required|in:ubatizo,kipaimara,ndoa,misa_maalum',
            'customer_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $sacrament->update($validated);

        return redirect()->route('finance.sacraments.index')
            ->with('success', 'Sacrament sale updated successfully.');
    }

    public function destroy($id)
    {
        $sacrament = SacramentSale::findOrFail($id);
        $sacrament->delete();

        return redirect()->route('finance.sacraments.index')
            ->with('success', 'Sacrament sale deleted successfully.');
    }
}
