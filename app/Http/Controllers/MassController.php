<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MassController extends Controller
{
    /**
     * Display a listing of masses.
     */
    public function index()
    {
        return view('masses.index');
    }

    /**
     * Show the form for creating a new mass.
     */
    public function create()
    {
        return view('masses.create');
    }

    /**
     * Store a newly created mass in storage.
     */
    public function store(Request $request)
    {
        // Implementation pending
        return redirect()->route('masses.index')->with('success', 'Mass created successfully!');
    }

    /**
     * Display the specified mass.
     */
    public function show($id)
    {
        return view('masses.show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified mass.
     */
    public function edit($id)
    {
        return view('masses.edit', ['id' => $id]);
    }

    /**
     * Update the specified mass in storage.
     */
    public function update(Request $request, $id)
    {
        // Implementation pending
        return redirect()->route('masses.index')->with('success', 'Mass updated successfully!');
    }

    /**
     * Remove the specified mass from storage.
     */
    public function destroy($id)
    {
        // Implementation pending
        return redirect()->route('masses.index')->with('success', 'Mass deleted successfully!');
    }
}
