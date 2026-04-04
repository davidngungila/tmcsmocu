<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('groups.index');
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('groups.index')->with('success', 'Group created successfully!');
    }

    public function show($id)
    {
        return view('groups.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('groups.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('groups.index')->with('success', 'Group updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully!');
    }
    
    public function join()
    {
        return view('groups.join');
    }
    
    public function joinStore(Request $request)
    {
        return redirect()->route('groups.index')->with('success', 'Successfully joined group!');
    }
}
