<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventApproval;
use Illuminate\Http\Request;

class EventApprovalController extends Controller
{
    public function index($eventId)
    {
        $event = Event::with('approvals.approver')->findOrFail($eventId);
        return view('events.approvals.index', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        
        $validated = $request->validate([
            'approval_level' => 'required|in:parish_coordinator,pastor,diocese',
            'status' => 'required|in:pending,approved,rejected',
            'comments' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        $validated['event_id'] = $eventId;
        $validated['approved_by'] = auth()->id();
        
        if ($validated['status'] === 'approved') {
            $validated['approved_at'] = now();
        }

        EventApproval::create($validated);

        return redirect()->route('events.approvals', $eventId)
            ->with('success', 'Approval status updated successfully.');
    }

    public function update(Request $request, $eventId, $id)
    {
        $approval = EventApproval::where('event_id', $eventId)->findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'comments' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        if ($validated['status'] === 'approved' && !$approval->approved_at) {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        }

        $approval->update($validated);

        return redirect()->route('events.approvals', $eventId)
            ->with('success', 'Approval updated successfully.');
    }
}

