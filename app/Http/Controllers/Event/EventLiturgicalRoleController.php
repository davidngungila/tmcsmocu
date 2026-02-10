<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventLiturgicalRole;
use App\Models\Parishioner;
use Illuminate\Http\Request;

class EventLiturgicalRoleController extends Controller
{
    public function index($eventId)
    {
        $event = Event::with(['liturgicalRoles.parishioner', 'liturgicalRoles.user', 'liturgicalRoles.schedule'])
            ->findOrFail($eventId);
        $parishioners = Parishioner::orderBy('first_name')->get();
        
        return view('events.volunteers.index', compact('event', 'parishioners'));
    }

    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        
        $validated = $request->validate([
            'parishioner_id' => 'nullable|exists:parishioners,id',
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'parish' => 'nullable|string|max:255',
            'role_type' => 'required|in:reader,choir,server,usher,media,security,protocol,other',
            'schedule_id' => 'nullable|exists:event_schedules,id',
            'assigned_time' => 'nullable|date',
            'notes' => 'nullable|string',
            'confirmed' => 'nullable|boolean',
        ]);

        $validated['event_id'] = $eventId;
        $validated['confirmed'] = $request->has('confirmed');

        EventLiturgicalRole::create($validated);

        return redirect()->route('events.volunteers.index', $eventId)
            ->with('success', 'Volunteer role assigned successfully.');
    }

    public function update(Request $request, $eventId, $id)
    {
        $role = EventLiturgicalRole::where('event_id', $eventId)->findOrFail($id);
        
        $validated = $request->validate([
            'parishioner_id' => 'nullable|exists:parishioners,id',
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'parish' => 'nullable|string|max:255',
            'role_type' => 'required|in:reader,choir,server,usher,media,security,protocol,other',
            'schedule_id' => 'nullable|exists:event_schedules,id',
            'assigned_time' => 'nullable|date',
            'notes' => 'nullable|string',
            'confirmed' => 'nullable|boolean',
        ]);

        $validated['confirmed'] = $request->has('confirmed');

        $role->update($validated);

        return redirect()->route('events.volunteers.index', $eventId)
            ->with('success', 'Volunteer role updated successfully.');
    }

    public function destroy($eventId, $id)
    {
        $role = EventLiturgicalRole::where('event_id', $eventId)->findOrFail($id);
        $role->delete();

        return redirect()->route('events.volunteers.index', $eventId)
            ->with('success', 'Volunteer role removed successfully.');
    }
}

