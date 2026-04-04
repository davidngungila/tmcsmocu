@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Church Leader Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Community leadership and member coordination</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="hidden sm:inline">Home > Church Leader Dashboard</span>
            <span class="sm:hidden">Church Leader Dashboard</span>
        </div>
    </div>
    
    <!-- Community Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Community Members -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Community Members</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ $communityMembers ?? 156 }}</p>
                    <p class="text-xs text-blue-600 mt-1">{{ $activeMembers ?? 142 }} active</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Group Activities -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">Group Activities</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">{{ $groupActivities ?? 8 }}</p>
                    <p class="text-xs text-green-600 mt-1">This month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Attendance Rate -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Attendance Rate</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">{{ $attendanceRate ?? 82 }}%</p>
                    <p class="text-xs text-purple-600 mt-1">Average this month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Outreach Programs -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Outreach Programs</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">{{ $outreachPrograms ?? 5 }}</p>
                    <p class="text-xs text-orange-600 mt-1">Active programs</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Community Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Member Groups -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Member Groups</h3>
                <a href="{{ route('groups.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Manage Groups</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Choir Group</p>
                                <p class="text-xs text-gray-500">45 members • 92% attendance</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Legion of Mary</p>
                                <p class="text-xs text-gray-500">28 members • 88% attendance</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-orange-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Youth Ministry</p>
                                <p class="text-xs text-gray-500">67 members • 78% attendance</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Catechists</p>
                                <p class="text-xs text-gray-500">16 members • 95% attendance</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Community Events -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Upcoming Community Events</h3>
                <a href="{{ route('events.create') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Create Event</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Community Prayer Meeting</p>
                            <p class="text-xs text-gray-500">Tomorrow • 6:00 PM</p>
                            <p class="text-xs text-gray-400">All groups invited</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">Prayer</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Community Service Day</p>
                            <p class="text-xs text-gray-500">Saturday • 8:00 AM</p>
                            <p class="text-xs text-gray-400">45 volunteers registered</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Service</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Leadership Training</p>
                            <p class="text-xs text-gray-500">Next Week • 2:00 PM</p>
                            <p class="text-xs text-gray-400">Group leaders only</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Training</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Community Fellowship</p>
                            <p class="text-xs text-gray-500">Next Sunday • 4:00 PM</p>
                            <p class="text-xs text-gray-400">Potluck dinner</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Fellowship</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Member Engagement -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Member Engagement Overview</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">New Members</h4>
                <p class="text-2xl font-bold text-blue-900">{{ $newMembersThisMonth ?? 12 }}</p>
                <p class="text-xs text-blue-600 mt-1">Joined this month</p>
                <div class="mt-2">
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                    <p class="text-xs text-blue-600 mt-1">75% retention rate</p>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-green-800 mb-2">Active Volunteers</h4>
                <p class="text-2xl font-bold text-green-900">{{ $activeVolunteers ?? 38 }}</p>
                <p class="text-xs text-green-600 mt-1">Regular volunteers</p>
                <div class="mt-2">
                    <div class="w-full bg-green-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 88%"></div>
                    </div>
                    <p class="text-xs text-green-600 mt-1">88% participation</p>
                </div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-purple-800 mb-2">Small Groups</h4>
                <p class="text-2xl font-bold text-purple-900">{{ $smallGroups ?? 8 }}</p>
                <p class="text-xs text-purple-600 mt-1">Active groups</p>
                <div class="mt-2">
                    <div class="w-full bg-purple-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 82%"></div>
                    </div>
                    <p class="text-xs text-purple-600 mt-1">82% group attendance</p>
                </div>
            </div>
            <div class="bg-orange-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-orange-800 mb-2">Outreach Impact</h4>
                <p class="text-2xl font-bold text-orange-900">{{ $outreachImpact ?? 156 }}</p>
                <p class="text-xs text-orange-600 mt-1">People served</p>
                <div class="mt-2">
                    <div class="w-full bg-orange-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full" style="width: 92%"></div>
                    </div>
                    <p class="text-xs text-orange-600 mt-1">92% satisfaction</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Recent Community Activities</h3>
            <a href="{{ route('activities.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
        </div>
        <div class="p-4">
            <div class="space-y-3">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Choir Performance - Sunday Mass</p>
                        <p class="text-xs text-gray-500">Yesterday • 8:00 AM</p>
                        <p class="text-xs text-gray-400">Excellent performance, 45 members participated</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Success</span>
                </div>
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Youth Outreach - Local School</p>
                        <p class="text-xs text-gray-500">2 days ago • 2:00 PM</p>
                        <p class="text-xs text-gray-400">15 youth members, 50 students reached</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Outreach</span>
                </div>
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Legion of Mary - Home Visits</p>
                        <p class="text-xs text-gray-500">3 days ago • 10:00 AM</p>
                        <p class="text-xs text-gray-400">8 families visited, prayers and support provided</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">Pastoral</span>
                </div>
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Community Service - Clean-up Drive</p>
                        <p class="text-xs text-gray-500">4 days ago • 7:00 AM</p>
                        <p class="text-xs text-gray-400">30 volunteers, church grounds cleaned</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Service</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Community Leadership Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('groups.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Create Group</span>
            </a>
            <a href="{{ route('events.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Schedule Event</span>
            </a>
            <a href="{{ route('sms.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Send Message</span>
            </a>
            <a href="{{ route('volunteers.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Manage Volunteers</span>
            </a>
            <a href="{{ route('outreach.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-teal-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Plan Outreach</span>
            </a>
            <a href="{{ route('reports.community') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-pink-50 hover:border-pink-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-pink-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2m-3-4h.01M9 16h.01"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">View Reports</span>
            </a>
        </div>
    </div>
</div>
@endsection
