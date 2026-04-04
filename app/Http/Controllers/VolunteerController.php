<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index()
    {
        return view('volunteers.index');
    }

    public function create()
    {
        return view('volunteers.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('volunteers.index')->with('success', 'Volunteer created successfully!');
    }

    public function show($id)
    {
        return view('volunteers.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('volunteers.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('volunteers.index')->with('success', 'Volunteer updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('volunteers.index')->with('success', 'Volunteer deleted successfully!');
    }
}
