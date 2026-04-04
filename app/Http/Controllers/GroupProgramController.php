<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupProgramController extends Controller
{
    public function index()
    {
        return view('groups.programs.index');
    }

    public function create()
    {
        return view('groups.programs.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('groups.programs')->with('success', 'Program created successfully!');
    }

    public function show($id)
    {
        return view('groups.programs.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('groups.programs.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('groups.programs')->with('success', 'Program updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('groups.programs')->with('success', 'Program deleted successfully!');
    }
}
