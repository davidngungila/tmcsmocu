@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Group Leader Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Managing spiritual group activities and members</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="hidden sm:inline">Home > Group Leader Dashboard</span>
            <span class="sm:hidden">Group Leader</span>
        </div>
    </div>
    
    <!-- Group Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Group Members -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Group Members</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ $groupMembers ?? 25 }}</p>
                    <p class="text-xs text-blue-600 mt-1">Total members</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Attendance Rate -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">Attendance Rate</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">{{ $attendanceRate ?? 85 }}%</p>
                    <p class="text-xs text-green-600 mt-1">Average this month</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Meetings -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Upcoming Meetings</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">{{ $upcomingMeetings ?? 2 }}</p>
                    <p class="text-xs text-purple-600 mt-1">This week</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Active Programs -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Active Programs</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">{{ $activePrograms ?? 4 }}</p>
                    <p class="text-xs text-orange-600 mt-1">Ongoing activities</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Group Members List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Group Members</h3>
            <a href="{{ route('groups.members') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Manage Members</a>
        </div>
        <div class="p-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">John Michael</p>
                        <p class="text-xs text-gray-500">Student • BBICT • Year 3</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Sarah Johnson</p>
                        <p class="text-xs text-gray-500">Student • BBICT • Year 2</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">David Wilson</p>
                        <p class="text-xs text-gray-500">Student • BBICT • Year 4</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Inactive</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Mary Brown</p>
                        <p class="text-xs text-gray-500">Student • BBICT • Year 1</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Robert Davis</p>
                        <p class="text-xs text-gray-500">Student • BBICT • Year 3</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Group Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Meetings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Recent Meetings</h3>
                <a href="{{ route('groups.meetings') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Weekly Prayer Meeting</p>
                            <p class="text-xs text-gray-500">Yesterday • 6:00 PM</p>
                            <p class="text-xs text-gray-400">18 members attended</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Completed</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Formation Session</p>
                            <p class="text-xs text-gray-500">3 days ago • 2:00 PM</p>
                            <p class="text-xs text-gray-400">22 members attended</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Completed</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Planning Meeting</p>
                            <p class="text-xs text-gray-500">1 week ago • 4:00 PM</p>
                            <p class="text-xs text-gray-400">15 members attended</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Completed</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Meetings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Upcoming Meetings</h3>
                <a href="{{ route('groups.schedule') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Schedule</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Bible Study Session</p>
                            <p class="text-xs text-gray-500">Tomorrow • 5:00 PM</p>
                            <p class="text-xs text-gray-400">Chapel Room</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Scheduled</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Community Service Planning</p>
                            <p class="text-xs text-gray-500">Friday • 3:00 PM</p>
                            <p class="text-xs text-gray-400">Meeting Room A</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Scheduled</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Monthly Review</p>
                            <p class="text-xs text-gray-500">Next Sunday • 4:00 PM</p>
                            <p class="text-xs text-gray-400">Group Hall</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Scheduled</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Group Programs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Active Programs</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">Prayer Ministry</h4>
                <p class="text-2xl font-bold text-blue-900">12</p>
                <p class="text-xs text-blue-600 mt-1">Active participants</p>
                <div class="mt-2">
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 90%"></div>
                    </div>
                    <p class="text-xs text-blue-600 mt-1">90% completion</p>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-green-800 mb-2">Formation Program</h4>
                <p class="text-2xl font-bold text-green-900">8</p>
                <p class="text-xs text-green-600 mt-1">Active participants</p>
                <div class="mt-2">
                    <div class="w-full bg-green-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                    <p class="text-xs text-green-600 mt-1">75% completion</p>
                </div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-purple-800 mb-2">Service Project</h4>
                <p class="text-2xl font-bold text-purple-900">15</p>
                <p class="text-xs text-purple-600 mt-1">Active participants</p>
                <div class="mt-2">
                    <div class="w-full bg-purple-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                    <p class="text-xs text-purple-600 mt-1">60% completion</p>
                </div>
            </div>
            <div class="bg-orange-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-orange-800 mb-2">Outreach Activity</h4>
                <p class="text-2xl font-bold text-orange-900">10</p>
                <p class="text-xs text-orange-600 mt-1">Active participants</p>
                <div class="mt-2">
                    <div class="w-full bg-orange-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                    <p class="text-xs text-orange-600 mt-1">45% completion</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Group Leader Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('groups.meetings.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Schedule Meeting</span>
            </a>
            <a href="{{ route('groups.members.add') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Add Member</span>
            </a>
            <a href="{{ route('groups.programs.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Create Program</span>
            </a>
            <a href="{{ route('sms.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Send Message</span>
            </a>
            <a href="{{ route('reports.group') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 group">
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
