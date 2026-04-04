<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventTaskController extends Controller
{
    public function index()
    {
        return view('events.tasks.index');
    }

    public function create()
    {
        return view('events.tasks.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('events.tasks')->with('success', 'Task created successfully!');
    }

    public function show($id)
    {
        return view('events.tasks.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('events.tasks.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('events.tasks')->with('success', 'Task updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('events.tasks')->with('success', 'Task deleted successfully!');
    }
}
