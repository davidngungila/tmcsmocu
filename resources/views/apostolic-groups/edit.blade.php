@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Apostolic Group</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Update group information</p>
        </div>
        <a href="{{ route('apostolic-groups.show', $group->id) }}" class="text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('apostolic-groups.update', $group->id) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name', $group->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $group->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Leader</label>
                <select name="leader_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Select Leader</option>
                    @foreach($parishioners as $parishioner)
                    <option value="{{ $parishioner->id }}" {{ old('leader_id', $group->leader_id) == $parishioner->id ? 'selected' : '' }}>
                        {{ $parishioner->full_name }}
                    </option>
                    @endforeach
                </select>
                @error('leader_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                <select name="is_active" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="1" {{ old('is_active', $group->is_active) ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !old('is_active', $group->is_active) ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div class="border-t border-gray-200 pt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('apostolic-groups.show', $group->id) }}" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                    Update Group
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

