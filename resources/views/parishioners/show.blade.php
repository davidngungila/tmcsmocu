@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Parishioner Details</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View parishioner information</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('parishioners.edit', $parishioner->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors text-sm sm:text-base">
                Edit
            </a>
            <a href="{{ route('parishioners.index', ['type' => $parishioner->type]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->full_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Type</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $parishioner->type === 'wanafunzi' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $parishioner->type === 'wanafunzi' ? 'Student' : 'Worker' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                        <p class="text-base font-bold text-gray-900">{{ ucfirst($parishioner->gender ?? 'N/A') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->date_of_birth ? $parishioner->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Registration Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->registration_date ? $parishioner->registration_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $parishioner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $parishioner->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->contact_number ?? $parishioner->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->email ?? 'N/A' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            @if($parishioner->occupation || $parishioner->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Additional Information</h2>
                <div class="space-y-4">
                    @if($parishioner->occupation)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Occupation</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->occupation }}</p>
                    </div>
                    @endif
                    @if($parishioner->notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Notes</label>
                        <p class="text-base text-gray-900">{{ $parishioner->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Communities -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Communities</h2>
                @if($parishioner->communities->count() > 0)
                    <div class="space-y-2">
                        @foreach($parishioner->communities as $community)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-900">{{ $community->name }}</span>
                            <span class="text-xs px-2 py-1 rounded-full {{ $community->pivot->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $community->pivot->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No communities assigned</p>
                @endif
            </div>
            
            <!-- Apostolic Groups -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Apostolic Groups</h2>
                @if($parishioner->apostolicGroups->count() > 0)
                    <div class="space-y-2">
                        @foreach($parishioner->apostolicGroups as $group)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-900">{{ $group->name }}</span>
                            <span class="text-xs px-2 py-1 rounded-full {{ $group->pivot->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $group->pivot->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No apostolic groups assigned</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

