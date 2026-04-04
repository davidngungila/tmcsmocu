@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Super Admin Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Complete overview of MoCU Chaplaincy operations</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="hidden sm:inline">Home > Dashboard</span>
            <span class="sm:hidden">Dashboard</span>
        </div>
    </div>
    
    <!-- KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <!-- Total Members -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Total Members</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ number_format($totalParishioners ?? 1248, 0, '.', ',') }}</p>
                    <p class="text-xs text-blue-600 mt-1">Students: {{ $studentCount ?? 890 }} | Staff: {{ $staffCount ?? 358 }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- New Members This Month -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">New Members</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">{{ $newMembersThisMonth ?? 45 }}</p>
                    <p class="text-xs text-green-600 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Income -->
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
        
        <!-- Total Expenses -->
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
        
        <!-- Balance -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Current Balance</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">TZS {{ number_format($balance ?? 5250000, 0, '.', ',') }}</p>
                    <p class="text-xs text-purple-600 mt-1">Available funds</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Certificates Issued -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Certificates</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">{{ $certificatesIssued ?? 156 }}</p>
                    <p class="text-xs text-orange-600 mt-1">Issued this year</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Contributions Trend Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contributions Trend (Current FY)</h2>
            <div class="h-64">
                <canvas id="contributionsChart"></canvas>
            </div>
        </div>
        
        <!-- Member Growth Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Member Growth (Last 12 Months)</h2>
            <div class="h-64">
                <canvas id="memberGrowthChart"></canvas>
            </div>
        </div>
        
        <!-- Certificates by Type -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Certificates by Type</h2>
            <div class="h-64">
                <canvas id="certificatesChart"></canvas>
            </div>
        </div>
        
        <!-- Event Attendance Rate -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Event Attendance Rate</h2>
            <div class="h-64">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Average Event Attendance Gauge -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Average Event Attendance Rate</h2>
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="relative">
                    <div class="w-full bg-gray-200 rounded-full h-8">
                        <div class="bg-gradient-to-r from-red-500 via-yellow-500 to-green-500 h-8 rounded-full flex items-center justify-end pr-4" style="width: 75%">
                            <span class="text-white font-bold text-sm">75%</span>
                        </div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-600 mt-1">
                        <span>0%</span>
                        <span>25%</span>
                        <span>50%</span>
                        <span>75%</span>
                        <span>100%</span>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">Percentage of invited members who attended events</p>
            </div>
            <div class="ml-6 text-center">
                <div class="text-3xl font-bold text-green-600">75%</div>
                <p class="text-xs text-gray-500">This Month</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Recent Members -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-800">Recent Members</h3>
                <a href="{{ route('parishioners.index') }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">John Doe</p>
                            <p class="text-xs text-gray-500">Student • 2 days ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">New</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Jane Smith</p>
                            <p class="text-xs text-gray-500">Employee • 3 days ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">New</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Mike Johnson</p>
                            <p class="text-xs text-gray-500">Student • 5 days ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">New</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Sarah Wilson</p>
                            <p class="text-xs text-gray-500">Child • 1 week ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">New</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">David Brown</p>
                            <p class="text-xs text-gray-500">Student • 1 week ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">New</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Contributions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-800">Recent Contributions</h3>
                <a href="{{ route('finance.contributions.index') }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Zaka - John</p>
                            <p class="text-xs text-gray-500">Today • TZS 10,000</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Income</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Sadaka - Jane</p>
                            <p class="text-xs text-gray-500">Yesterday • TZS 5,000</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Income</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Event Supplies</p>
                            <p class="text-xs text-gray-500">2 days ago • TZS 50,000</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Expense</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Building Fund - Mike</p>
                            <p class="text-xs text-gray-500">3 days ago • TZS 25,000</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Income</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Office Supplies</p>
                            <p class="text-xs text-gray-500">4 days ago • TZS 15,000</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Expense</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Certificates -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-800">Pending Certificates</h3>
                <a href="{{ route('certificates.pending') }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Finalist - John Doe</p>
                            <p class="text-xs text-gray-500">Submitted 2 hours ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Group - Youth Ministry</p>
                            <p class="text-xs text-gray-500">Submitted 5 hours ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Leadership - Jane Smith</p>
                            <p class="text-xs text-gray-500">Submitted 1 day ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Event - Easter Celebration</p>
                            <p class="text-xs text-gray-500">Submitted 2 days ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Finalist - Mike Johnson</p>
                            <p class="text-xs text-gray-500">Submitted 3 days ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Events -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-800">Upcoming Events</h3>
                <a href="{{ route('events.index') }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Sunday Mass</p>
                            <p class="text-xs text-gray-500">Tomorrow • Fr. John</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Confirmed</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Youth Meeting</p>
                            <p class="text-xs text-gray-500">Apr 10 • Sarah Wilson</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Planning</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Bible Study</p>
                            <p class="text-xs text-gray-500">Apr 12 • Mike Johnson</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Confirmed</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Women's Group</p>
                            <p class="text-xs text-gray-500">Apr 15 • Jane Smith</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Tentative</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Men's Fellowship</p>
                            <p class="text-xs text-gray-500">Apr 18 • David Brown</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Confirmed</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Low Stock Alerts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-800">Low Stock Alerts</h3>
                <a href="{{ route('dashboard') }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Hymn Books</p>
                            <p class="text-xs text-gray-500">Current: 5 • Reorder: 20</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Critical</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Communion Wafers</p>
                            <p class="text-xs text-gray-500">Current: 50 • Reorder: 100</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Low</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Candles</p>
                            <p class="text-xs text-gray-500">Current: 15 • Reorder: 30</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Low</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Prayer Books</p>
                            <p class="text-xs text-gray-500">Current: 8 • Reorder: 25</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Critical</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Rosary Beads</p>
                            <p class="text-xs text-gray-500">Current: 12 • Reorder: 40</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Low</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Buttons & Financial Year Selector -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <a href="{{ route('parishioners.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                    <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span class="text-xs font-medium text-gray-700 text-center">Register Member</span>
                </a>
                <a href="{{ route('finance.contributions.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                    <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs font-medium text-gray-700 text-center">Record Contribution</span>
                </a>
                <a href="{{ route('certificates.finalist.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-300 transition-all duration-200 group">
                    <svg class="w-8 h-8 text-yellow-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-xs font-medium text-gray-700 text-center">Generate Certificate</span>
                </a>
                <a href="{{ route('events.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                    <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-xs font-medium text-gray-700 text-center">Create Event</span>
                </a>
                <a href="{{ route('finance.contributions.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                    <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-xs font-medium text-gray-700 text-center">Record Expense</span>
                </a>
                <a href="{{ route('sms.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200 group">
                    <svg class="w-8 h-8 text-indigo-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span class="text-xs font-medium text-gray-700 text-center">Send SMS</span>
                </a>
            </div>
        </div>

        <!-- Financial Year Selector & System Health -->
        <div class="space-y-6">
            <!-- Financial Year Selector -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Financial Year</h2>
                <div class="relative">
                    <select class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 appearance-none bg-white">
                        <option selected>2026/2027 (Active)</option>
                        <option>2025/2026 (Closed)</option>
                        <option>2024/2025 (Closed)</option>
                        <option>2023/2024 (Closed)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('settings.financial-years.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Manage Financial Years →</a>
                </div>
            </div>

            <!-- System Health Indicator -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">System Health</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Database</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Connected</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Last Backup</span>
                        </div>
                        <span class="text-xs text-gray-600">2 hours ago</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">NextSMS API</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Snipe API</span>
                        </div>
                        <span class="text-xs text-yellow-600 font-medium">Slow</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Click Pesa</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart defaults
    Chart.defaults.font.family = 'system-ui, -apple-system, sans-serif';
    Chart.defaults.color = '#374151';
    
    // Contributions Trend Chart
    const contributionsCtx = document.getElementById('contributionsChart').getContext('2d');
    new Chart(contributionsCtx, {
        type: 'line',
        data: {
            labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Contributions',
                data: [180000, 210000, 195000, 220000, 235000, 245000, 190000, 225000, 240000, 260000, 280000, 290000],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'TZS ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'TZS ' + (value / 1000) + 'K';
                        }
                    }
                }
            }
        }
    });
    
    // Member Growth Chart
    const memberGrowthCtx = document.getElementById('memberGrowthChart').getContext('2d');
    new Chart(memberGrowthCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'New Members',
                data: [38, 42, 35, 48, 45, 52, 41, 47, 39, 44, 50, 46],
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }
    });
    
    // Certificates by Type Chart
    const certificatesCtx = document.getElementById('certificatesChart').getContext('2d');
    new Chart(certificatesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Finalist', 'Group', 'Leadership', 'Event'],
            datasets: [{
                data: [45, 30, 15, 10],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(251, 146, 60, 0.8)'
                ],
                borderColor: [
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(168, 85, 247)',
                    'rgb(251, 146, 60)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
    
    // Event Attendance Rate Chart
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'radar',
        data: {
            labels: ['Sunday Mass', 'Youth Meeting', 'Women Group', 'Men Group', 'Bible Study', 'Prayer Meeting'],
            datasets: [{
                label: 'Attendance Rate (%)',
                data: [85, 72, 68, 75, 80, 78],
                borderColor: 'rgb(251, 146, 60)',
                backgroundColor: 'rgba(251, 146, 60, 0.2)',
                borderWidth: 2,
                pointBackgroundColor: 'rgb(251, 146, 60)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(251, 146, 60)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20
                    }
                }
            }
        }
    });
});
</script>
@endsection
