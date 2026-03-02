@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
	<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
	    <div>
	        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">SMS Batches</h1>
	        <p class="text-gray-600 mt-1 text-sm sm:text-base">View SMS batch sending history</p>
	    </div>
	</div>
    
    <!-- Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 sm:p-6 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-blue-700">Total Batches</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2">{{ number_format($batches->total() ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 sm:p-6 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-green-700">Sent Batches</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2">{{ number_format($batches->where('status', 'sent')->count() ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 sm:p-6 border border-red-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-red-700">Failed Batches</p>
                    <p class="text-xl sm:text-2xl font-bold text-red-900 mt-2">{{ number_format($batches->where('status', 'failed')->count() ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Batches Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto -mx-6 px-6">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Campaign</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Campaign</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Recipients</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Scheduled At</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Sent At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($batches as $batch)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $batch->campaign->title ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ number_format($batch->recipient_count ?? 0) }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $batch->status === 'sent' ? 'bg-green-100 text-green-800' : ($batch->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($batch->status ?? 'Pending') }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $batch->scheduled_at ? $batch->scheduled_at->format('M d, Y H:i') : 'N/A' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $batch->sent_at ? $batch->sent_at->format('M d, Y H:i') : 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                            <p class="text-sm">No batches found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($batches->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $batches->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

