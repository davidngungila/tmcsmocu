@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Member Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Your personal parish activity overview</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="hidden sm:inline">Home > Member Dashboard</span>
            <span class="sm:hidden">Member Dashboard</span>
        </div>
    </div>
    
    <!-- Personal Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Profile Completion -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Profile Completion</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ $profileCompletion ?? 85 }}%</p>
                    <p class="text-xs text-blue-600 mt-1">Completed</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Contributions -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">Contributions</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">TZS {{ number_format($contributions ?? 45000, 0, '.', ',') }}</p>
                    <p class="text-xs text-green-600 mt-1">Total this year</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Certificates -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Certificates</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">{{ $certificates ?? 3 }}</p>
                    <p class="text-xs text-purple-600 mt-1">Received</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Events -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Upcoming Events</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">{{ $upcomingEvents ?? 5 }}</p>
                    <p class="text-xs text-orange-600 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Profile Status -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Profile Status</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Personal Information</span>
                    <span class="text-xs text-gray-500">Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Contact Details</span>
                    <span class="text-xs text-gray-500">Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Academic Information</span>
                    <span class="text-xs text-gray-500">Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Spiritual Groups</span>
                    <span class="text-xs text-gray-500">Not Joined</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-600 h-2 rounded-full" style="width: 40%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Certificates -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Recent Certificates</h3>
                <a href="{{ route('certificates.my') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Leadership Certificate</p>
                            <p class="text-xs text-gray-500">Issued: 2 weeks ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Achievement Certificate</p>
                            <p class="text-xs text-gray-500">Issued: 1 month ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Participation Certificate</p>
                            <p class="text-xs text-gray-500">Issued: 2 months ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Events -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Upcoming Events</h3>
                <a href="{{ route('events.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Sunday Mass</p>
                            <p class="text-xs text-gray-500">Tomorrow • 8:00 AM</p>
                            <p class="text-xs text-gray-400">Main Church</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Regular</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Youth Meeting</p>
                            <p class="text-xs text-gray-500">Friday • 5:00 PM</p>
                            <p class="text-xs text-gray-400">Youth Hall</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">Special</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Community Service</p>
                            <p class="text-xs text-gray-500">Next Sunday • 2:00 PM</p>
                            <p class="text-xs text-gray-400">Parish Grounds</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Service</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contribution History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Recent Contributions</h3>
            <a href="{{ route('contributions.history') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View History</a>
        </div>
        <div class="p-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Sunday Collection</p>
                        <p class="text-xs text-gray-500">Last Sunday • 10:30 AM</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-green-600">TZS 5,000</p>
                        <p class="text-xs text-gray-500">Cash</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Building Fund</p>
                        <p class="text-xs text-gray-500">2 weeks ago • 9:00 AM</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-green-600">TZS 10,000</p>
                        <p class="text-xs text-gray-500">Mobile</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Zaka</p>
                        <p class="text-xs text-gray-500">1 month ago • 8:00 AM</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-green-600">TZS 2,500</p>
                        <p class="text-xs text-gray-500">Cash</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Edit Profile</span>
            </a>
            <a href="{{ route('contributions.make') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Make Contribution</span>
            </a>
            <a href="{{ route('events.register') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Register Event</span>
            </a>
            <a href="{{ route('groups.join') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Join Group</span>
            </a>
            <a href="{{ route('certificates.my') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-teal-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">My Certificates</span>
            </a>
            <a href="{{ route('parishioners.directory') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-pink-50 hover:border-pink-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-pink-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Directory</span>
            </a>
        </div>
    </div>
</div>
@endsection
