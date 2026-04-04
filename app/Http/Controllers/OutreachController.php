<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutreachController extends Controller
{
    public function index()
    {
        return view('outreach.index');
    }

    public function create()
    {
        return view('outreach.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('outreach.index')->with('success', 'Outreach created successfully!');
    }

    public function show($id)
    {
        return view('outreach.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('outreach.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('outreach.index')->with('success', 'Outreach updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('outreach.index')->with('success', 'Outreach deleted successfully!');
    }
}
