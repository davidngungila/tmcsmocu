<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Newsletter;
use App\Models\SmsMessage;

class CommunicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show announcements
     */
    public function announcements()
    {
        $announcements = Announcement::with(['author'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get featured announcements
        $featuredAnnouncements = Announcement::where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('communications.announcements', compact(
            'announcements',
            'featuredAnnouncements'
        ));
    }

    /**
     * Show calendar/events
     */
    public function calendar()
    {
        $user = auth()->user();
        
        // Get upcoming events
        $upcomingEvents = Event::where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->paginate(15);

        // Get events this month
        $thisMonthEvents = Event::whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->orderBy('start_date', 'asc')
            ->get();

        // Get user's registered events
        $myEvents = Event::whereHas('attendees', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('start_date', '>=', now())
        ->orderBy('start_date', 'asc')
        ->limit(5)
        ->get();

        return view('communications.calendar', compact(
            'upcomingEvents',
            'thisMonthEvents',
            'myEvents'
        ));
    }

    /**
     * Show newsletters
     */
    public function newsletters()
    {
        $newsletters = Newsletter::with(['author'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get featured newsletters
        $featuredNewsletters = Newsletter::where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get latest newsletter
        $latestNewsletter = Newsletter::orderBy('created_at', 'desc')->first();

        return view('communications.newsletters', compact(
            'newsletters',
            'featuredNewsletters',
            'latestNewsletter'
        ));
    }

    /**
     * Show SMS compose form (for authorized users)
     */
    public function composeSms()
    {
        if (!auth()->user()->canSendSms()) {
            abort(403, 'You do not have permission to send SMS messages.');
        }

        return view('communications.compose-sms');
    }

    /**
     * Send SMS message (for authorized users)
     */
    public function sendSms(Request $request)
    {
        if (!auth()->user()->canSendSms()) {
            abort(403, 'You do not have permission to send SMS messages.');
        }

        $request->validate([
            'message' => 'required|string|max:160',
            'recipients' => 'required|array',
            'recipients.*' => 'exists:users,id'
        ]);

        $message = $request->message;
        $recipientIds = $request->recipients;

        // Logic to send SMS to recipients
        foreach ($recipientIds as $recipientId) {
            SmsMessage::create([
                'sender_id' => auth()->id(),
                'recipient_id' => $recipientId,
                'message' => $message,
                'status' => 'pending',
                'sent_at' => now()
            ]);
        }

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->log('Sent SMS to ' . count($recipientIds) . ' recipients');

        return back()->with('success', 'SMS message sent successfully!');
    }

    /**
     * Show SMS history
     */
    public function smsHistory()
    {
        if (!auth()->user()->canViewSmsHistory()) {
            abort(403, 'You do not have permission to view SMS history.');
        }

        $sentMessages = SmsMessage::where('sender_id', auth()->id())
            ->with(['recipient'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $receivedMessages = SmsMessage::where('recipient_id', auth()->id())
            ->with(['sender'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('communications.sms-history', compact(
            'sentMessages',
            'receivedMessages'
        ));
    }

    /**
     * Show single announcement
     */
    public function showAnnouncement($id)
    {
        $announcement = Announcement::with(['author'])
            ->findOrFail($id);

        // Increment view count
        $announcement->increment('views');

        return view('communications.show-announcement', compact('announcement'));
    }

    /**
     * Show single newsletter
     */
    public function showNewsletter($id)
    {
        $newsletter = Newsletter::with(['author'])
            ->findOrFail($id);

        // Increment view count
        $newsletter->increment('views');

        return view('communications.show-newsletter', compact('newsletter'));
    }

    /**
     * Show single event details
     */
    public function showEvent($id)
    {
        $event = Event::with(['attendees', 'organizer'])
            ->findOrFail($id);

        $user = auth()->user();
        $isRegistered = $event->attendees()->where('user_id', $user->id)->exists();

        return view('communications.show-event', compact('event', 'isRegistered'));
    }

    /**
     * Register for event
     */
    public function registerForEvent($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        if ($event->attendees()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You are already registered for this event.');
        }

        if ($event->isFull()) {
            return back()->with('error', 'This event is full.');
        }

        $event->attendees()->attach($user->id, [
            'registered_at' => now()
        ]);

        // Log activity
        activity()
            ->causedBy($user)
            ->performedOn($event)
            ->log('Registered for event');

        return back()->with('success', 'Successfully registered for the event!');
    }

    /**
     * Unregister from event
     */
    public function unregisterFromEvent($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        $event->attendees()->detach($user->id);

        // Log activity
        activity()
            ->causedBy($user)
            ->performedOn($event)
            ->log('Unregistered from event');

        return back()->with('success', 'Successfully unregistered from the event.');
    }
}
