<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventMediaController extends Controller
{
    public function index($eventId)
    {
        $event = Event::with('media')->findOrFail($eventId);
        return view('events.media.index', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        // Implementation for storing media
        return redirect()->back()->with('success', 'Media uploaded successfully.');
    }

    public function destroy($eventId, $id)
    {
        // Implementation for deleting media
        return redirect()->back()->with('success', 'Media deleted successfully.');
    }
}
