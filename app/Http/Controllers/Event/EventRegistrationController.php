<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function index($eventId)
    {
        $event = Event::with(['registrations.parishioner'])->findOrFail($eventId);
        return view('events.registrations.index', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        // Implementation for storing registration
        return redirect()->back()->with('success', 'Registration created successfully.');
    }

    public function update(Request $request, $eventId, $id)
    {
        // Implementation for updating registration
        return redirect()->back()->with('success', 'Registration updated successfully.');
    }
    
    /**
     * Show event registration form.
     */
    public function register()
    {
        $events = Event::where('start_date', '>=', today())
            ->where('is_active', true)
            ->orderBy('start_date', 'asc')
            ->get();
            
        return view('events.register', compact('events'));
    }
    
    /**
     * Store event registration.
     */
    public function registerStore(Request $request)
    {
        // Implementation for event registration
        return redirect()->route('events.register')->with('success', 'Event registration successful!');
    }
}
