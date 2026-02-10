@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Events</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage all church events</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('events.calendar') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition-colors">
                Calendar
            </a>
            <a href="{{ route('events.create') }}" class="bg-purple-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors shadow-sm text-sm sm:text-base whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Event
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto -mx-6 px-6">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Category</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Location</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Registrations</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($events as $event)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $event->title }}</div>
                            @if($event->theme)
                                <div class="text-xs text-gray-500 mt-1">Theme: {{ $event->theme }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                {{ ucfirst(str_replace('_', ' ', $event->category ?? $event->type)) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <div>{{ $event->start_date->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $event->start_date->format('h:i A') }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $event->location ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-sm">
                            <div class="text-gray-900 font-bold">{{ $event->registrations_count ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Registered</div>
                        </td>
                        <td class="px-4 py-4">
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
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                {{ ucfirst(str_replace('_', ' ', $event->status ?? 'planned')) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('events.show', $event->id) }}" class="text-purple-600 hover:text-purple-900" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                            <p class="text-sm">No events found</p>
                            <a href="{{ route('events.create') }}" class="text-purple-600 hover:underline mt-2 inline-block">Create your first event</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($events->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
