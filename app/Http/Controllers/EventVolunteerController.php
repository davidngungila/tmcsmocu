<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventVolunteerController extends Controller
{
    public function index()
    {
        return view('events.volunteers.index');
    }

    public function add()
    {
        return view('events.volunteers.add');
    }

    public function store(Request $request)
    {
        return redirect()->route('events.volunteers')->with('success', 'Volunteer added successfully!');
    }

    public function show($id)
    {
        return view('events.volunteers.show', ['id' => $id]);
    }

    public function remove($id)
    {
        return redirect()->route('events.volunteers')->with('success', 'Volunteer removed successfully!');
    }
}
