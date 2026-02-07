@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Ripoti za Fedha</h1>
        <p class="text-gray-600 mt-1">Financial reports and analytics</p>
    </div>
    
    <!-- Report Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('finance.reports.daily') }}" class="bg-white rounded-xl shadow-sm border-2 border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Daily Report</h3>
                    </div>
                    <p class="text-sm text-gray-600">View daily financial transactions and summary</p>
                    <div class="mt-4 flex items-center text-purple-600 group-hover:text-purple-700">
                        <span class="text-sm font-medium">View Report</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        
        <a href="{{ route('finance.reports.monthly') }}" class="bg-white rounded-xl shadow-sm border-2 border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Monthly Report</h3>
                    </div>
                    <p class="text-sm text-gray-600">View monthly financial summary and breakdown</p>
                    <div class="mt-4 flex items-center text-purple-600 group-hover:text-purple-700">
                        <span class="text-sm font-medium">View Report</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        
        <a href="{{ route('finance.reports.annual') }}" class="bg-white rounded-xl shadow-sm border-2 border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Annual Report</h3>
                    </div>
                    <p class="text-sm text-gray-600">View yearly overview with monthly breakdown</p>
                    <div class="mt-4 flex items-center text-purple-600 group-hover:text-purple-700">
                        <span class="text-sm font-medium">View Report</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Quick Stats -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                <p class="text-xs text-blue-600 font-medium uppercase">Today</p>
                <p class="text-lg font-bold text-blue-900 mt-1">View Daily Report</p>
            </div>
            <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                <p class="text-xs text-green-600 font-medium uppercase">This Month</p>
                <p class="text-lg font-bold text-green-900 mt-1">View Monthly Report</p>
            </div>
            <div class="p-4 bg-purple-50 rounded-lg border border-purple-100">
                <p class="text-xs text-purple-600 font-medium uppercase">This Year</p>
                <p class="text-lg font-bold text-purple-900 mt-1">View Annual Report</p>
            </div>
            <div class="p-4 bg-orange-50 rounded-lg border border-orange-100">
                <p class="text-xs text-orange-600 font-medium uppercase">Custom</p>
                <p class="text-lg font-bold text-orange-900 mt-1">Select Date Range</p>
            </div>
        </div>
    </div>
</div>
@endsection
