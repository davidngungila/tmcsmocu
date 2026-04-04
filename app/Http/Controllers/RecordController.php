<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        return view('records.index');
    }

    public function create()
    {
        return view('records.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('records.index')->with('success', 'Record created successfully!');
    }

    public function show($id)
    {
        return view('records.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('records.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('records.index')->with('success', 'Record updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('records.index')->with('success', 'Record deleted successfully!');
    }
}
