@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
	<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
	    <div>
	        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Reports Dashboard</h1>
	        <p class="text-gray-600 mt-1 text-sm sm:text-base">View system-wide reports and statistics</p>
	    </div>
	</div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Finance Reports -->
        <a href="{{ route('finance.reports.index') }}" class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-green-700">Financial Reports</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2">Income: TZS {{ number_format($totalIncome ?? 0, 2) }}</p>
                    <p class="text-sm text-green-800 mt-1">Expenses: TZS {{ number_format($totalExpenses ?? 0, 2) }}</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </a>
        
        <!-- Parishioners Reports -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-blue-700">Parishioners</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2">{{ number_format($totalParishioners ?? 0) }}</p>
                    <p class="text-sm text-blue-800 mt-1">Total registered</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Events Reports -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-purple-700">Events</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2">{{ number_format($totalEvents ?? 0) }}</p>
                    <p class="text-sm text-purple-800 mt-1">Total events</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Communities Reports -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-indigo-700">Communities</p>
                    <p class="text-xl sm:text-2xl font-bold text-indigo-900 mt-2">{{ number_format($totalCommunities ?? 0) }}</p>
                    <p class="text-sm text-indigo-800 mt-1">Total communities</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-indigo-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Apostolic Groups Reports -->
        <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-6 border border-pink-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-pink-700">Apostolic Groups</p>
                    <p class="text-xl sm:text-2xl font-bold text-pink-900 mt-2">{{ number_format($totalGroups ?? 0) }}</p>
                    <p class="text-sm text-pink-800 mt-1">Total groups</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-pink-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Leaders Reports -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-yellow-700">Leaders</p>
                    <p class="text-xl sm:text-2xl font-bold text-yellow-900 mt-2">{{ number_format($totalLeaders ?? 0) }}</p>
                    <p class="text-sm text-yellow-800 mt-1">Active leaders</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Assets Reports -->
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700">Assets</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-2">{{ number_format($totalAssets ?? 0) }}</p>
                    <p class="text-sm text-gray-800 mt-1">Total assets</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- SMS Reports -->
        <a href="{{ route('sms.reports.index') }}" class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl p-6 border border-teal-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-teal-700">SMS Campaigns</p>
                    <p class="text-xl sm:text-2xl font-bold text-teal-900 mt-2">{{ number_format($totalSmsCampaigns ?? 0) }}</p>
                    <p class="text-sm text-teal-800 mt-1">Total campaigns</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-teal-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Quick Links -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Report Links</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('finance.reports.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">Financial Reports</span>
            </a>
            <a href="{{ route('sms.reports.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">SMS Reports</span>
            </a>
            <a href="{{ route('parishioners.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">Parishioners</span>
            </a>
        </div>
    </div>
</div>
@endsection

