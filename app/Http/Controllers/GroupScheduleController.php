<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupScheduleController extends Controller
{
    public function index()
    {
        return view('groups.schedule.index');
    }

    public function create()
    {
        return view('groups.schedule.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('groups.schedule')->with('success', 'Schedule created successfully!');
    }
}
