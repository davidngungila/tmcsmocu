@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Waumini {{ $type === 'wanafunzi' ? 'Wanafunzi' : 'Wafanyakazi' }}
            </h1>
            <p class="text-gray-600 mt-1">Manage parishioners</p>
        </div>
        <a href="{{ route('parishioners.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors">
            + Register Parishioner
        </a>
    </div>
    
    <div class="flex space-x-4">
        <a href="{{ route('parishioners.index', ['type' => 'wanafunzi']) }}" class="px-4 py-2 rounded-lg font-bold {{ $type === 'wanafunzi' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Wanafunzi
        </a>
        <a href="{{ route('parishioners.index', ['type' => 'wafanyakazi']) }}" class="px-4 py-2 rounded-lg font-bold {{ $type === 'wafanyakazi' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Wafanyakazi
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Registration Date</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($parishioners as $parishioner)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-base font-bold text-gray-900">{{ $parishioner->full_name }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ $parishioner->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ $parishioner->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ $parishioner->registration_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                            <a href="{{ route('parishioners.show', $parishioner->id) }}" class="text-purple-600 hover:text-purple-900 mr-3">View</a>
                            <a href="{{ route('parishioners.edit', $parishioner->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('parishioners.destroy', $parishioner->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-base">No parishioners found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($parishioners->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $parishioners->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

