<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::latest()->paginate(20);
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:majengo,vifaa,samani,vifaa_vya_ibada,nyingine',
            'description' => 'nullable|string',
            'value' => 'nullable|numeric|min:0',
            'acquisition_date' => 'nullable|date',
            'status' => 'required|in:inayotumika,iliyoharibika,inayohitaji_matengenezo,imepotea',
            'location' => 'nullable|string',
            'maintenance_notes' => 'nullable|string',
        ]);

        Asset::create($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Asset registered successfully.');
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.show', compact('asset'));
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:majengo,vifaa,samani,vifaa_vya_ibada,nyingine',
            'description' => 'nullable|string',
            'value' => 'nullable|numeric|min:0',
            'acquisition_date' => 'nullable|date',
            'status' => 'required|in:inayotumika,iliyoharibika,inayohitaji_matengenezo,imepotea',
            'location' => 'nullable|string',
            'maintenance_notes' => 'nullable|string',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Asset updated successfully.');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('assets.index')
            ->with('success', 'Asset deleted successfully.');
    }
}
