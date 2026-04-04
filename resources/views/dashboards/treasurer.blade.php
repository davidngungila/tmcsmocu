@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Treasurer Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Financial management and reporting</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="hidden sm:inline">Home > Treasurer Dashboard</span>
            <span class="sm:hidden">Treasurer Dashboard</span>
        </div>
    </div>
    
    <!-- Financial Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Income (FY) -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">Total Income</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">TZS {{ number_format($totalIncome ?? 8450000, 0, '.', ',') }}</p>
                    <p class="text-xs text-green-600 mt-1">This financial year</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Expenses (FY) -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-red-700 truncate">Total Expenses</p>
                    <p class="text-xl sm:text-2xl font-bold text-red-900 mt-2 truncate">TZS {{ number_format($totalExpenses ?? 3200000, 0, '.', ',') }}</p>
                    <p class="text-xs text-red-600 mt-1">This financial year</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Current Balance -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Current Balance</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">TZS {{ number_format($currentBalance ?? 5250000, 0, '.', ',') }}</p>
                    <p class="text-xs text-purple-600 mt-1">Available funds</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Pending Receipts -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-yellow-700 truncate">Pending Receipts</p>
                    <p class="text-xl sm:text-2xl font-bold text-yellow-900 mt-2 truncate">{{ $pendingReceipts ?? 18 }}</p>
                    <p class="text-xs text-yellow-600 mt-1">Awaiting processing</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Financial Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Income vs Expenses Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Income vs Expenses (Monthly)</h3>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Chart visualization placeholder</p>
                    <p class="text-xs text-gray-400 mt-1">Income: 450K, Expenses: 180K, Net: 270K (Oct)</p>
                </div>
            </div>
        </div>
        
        <!-- Contribution Categories -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Contribution Categories</h3>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Pie chart placeholder</p>
                    <p class="text-xs text-gray-400 mt-1">Zaka: 45%, Sadaka: 30%, Projects: 15%, Other: 10%</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Recent Transactions</h3>
            <div class="flex space-x-2">
                <a href="{{ route('finance.income.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">Income</a>
                <a href="{{ route('finance.expenses.index') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">Expenses</a>
            </div>
        </div>
        <div class="p-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Sunday Collection - Mass</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500">Today • 10:30 AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Income</span>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-sm font-bold text-green-600">+ TZS 125,000</p>
                        <p class="text-xs text-gray-500">John Smith</p>
                    </div>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Utility Bills - Electricity</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500">Yesterday • 2:15 PM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Expense</span>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-sm font-bold text-red-600">- TZS 85,000</p>
                        <p class="text-xs text-gray-500">Mary Johnson</p>
                    </div>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Zaka - Monthly Contribution</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500">2 days ago • 9:00 AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Income</span>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-sm font-bold text-green-600">+ TZS 45,000</p>
                        <p class="text-xs text-gray-500">David Wilson</p>
                    </div>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Office Supplies - Stationery</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500">3 days ago • 11:30 AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Expense</span>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-sm font-bold text-red-600">- TZS 23,500</p>
                        <p class="text-xs text-gray-500">Sarah Brown</p>
                    </div>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Building Fund - Special Collection</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500">4 days ago • 6:00 PM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Income</span>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-sm font-bold text-green-600">+ TZS 280,000</p>
                        <p class="text-xs text-gray-500">Robert Davis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Financial Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Income</span>
                    <span class="text-sm font-bold text-green-600">TZS {{ number_format($monthlyIncome ?? 450000, 0, '.', ',') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Expenses</span>
                    <span class="text-sm font-bold text-red-600">TZS {{ number_format($monthlyExpenses ?? 180000, 0, '.', ',') }}</span>
                </div>
                <div class="border-t pt-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Net</span>
                        <span class="text-sm font-bold text-purple-600">TZS {{ number_format($monthlyNet ?? 270000, 0, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Contributors -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Contributors (This Month)</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Michael Johnson</p>
                        <p class="text-xs text-gray-500">Regular contributor</p>
                    </div>
                    <span class="text-sm font-bold text-green-600">TZS 25,000</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Sarah Williams</p>
                        <p class="text-xs text-gray-500">Building fund</p>
                    </div>
                    <span class="text-sm font-bold text-green-600">TZS 20,000</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">David Brown</p>
                        <p class="text-xs text-gray-500">Monthly zaka</p>
                    </div>
                    <span class="text-sm font-bold text-green-600">TZS 18,000</span>
                </div>
            </div>
        </div>
        
        <!-- Budget Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Budget Status</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">General Fund</span>
                        <span class="text-xs text-gray-500">75% used</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">Building Fund</span>
                        <span class="text-xs text-gray-500">45% used</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">Charity Fund</span>
                        <span class="text-xs text-gray-500">90% used</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" style="width: 90%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Finance Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('finance.income.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Record Income</span>
            </a>
            <a href="{{ route('finance.expenses.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-red-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Record Expense</span>
            </a>
            <a href="{{ route('finance.receipts.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Generate Receipt</span>
            </a>
            <a href="{{ route('finance.reports.index') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2m-3-4h.01M9 16h.01"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">View Reports</span>
            </a>
            <a href="{{ route('finance.budget') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Manage Budget</span>
            </a>
            <a href="{{ route('finance.audit') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-teal-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Audit Trail</span>
            </a>
        </div>
    </div>
</div>
@endsection
