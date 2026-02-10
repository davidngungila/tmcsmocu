<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('creator')
            ->withCount(['registrations', 'attendances'])
            ->latest()
            ->paginate(20);
        return view('events.index', compact('events'));
    }

    public function calendar()
    {
        return view('events.calendar');
    }

    public function create()
    {
        $leaders = Leader::where('is_active', true)->get();
        return view('events.create', compact('leaders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:misa_ya_kawaida,misa_maalum,harusi,mazishi,kipaimara,novena,adoration,ekaristi_takatifu,kwaresima,kipindi_cha_pasaka,mikutano_ya_jumuiya,semina,retreata,matukio_ya_dayosisi,misa,event_za_kanisa,charity,hija,ibada,mkesha,mkutano_wa_vijana',
            'category' => 'required|in:misa_ya_kawaida,misa_maalum,harusi,mazishi,kipaimara,novena,adoration,ekaristi_takatifu,kwaresima,kipindi_cha_pasaka,mikutano_ya_jumuiya,semina,retreata,matukio_ya_dayosisi,ibada,mkesha,mkutano_wa_vijana,misa,event_za_kanisa,charity,hija',
            'title' => 'required|string|max:255',
            'theme' => 'nullable|string|max:255',
            'spiritual_theme' => 'nullable|string',
            'scripture_readings' => 'nullable|string',
            'description' => 'nullable|string',
            'program_flow' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'parish' => 'nullable|string|max:255',
            'priest_name' => 'nullable|string|max:255',
            'liturgical_color' => 'nullable|in:white,red,green,purple,rose,black,gold',
            'community' => 'nullable|string|max:255',
            'expected_attendance' => 'nullable|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'registration_required' => 'nullable|boolean',
            'registration_deadline' => 'nullable|date|after:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'requires_approval' => 'nullable|boolean',
            'approval_level' => 'nullable|in:parish_coordinator,pastor,diocese',
            'status' => 'required|in:planned,registration_open,ongoing,completed,cancelled',
            'send_reminders' => 'nullable|boolean',
            'announcement' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        // Convert boolean fields
        $validated['registration_required'] = $request->has('registration_required');
        $validated['send_reminders'] = $request->has('send_reminders');

        $validated['created_by'] = auth()->id();
        
        // Generate QR code
        if (empty($validated['qr_code'])) {
            $validated['qr_code'] = 'EVT-' . strtoupper(Str::random(10));
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('events/cover-images', 'public');
            $validated['cover_image'] = $path;
        }

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show($id)
    {
        $event = Event::with([
            'creator',
            'attendances.parishioner',
            'registrations.parishioner',
            'schedules.leader',
            'tasks.assignedUser',
            'tasks.assignedParishioner',
            'media',
            'finances.parishioner',
            'feedbacks.parishioner',
            'liturgicalRoles.parishioner',
            'liturgicalRoles.user',
            'approvals.approver'
        ])->findOrFail($id);
        
        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $leaders = Leader::where('is_active', true)->get();
        return view('events.edit', compact('event', 'leaders'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:misa_ya_kawaida,misa_maalum,harusi,mazishi,kipaimara,novena,adoration,ekaristi_takatifu,kwaresima,kipindi_cha_pasaka,mikutano_ya_jumuiya,semina,retreata,matukio_ya_dayosisi,misa,event_za_kanisa,charity,hija,ibada,mkesha,mkutano_wa_vijana',
            'category' => 'required|in:misa_ya_kawaida,misa_maalum,harusi,mazishi,kipaimara,novena,adoration,ekaristi_takatifu,kwaresima,kipindi_cha_pasaka,mikutano_ya_jumuiya,semina,retreata,matukio_ya_dayosisi,ibada,mkesha,mkutano_wa_vijana,misa,event_za_kanisa,charity,hija',
            'title' => 'required|string|max:255',
            'theme' => 'nullable|string|max:255',
            'spiritual_theme' => 'nullable|string',
            'scripture_readings' => 'nullable|string',
            'description' => 'nullable|string',
            'program_flow' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'parish' => 'nullable|string|max:255',
            'priest_name' => 'nullable|string|max:255',
            'liturgical_color' => 'nullable|in:white,red,green,purple,rose,black,gold',
            'community' => 'nullable|string|max:255',
            'expected_attendance' => 'nullable|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'registration_required' => 'nullable|boolean',
            'registration_deadline' => 'nullable|date|after:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'requires_approval' => 'nullable|boolean',
            'approval_level' => 'nullable|in:parish_coordinator,pastor,diocese',
            'status' => 'required|in:planned,registration_open,ongoing,completed,cancelled',
            'is_active' => 'nullable|boolean',
            'send_reminders' => 'nullable|boolean',
            'announcement' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        // Convert boolean fields
        $validated['registration_required'] = $request->has('registration_required');
        $validated['send_reminders'] = $request->has('send_reminders');
        $validated['is_active'] = $request->has('is_active');
        $validated['requires_approval'] = $request->has('requires_approval');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($event->cover_image) {
                \Storage::disk('public')->delete($event->cover_image);
            }
            $path = $request->file('cover_image')->store('events/cover-images', 'public');
            $validated['cover_image'] = $path;
        }

        $event->update($validated);

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function qrCode($id)
    {
        $event = Event::findOrFail($id);
        return view('events.qr-code', compact('event'));
    }
}
