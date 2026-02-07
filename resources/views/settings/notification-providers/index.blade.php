@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">SMS Providers</h1>
            <p class="text-gray-600 mt-1">Manage SMS notification providers</p>
        </div>
        <a href="{{ route('settings.notification-providers.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors">
            + Add Provider
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Primary</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">From/Sender</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($providers as $provider)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-base font-bold text-gray-900">{{ $provider->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase">
                                {{ $provider->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $provider->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $provider->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($provider->is_primary)
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-800">Primary</span>
                            @else
                                <form action="{{ route('settings.notification-providers.set-primary', $provider->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-purple-600 hover:text-purple-900">Set Primary</button>
                                </form>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ $provider->sms_from ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                            <a href="{{ route('settings.notification-providers.edit', $provider->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('settings.notification-providers.destroy', $provider->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-base">No providers found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

