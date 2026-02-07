@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Leader Details</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View leader information</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('leaders.edit', $leader->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors text-sm sm:text-base">
                Edit
            </a>
            <a href="{{ route('leaders.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Leader Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Leader Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->parishioner->full_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Position</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->position }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Start Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->start_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">End Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->end_date ? $leader->end_date->format('M d, Y') : 'Ongoing' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $leader->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $leader->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if($leader->responsibilities)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Responsibilities</label>
                        <p class="text-base text-gray-900">{{ $leader->responsibilities }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Parishioner Details -->
            @if($leader->parishioner)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Parishioner Details</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Contact</label>
                        <p class="text-sm font-bold text-gray-900">{{ $leader->parishioner->contact_number ?? $leader->parishioner->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-sm font-bold text-gray-900">{{ $leader->parishioner->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $leader->parishioner->type === 'wanafunzi' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $leader->parishioner->type === 'wanafunzi' ? 'Student' : 'Worker' }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

