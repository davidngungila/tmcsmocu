@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">SMS Reports</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View SMS delivery and cost reports</p>
        </div>
    </div>
    
    <!-- Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 sm:p-6 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-green-700">Total Sent</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2">{{ number_format($totalSent ?? 0) }}</p>
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
                    <p class="text-xs sm:text-sm font-medium text-red-700">Total Failed</p>
                    <p class="text-xl sm:text-2xl font-bold text-red-900 mt-2">{{ number_format($totalFailed ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 sm:p-6 border border-yellow-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-yellow-700">Pending</p>
                    <p class="text-xl sm:text-2xl font-bold text-yellow-900 mt-2">{{ number_format($totalPending ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Campaigns Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto -mx-6 px-6">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Campaign</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Created By</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Recipients</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Created At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($campaigns as $campaign)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $campaign->title }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->creator->name ?? 'N/A' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ number_format($campaign->recipient_count ?? 0) }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $campaign->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($campaign->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                   ($campaign->status === 'sent' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $campaign->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                            <p class="text-sm">No campaigns found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($campaigns->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $campaigns->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

