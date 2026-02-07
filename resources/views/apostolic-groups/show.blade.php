@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Apostolic Group Details</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View group information</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('apostolic-groups.edit', $group->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors text-sm sm:text-base">
                Edit
            </a>
            <a href="{{ route('apostolic-groups.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Group Information</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                        <p class="text-base font-bold text-gray-900">{{ $group->name }}</p>
                    </div>
                    @if($group->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                        <p class="text-base text-gray-900">{{ $group->description }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Leader</label>
                        <p class="text-base font-bold text-gray-900">{{ $group->leader ? $group->leader->full_name : 'No Leader' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $group->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $group->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Members ({{ $group->parishioners->count() }})</h2>
                @if($group->parishioners->count() > 0)
                    <div class="space-y-2">
                        @foreach($group->parishioners as $parishioner)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-900">{{ $parishioner->full_name }}</span>
                            <span class="text-xs px-2 py-1 rounded-full {{ $parishioner->pivot->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $parishioner->pivot->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">No members yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

