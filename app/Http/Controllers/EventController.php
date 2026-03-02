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

    public function calendarFeed(Request $request)
    {
        $request->validate([
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'status' => 'nullable|string',
            'category' => 'nullable|string',
            'type' => 'nullable|string',
            'q' => 'nullable|string|max:255',
        ]);

        $query = Event::query();

        if ($request->filled('start') && $request->filled('end')) {
            $start = $request->input('start');
            $end = $request->input('end');

            $query
                ->where('start_date', '<', $end)
                ->where(function ($sub) use ($start) {
                    $sub->where(function ($q) use ($start) {
                        $q->whereNotNull('end_date')->where('end_date', '>=', $start);
                    })->orWhere(function ($q) use ($start) {
                        $q->whereNull('end_date')->where('start_date', '>=', $start);
                    });
                });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('type') && $request->input('type') !== 'all') {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', '%' . $q . '%')
                    ->orWhere('location', 'like', '%' . $q . '%')
                    ->orWhere('parish', 'like', '%' . $q . '%')
                    ->orWhere('community', 'like', '%' . $q . '%');
            });
        }

        $events = $query
            ->orderBy('start_date')
            ->limit(500)
            ->get();

        $statusColors = [
            'planned' => '#143F63',
            'registration_open' => '#0f2f49',
            'ongoing' => '#166534',
            'completed' => '#4b5563',
            'cancelled' => '#b91c1c',
        ];

        return response()->json(
            $events->map(function (Event $event) use ($statusColors) {
                $start = optional($event->start_date)->toIso8601String();
                $end = optional($event->end_date)->toIso8601String();

                return [
                    'id' => (string) $event->id,
                    'title' => (string) $event->title,
                    'start' => $start,
                    'end' => $end,
                    'backgroundColor' => $statusColors[$event->status] ?? '#143F63',
                    'borderColor' => $statusColors[$event->status] ?? '#143F63',
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'status' => $event->status,
                        'type' => $event->type,
                        'category' => $event->category,
                        'location' => $event->location,
                        'parish' => $event->parish,
                        'community' => $event->community,
                        'description' => $event->description,
                        'start_date' => $start,
                        'end_date' => $end,
                    ],
                ];
            })->values()
        );
    }

    public function calendarUpdateDates(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:events,id',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
        ]);

        $event = Event::findOrFail($validated['id']);

        $isAdmin = (auth()->user()->role->slug ?? null) === 'admin';
        if (!$isAdmin && $event->created_by !== auth()->id()) {
            abort(403);
        }

        $event->start_date = $validated['start'];
        $event->end_date = $validated['end'] ?? null;
        $event->save();

        return response()->json(['ok' => true]);
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
