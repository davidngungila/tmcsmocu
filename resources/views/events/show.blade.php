@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $event->title }}</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Event Details</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('events.edit', $event->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors text-sm sm:text-base">
                Edit
            </a>
            <a href="{{ route('events.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <!-- Approval Status -->
    @if($event->requires_approval)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-yellow-900">Approval Required</h3>
                <p class="text-sm text-yellow-700 mt-1">
                    Approval Level: {{ ucfirst(str_replace('_', ' ', $event->approval_level)) }}
                </p>
                @if($event->isFullyApproved())
                    <span class="inline-block mt-2 px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Fully Approved</span>
                @else
                    <span class="inline-block mt-2 px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">Pending Approval</span>
                @endif
            </div>
            <a href="{{ route('events.approvals', $event->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Manage Approvals</a>
        </div>
    </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Event Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Event Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Title</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full bg-purple-100 text-purple-800">
                            {{ ucfirst(str_replace('_', ' ', $event->category ?? $event->type)) }}
                        </span>
                    </div>
                    @if($event->theme)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Theme</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->theme }}</p>
                    </div>
                    @endif
                    @if($event->spiritual_theme)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Spiritual Theme</label>
                        <p class="text-base text-gray-900">{{ $event->spiritual_theme }}</p>
                    </div>
                    @endif
                    @if($event->scripture_readings)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Scripture Readings</label>
                        <p class="text-base text-gray-900 whitespace-pre-line">{{ $event->scripture_readings }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Start Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->start_date->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">End Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->end_date ? $event->end_date->format('M d, Y h:i A') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Location</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->location ?? 'N/A' }}</p>
                    </div>
                    @if($event->parish)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Parish</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->parish }}</p>
                    </div>
                    @endif
                    @if($event->priest_name)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Priest / Bishop</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->priest_name }}</p>
                    </div>
                    @endif
                    @if($event->liturgical_color)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Liturgical Color</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full bg-{{ $event->liturgical_color }}-100 text-{{ $event->liturgical_color }}-800 capitalize">
                            {{ $event->liturgical_color }}
                        </span>
                    </div>
                    @endif
                    @if($event->community)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Community</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->community }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        @php
                            $statusColors = [
                                'planned' => 'bg-yellow-100 text-yellow-800',
                                'registration_open' => 'bg-blue-100 text-blue-800',
                                'ongoing' => 'bg-green-100 text-green-800',
                                'completed' => 'bg-gray-100 text-gray-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $statusColor = $statusColors[$event->status ?? 'planned'] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $statusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $event->status ?? 'planned')) }}
                        </span>
                    </div>
                    @if($event->description)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                        <p class="text-base text-gray-900 whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Program / Liturgy Schedule -->
            @if($event->schedules->count() > 0 || $event->program_flow)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Program / Liturgy Schedule</h2>
                    <a href="{{ route('events.schedules.index', $event->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold">Manage Schedule</a>
                </div>
                @if($event->program_flow)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Program Flow</label>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ $event->program_flow }}</p>
                    </div>
                </div>
                @endif
                @if($event->schedules->count() > 0)
                <div class="space-y-3">
                    @foreach($event->schedules as $schedule)
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $schedule->session_title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $schedule->start_time->format('h:i A') }} - {{ $schedule->end_time->format('h:i A') }}
                                </p>
                                @if($schedule->location)
                                <p class="text-xs text-gray-500 mt-1">📍 {{ $schedule->location }}</p>
                                @endif
                                @if($schedule->speaker)
                                <p class="text-xs text-gray-500 mt-1">Speaker: {{ $schedule->speaker }}</p>
                                @endif
                                @if($schedule->description)
                                <p class="text-sm text-gray-700 mt-2">{{ $schedule->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif
            
            <!-- Attendance -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Attendance</h2>
                    <a href="{{ route('events.attendance.index', $event->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold">Manage Attendance</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @if($event->expected_attendance)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Expected</label>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($event->expected_attendance) }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Registered</label>
                        <p class="text-2xl font-bold text-blue-900">{{ $event->registrations_count ?? $event->registrations->where('status', 'confirmed')->count() }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Attended</label>
                        <p class="text-2xl font-bold text-green-900">{{ $event->total_attendance }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Liturgical Roles / Volunteers -->
            @if($event->liturgicalRoles->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Liturgical Roles & Volunteers</h2>
                    <a href="{{ route('events.volunteers.index', $event->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold">Manage Roles</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($event->liturgicalRoles->groupBy('role_type') as $roleType => $roles)
                    <div>
                        <h4 class="font-bold text-gray-700 mb-2 capitalize">{{ str_replace('_', ' ', $roleType) }}</h4>
                        <ul class="space-y-1">
                            @foreach($roles as $role)
                            <li class="text-sm text-gray-600">
                                {{ $role->parishioner ? $role->parishioner->full_name : ($role->name ?? 'N/A') }}
                                @if($role->parish)
                                    <span class="text-xs text-gray-500">({{ $role->parish }})</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Contributions / Finances -->
            @if($event->finances->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Contributions & Finances</h2>
                    <a href="{{ route('events.finances.index', $event->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold">Manage Finances</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Total Income</label>
                        <p class="text-2xl font-bold text-green-900">TSh {{ number_format($event->total_income, 0) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Total Expenses</label>
                        <p class="text-2xl font-bold text-red-900">TSh {{ number_format($event->total_expenses, 0) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Balance</label>
                        <p class="text-2xl font-bold text-gray-900">TSh {{ number_format($event->balance, 0) }}</p>
                    </div>
                </div>
                @if($event->budget)
                <div class="mt-4 pt-4 border-t">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Budget</label>
                    <p class="text-lg font-bold text-gray-900">TSh {{ number_format($event->budget, 0) }}</p>
                </div>
                @endif
            </div>
            @endif
            
            <!-- Media & Archives -->
            @if($event->media->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Media & Archives</h2>
                    <a href="{{ route('events.media.index', $event->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold">Manage Media</a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($event->media->take(8) as $media)
                    <div class="relative">
                        @if($media->file_type === 'image')
                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->description ?? 'Event Media' }}" class="w-full h-32 object-cover rounded-lg">
                        @else
                            <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400">{{ strtoupper($media->file_type ?? 'FILE') }}</span>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-2">
                    @if($event->registration_required)
                    <a href="{{ route('events.registrations.index', $event->id) }}" class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-center font-bold">
                        View Registrations
                    </a>
                    @endif
                    <a href="{{ route('events.attendance.index', $event->id) }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center font-bold">
                        Check Attendance
                    </a>
                    <a href="{{ route('events.volunteers.index', $event->id) }}" class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center font-bold">
                        Manage Volunteers
                    </a>
                    <a href="{{ route('events.finances.index', $event->id) }}" class="block w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 text-center font-bold">
                        View Finances
                    </a>
                    <a href="{{ route('events.reports', $event->id) }}" class="block w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-center font-bold">
                        Generate Report
                    </a>
                    <a href="{{ route('events.qr-code', $event->id) }}" class="block w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-center font-bold">
                        View QR Code
                    </a>
                </div>
            </div>
            
            <!-- Event Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Event Details</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Created By</label>
                        <p class="text-sm font-bold text-gray-900">{{ $event->creator->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Created At</label>
                        <p class="text-sm font-bold text-gray-900">{{ $event->created_at->format('M d, Y') }}</p>
                    </div>
                    @if($event->qr_code)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">QR Code</label>
                        <p class="text-sm font-bold text-gray-900 font-mono">{{ $event->qr_code }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
