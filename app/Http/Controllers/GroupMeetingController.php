<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupMeetingController extends Controller
{
    public function index()
    {
        return view('groups.meetings.index');
    }

    public function create()
    {
        return view('groups.meetings.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('groups.meetings')->with('success', 'Meeting created successfully!');
    }

    public function show($id)
    {
        return view('groups.meetings.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('groups.meetings.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('groups.meetings')->with('success', 'Meeting updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('groups.meetings')->with('success', 'Meeting deleted successfully!');
    }
}
