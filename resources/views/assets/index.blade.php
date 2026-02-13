@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Rasilimali</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Simamia rasilimali zote za kanisa</p>
        </div>
        <a href="{{ route('assets.create') }}" class="bg-purple-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors shadow-sm text-sm sm:text-base whitespace-nowrap">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ongeza Rasilimali
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto -mx-6 px-6">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jina</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Aina</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hali</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Thamani</th>
                        <th class="px-3 sm:px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Vitendo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $asset)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-3 sm:px-6 py-4">
                            <div class="text-sm sm:text-base font-bold text-gray-900">{{ $asset->name }}</div>
                            <div class="text-xs text-gray-500 mt-1 sm:hidden">
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $asset->category)) }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 md:hidden">
                                {{ $asset->value ? 'TZS ' . number_format($asset->value, 2) : 'N/A' }}
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $asset->category)) }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $asset->status === 'inayotumika' ? 'bg-green-100 text-green-800' : ($asset->status === 'iliyoharibika' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $asset->status)) }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm sm:text-base font-bold text-gray-900 hidden md:table-cell">
                            {{ $asset->value ? 'TZS ' . number_format($asset->value, 2) : 'N/A' }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('assets.show', $asset->id) }}" class="text-purple-600 hover:text-purple-900 font-medium">Angalia</a>
                                <a href="{{ route('assets.edit', $asset->id) }}" class="text-blue-600 hover:text-blue-900 font-medium hidden sm:inline">Hariri</a>
                                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="inline" onsubmit="return confirm('Una uhakika?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium hidden sm:inline">Futa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-3 sm:px-6 py-12 text-center text-gray-500">
                            <p class="text-sm sm:text-base">Hakuna rasilimali zilizopatikana</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($assets->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $assets->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

