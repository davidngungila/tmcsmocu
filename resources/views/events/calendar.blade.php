@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Events Calendar</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View all events in calendar format</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-800">
                ← Back
            </a>
            <a href="{{ route('events.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                + New Event
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div id="calendar"></div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'en',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '{{ route("events.index") }}?format=json',
        eventClick: function(info) {
            window.location.href = '/events/' + info.event.id;
        }
    });
    calendar.render();
});
</script>
@endsection
