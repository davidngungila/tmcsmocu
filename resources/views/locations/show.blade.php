@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📍 Location Details</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View complete location information</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('locations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Locations
            </a>
            <a href="{{ route('locations.edit', $location) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Location
            </a>
        </div>
    </div>

    <!-- Location Details Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center">
                        <span class="text-3xl">📍</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $location->place ?? $location->street ?? $location->ward }}</h2>
                        <p class="text-purple-100">{{ $location->is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-white/20 text-white rounded-full text-sm">
                        ID: {{ $location->id }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Details Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Location Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">🗺️ Location Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Region</span>
                            <span class="text-gray-800">{{ $location->region }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Region Code</span>
                            <span class="text-gray-800">{{ $location->region_code }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">District</span>
                            <span class="text-gray-800">{{ $location->district }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">District Code</span>
                            <span class="text-gray-800">{{ $location->district_code }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Ward</span>
                            <span class="text-gray-800">{{ $location->ward }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Ward Code</span>
                            <span class="text-gray-800">{{ $location->ward_code }}</span>
                        </div>
                        
                        @if($location->street)
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Street</span>
                            <span class="text-gray-800">{{ $location->street }}</span>
                        </div>
                        @endif
                        
                        @if($location->place)
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Place</span>
                            <span class="text-gray-800">{{ $location->place }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">⚙️ Status & Actions</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Status</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $location->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $location->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Created</span>
                            <span class="text-gray-800">{{ $location->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-gray-600 font-medium">Last Updated</span>
                            <span class="text-gray-800">{{ $location->updated_at->format('M j, Y g:i A') }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 space-y-3">
                        <a href="{{ route('locations.edit', $location) }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Location
                        </a>
                        
                        <form action="{{ route('locations.destroy', $location) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this location? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Location
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Full Address Display -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">📍 Full Address</h3>
                <p class="text-gray-700">
                    @if($location->place){{ $location->place }}, @endif
                    @if($location->street){{ $location->street }}, @endif
                    {{ $location->ward }}, {{ $location->district }}, {{ $location->region }}, Tanzania
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">🔗 Quick Navigation</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('locations.index') }}" class="flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                All Locations
            </a>
            
            <a href="{{ route('locations.create') }}" class="flex items-center justify-center px-4 py-3 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Location
            </a>
            
            <a href="{{ route('locations.export') }}" class="flex items-center justify-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Data
            </a>
            
            <button onclick="window.print()" class="flex items-center justify-center px-4 py-3 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </button>
        </div>
    </div>
</div>
@endsection
