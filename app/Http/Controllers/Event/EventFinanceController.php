<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventFinanceController extends Controller
{
    public function index($eventId)
    {
        $event = Event::with(['finances.parishioner'])->findOrFail($eventId);
        return view('events.finances.index', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        // Implementation for storing finance
        return redirect()->back()->with('success', 'Finance record created successfully.');
    }

    public function update(Request $request, $eventId, $id)
    {
        // Implementation for updating finance
        return redirect()->back()->with('success', 'Finance record updated successfully.');
    }
}
