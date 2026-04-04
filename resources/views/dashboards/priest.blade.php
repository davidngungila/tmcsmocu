@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Priest Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Spiritual oversight and ministry management</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="hidden sm:inline">Home > Priest Dashboard</span>
            <span class="sm:hidden">Priest Dashboard</span>
        </div>
    </div>
    
    <!-- Ministry Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Parishioners -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Total Parishioners</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">{{ number_format($totalParishioners ?? 1248, 0, '.', ',') }}</p>
                    <p class="text-xs text-purple-600 mt-1">Under spiritual care</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Sacraments This Month -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Sacraments</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ $sacramentsThisMonth ?? 28 }}</p>
                    <p class="text-xs text-blue-600 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Mass Attendance -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">Mass Attendance</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">{{ $massAttendance ?? 78 }}%</p>
                    <p class="text-xs text-green-600 mt-1">Average this month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Spiritual Groups -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Spiritual Groups</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">{{ $spiritualGroups ?? 12 }}</p>
                    <p class="text-xs text-orange-600 mt-1">Active groups</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Ministry Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Sacraments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Recent Sacraments</h3>
                <a href="{{ route('finance.sacraments.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Baptism - John Doe</p>
                            <p class="text-xs text-gray-500">Today • 10:00 AM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Baptism</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">First Communion - Mary Smith</p>
                            <p class="text-xs text-gray-500">Yesterday • 2:00 PM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Eucharist</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Confirmation - James Wilson</p>
                            <p class="text-xs text-gray-500">2 days ago • 11:00 AM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">Confirmation</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Marriage - Robert & Sarah</p>
                            <p class="text-xs text-gray-500">3 days ago • 3:00 PM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-pink-100 text-pink-700 rounded-full">Marriage</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Masses -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Upcoming Masses</h3>
                <a href="{{ route('masses.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Sunday Mass</p>
                            <p class="text-xs text-gray-500">Tomorrow • 8:00 AM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">Obligatory</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Daily Mass</p>
                            <p class="text-xs text-gray-500">Tomorrow • 6:30 AM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Daily</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Feast of St. Joseph</p>
                            <p class="text-xs text-gray-500">Friday • 7:00 AM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Feast</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Holy Hour</p>
                            <p class="text-xs text-gray-500">Saturday • 5:00 PM</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Devotional</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Spiritual Groups Overview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Spiritual Groups Overview</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-purple-800 mb-2">Choir</h4>
                <p class="text-2xl font-bold text-purple-900">{{ $choirMembers ?? 45 }}</p>
                <p class="text-xs text-purple-600 mt-1">Active members</p>
                <div class="mt-2">
                    <div class="w-full bg-purple-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="text-xs text-purple-600 mt-1">85% attendance</p>
                </div>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">Legion of Mary</h4>
                <p class="text-2xl font-bold text-blue-900">{{ $legionMembers ?? 28 }}</p>
                <p class="text-xs text-blue-600 mt-1">Active members</p>
                <div class="mt-2">
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 92%"></div>
                    </div>
                    <p class="text-xs text-blue-600 mt-1">92% attendance</p>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-green-800 mb-2">Youth Ministry</h4>
                <p class="text-2xl font-bold text-green-900">{{ $youthMembers ?? 67 }}</p>
                <p class="text-xs text-green-600 mt-1">Active members</p>
                <div class="mt-2">
                    <div class="w-full bg-green-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                    <p class="text-xs text-green-600 mt-1">78% attendance</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ministry Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('finance.sacraments.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Record Sacrament</span>
            </a>
            <a href="{{ route('masses.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Schedule Mass</span>
            </a>
            <a href="{{ route('events.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Create Event</span>
            </a>
            <a href="{{ route('sms.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Send Message</span>
            </a>
            <a href="{{ route('parishioners.index') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-teal-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">View Parishioners</span>
            </a>
            <a href="{{ route('certificates.templates') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-pink-50 hover:border-pink-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-pink-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Certificates</span>
            </a>
        </div>
    </div>
</div>
@endsection
