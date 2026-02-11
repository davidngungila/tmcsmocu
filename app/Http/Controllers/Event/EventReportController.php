<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventReportController extends Controller
{
    public function index($eventId)
    {
        $event = Event::with([
            'attendances.parishioner',
            'registrations.parishioner',
            'finances.parishioner',
            'liturgicalRoles.parishioner',
            'media'
        ])->findOrFail($eventId);
        
        return view('events.reports.index', compact('event'));
    }
}
