@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Event Chairperson Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Managing events and coordinating activities</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="hidden sm:inline">Home > Event Chairperson Dashboard</span>
            <span class="sm:hidden">Event Chairperson</span>
        </div>
    </div>
    
    <!-- Event Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Managed Events -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Managed Events</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ $managedEvents ?? 3 }}</p>
                    <p class="text-xs text-blue-600 mt-1">Active events</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Attendees -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">Total Attendees</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">{{ $totalAttendees ?? 156 }}</p>
                    <p class="text-xs text-green-600 mt-1">All events</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Events -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Upcoming Events</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">{{ $upcomingEvents ?? 2 }}</p>
                    <p class="text-xs text-purple-600 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Pending Tasks -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Pending Tasks</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">{{ $pendingTasks ?? 8 }}</p>
                    <p class="text-xs text-orange-600 mt-1">Require attention</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Managed Events -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Managed Events</h3>
            <a href="{{ route('events.create') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Create Event</a>
        </div>
        <div class="p-4">
            <div class="space-y-3">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Annual Parish Festival</p>
                        <p class="text-xs text-gray-500">Next Sunday • 10:00 AM - 6:00 PM</p>
                        <p class="text-xs text-gray-400">Expected 200+ attendees</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Planning</span>
                </div>
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Youth Retreat</p>
                        <p class="text-xs text-gray-500">Next Month • 2:00 PM - 8:00 PM</p>
                        <p class="text-xs text-gray-400">45 registered</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Registration</span>
                </div>
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Community Service Day</p>
                        <p class="text-xs text-gray-500">2 weeks from now • 8:00 AM - 5:00 PM</p>
                        <p class="text-xs text-gray-400">Open to all</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Confirmed</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Event Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Event Tasks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Pending Tasks</h3>
                <a href="{{ route('events.tasks') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Book venue for Annual Festival</p>
                            <p class="text-xs text-gray-500">Due in 3 days</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Urgent</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Confirm catering arrangements</p>
                            <p class="text-xs text-gray-500">Due in 5 days</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Send reminder notifications</p>
                            <p class="text-xs text-gray-500">Due in 1 week</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Scheduled</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Prepare event materials</p>
                            <p class="text-xs text-gray-500">Due in 2 weeks</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded-full">In Progress</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Event Volunteers -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Event Volunteers</h3>
                <a href="{{ route('events.volunteers') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Manage</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">John Michael</p>
                            <p class="text-xs text-gray-500">Setup & Logistics • Annual Festival</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Confirmed</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Sarah Johnson</p>
                            <p class="text-xs text-gray-500">Registration • Youth Retreat</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Confirmed</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">David Wilson</p>
                            <p class="text-xs text-gray-500">Food Service • Community Service</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Mary Brown</p>
                            <p class="text-xs text-gray-500">Photography • Annual Festival</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Confirmed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Event Statistics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Event Performance Overview</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">Average Attendance</h4>
                <p class="text-2xl font-bold text-blue-900">78%</p>
                <p class="text-xs text-blue-600 mt-1">Of registered attendees</p>
                <div class="mt-2">
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                    <p class="text-xs text-blue-600 mt-1">Good performance</p>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-green-800 mb-2">Event Satisfaction</h4>
                <p class="text-2xl font-bold text-green-900">4.5/5</p>
                <p class="text-xs text-green-600 mt-1">Average rating</p>
                <div class="mt-2">
                    <div class="w-full bg-green-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 90%"></div>
                    </div>
                    <p class="text-xs text-green-600 mt-1">Excellent feedback</p>
                </div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-purple-800 mb-2">Volunteer Engagement</h4>
                <p class="text-2xl font-bold text-purple-900">85%</p>
                <p class="text-xs text-purple-600 mt-1">Participation rate</p>
                <div class="mt-2">
                    <div class="w-full bg-purple-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="text-xs text-purple-600 mt-1">High engagement</p>
                </div>
            </div>
            <div class="bg-orange-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-orange-800 mb-2">Budget Utilization</h4>
                <p class="text-2xl font-bold text-orange-900">72%</p>
                <p class="text-xs text-orange-600 mt-1">Of allocated budget</p>
                <div class="mt-2">
                    <div class="w-full bg-orange-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full" style="width: 72%"></div>
                    </div>
                    <p class="text-xs text-orange-600 mt-1">Within budget</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Event Management Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('events.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Create Event</span>
            </a>
            <a href="{{ route('events.tasks.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Add Task</span>
            </a>
            <a href="{{ route('events.volunteers.add') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Add Volunteer</span>
            </a>
            <a href="{{ route('sms.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Send Notification</span>
            </a>
            <a href="{{ route('events.reports') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-teal-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2m-3-4h.01M9 16h.01"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">View Reports</span>
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
