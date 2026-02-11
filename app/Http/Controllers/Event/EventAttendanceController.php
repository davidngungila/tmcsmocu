<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventAttendanceController extends Controller
{
    public function index($eventId)
    {
        $event = Event::with(['attendances.parishioner', 'registrations.parishioner'])->findOrFail($eventId);
        return view('events.attendance.index', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        // Implementation for storing attendance
        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }

    public function update(Request $request, $eventId, $id)
    {
        // Implementation for updating attendance
        return redirect()->back()->with('success', 'Attendance updated successfully.');
    }
}
