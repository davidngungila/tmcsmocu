@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Leaders</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage church leaders</p>
        </div>
        <a href="{{ route('leaders.create') }}" class="bg-purple-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors shadow-sm text-sm sm:text-base whitespace-nowrap">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Register Leader
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto -mx-6 px-6">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Position</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Start Date</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">End Date</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leaders as $leader)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $leader->parishioner->full_name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $leader->position }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $leader->start_date->format('M d, Y') }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $leader->end_date ? $leader->end_date->format('M d, Y') : 'Ongoing' }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $leader->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $leader->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('leaders.show', $leader->id) }}" class="text-purple-600 hover:text-purple-900">View</a>
                                <a href="{{ route('leaders.edit', $leader->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('leaders.destroy', $leader->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                            <p class="text-sm">No leaders found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($leaders->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $leaders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

