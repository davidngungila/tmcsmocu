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
            <a href="{{ route('events.create') }}" class="bg-[#143F63] text-white px-4 py-2 rounded-lg hover:bg-[#0f2f49]">
                + New Event
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="md:col-span-2">
                <input id="calendarSearch" type="text" placeholder="Search (title, location, parish, community)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#143F63] focus:border-transparent">
            </div>
            <div>
                <select id="calendarStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#143F63] focus:border-transparent">
                    <option value="all">All Status</option>
                    <option value="planned">Planned</option>
                    <option value="registration_open">Registration Open</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div>
                <div class="flex gap-2">
                    <button id="calendarApply" type="button" class="flex-1 bg-[#143F63] text-white px-4 py-2 rounded-lg hover:bg-[#0f2f49]">Apply</button>
                    <button id="calendarReset" type="button" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Reset</button>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-3">
            <div>
                <input id="calendarType" type="text" placeholder="Type (optional)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#143F63] focus:border-transparent">
            </div>
            <div>
                <input id="calendarCategory" type="text" placeholder="Category (optional)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#143F63] focus:border-transparent">
            </div>
            <div class="md:col-span-2 text-xs text-gray-500 flex items-center">
                Drag & drop or resize events to update dates (admin or event creator only).
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div id="calendar"></div>
    </div>
</div>

<div id="eventModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <div class="min-w-0">
                <h3 id="eventModalTitle" class="text-lg font-bold text-gray-900 truncate">Event</h3>
                <p id="eventModalMeta" class="text-sm text-gray-600 truncate"></p>
            </div>
            <button type="button" id="eventModalClose" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-600">
                ✕
            </button>
        </div>
        <div class="px-5 py-4 space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div>
                    <div class="text-xs text-gray-500">Status</div>
                    <div id="eventModalStatus" class="font-semibold text-gray-800">-</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Location</div>
                    <div id="eventModalLocation" class="font-semibold text-gray-800">-</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Start</div>
                    <div id="eventModalStart" class="font-semibold text-gray-800">-</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">End</div>
                    <div id="eventModalEnd" class="font-semibold text-gray-800">-</div>
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-500">Description</div>
                <div id="eventModalDescription" class="text-sm text-gray-700 whitespace-pre-wrap">-</div>
            </div>
        </div>
        <div class="px-5 py-4 border-t border-gray-200 flex items-center justify-end gap-2">
            <a id="eventModalView" href="#" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">View</a>
            <a id="eventModalEdit" href="#" class="px-4 py-2 rounded-lg bg-[#143F63] text-white hover:bg-[#0f2f49]">Edit</a>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<style>
    .fc .fc-button-primary { background-color: #143F63; border-color: #143F63; }
    .fc .fc-button-primary:hover { background-color: #0f2f49; border-color: #0f2f49; }
    .fc .fc-button-primary:disabled { background-color: #143F63; border-color: #143F63; opacity: 0.65; }
    .fc .fc-toolbar-title { font-weight: 800; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    const modal = document.getElementById('eventModal');
    const modalTitle = document.getElementById('eventModalTitle');
    const modalMeta = document.getElementById('eventModalMeta');
    const modalStatus = document.getElementById('eventModalStatus');
    const modalLocation = document.getElementById('eventModalLocation');
    const modalStart = document.getElementById('eventModalStart');
    const modalEnd = document.getElementById('eventModalEnd');
    const modalDescription = document.getElementById('eventModalDescription');
    const modalView = document.getElementById('eventModalView');
    const modalEdit = document.getElementById('eventModalEdit');
    const modalClose = document.getElementById('eventModalClose');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    modalClose.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    function formatDateTime(iso) {
        if (!iso) return '-';
        try {
            const d = new Date(iso);
            return d.toLocaleString();
        } catch (e) {
            return iso;
        }
    }

    function getFilters() {
        return {
            q: document.getElementById('calendarSearch').value || '',
            status: document.getElementById('calendarStatus').value || 'all',
            type: document.getElementById('calendarType').value || 'all',
            category: document.getElementById('calendarCategory').value || 'all',
        };
    }

    function applyFilters() {
        calendar.refetchEvents();
    }

    document.getElementById('calendarApply').addEventListener('click', applyFilters);
    document.getElementById('calendarReset').addEventListener('click', function() {
        document.getElementById('calendarSearch').value = '';
        document.getElementById('calendarStatus').value = 'all';
        document.getElementById('calendarType').value = '';
        document.getElementById('calendarCategory').value = '';
        applyFilters();
    });
    document.getElementById('calendarSearch').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') applyFilters();
    });

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'en',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        eventResizableFromStart: true,
        events: {
            url: '{{ route("events.calendar.feed") }}',
            method: 'GET',
            extraParams: function() {
                return getFilters();
            },
            failure: function() {
                alert('Failed to load events.');
            }
        },
        eventClick: function(info) {
            const props = info.event.extendedProps || {};
            modalTitle.textContent = info.event.title || 'Event';
            modalMeta.textContent = (props.type || '') + (props.category ? ' • ' + props.category : '');
            modalStatus.textContent = props.status || '-';
            modalLocation.textContent = props.location || '-';
            modalStart.textContent = formatDateTime(props.start_date || info.event.start);
            modalEnd.textContent = formatDateTime(props.end_date || info.event.end);
            modalDescription.textContent = props.description || '-';
            modalView.href = '/events/' + info.event.id;
            modalEdit.href = '/events/' + info.event.id + '/edit';
            openModal();
        },
        eventDrop: function(info) {
            updateEventDates(info);
        },
        eventResize: function(info) {
            updateEventDates(info);
        }
    });

    function updateEventDates(info) {
        fetch('{{ route("events.calendar.update-dates") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id: parseInt(info.event.id, 10),
                start: info.event.start ? info.event.start.toISOString() : null,
                end: info.event.end ? info.event.end.toISOString() : null,
            })
        }).then(async (res) => {
            if (!res.ok) {
                info.revert();
                const text = await res.text();
                alert('Failed to update dates. ' + text);
                return;
            }
        }).catch(() => {
            info.revert();
            alert('Failed to update dates.');
        });
    }

    calendar.render();
});
</script>
@endsection
