<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    public function index()
    {
        return view('communications.index');
    }

    public function create()
    {
        return view('communications.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('communications.index')->with('success', 'Communication created successfully!');
    }

    public function show($id)
    {
        return view('communications.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('communications.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('communications.index')->with('success', 'Communication updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('communications.index')->with('success', 'Communication deleted successfully!');
    }
}
