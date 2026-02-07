@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Event Details</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View event information</p>
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
                        <label class="block text-sm font-medium text-gray-500 mb-1">Type</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full bg-purple-100 text-purple-800">
                            {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                        </span>
                    </div>
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
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $event->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if($event->description)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                        <p class="text-base text-gray-900">{{ $event->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Attendance -->
            @if($event->expected_attendance || $event->attendances->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Attendance</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($event->expected_attendance)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Expected</label>
                        <p class="text-base font-bold text-gray-900">{{ number_format($event->expected_attendance) }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Actual</label>
                        <p class="text-base font-bold text-gray-900">{{ $event->attendances->count() }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

