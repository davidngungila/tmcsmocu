@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Secretary Dashboard</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Administrative coordination and office management</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="hidden sm:inline">Home > Secretary Dashboard</span>
            <span class="sm:hidden">Secretary Dashboard</span>
        </div>
    </div>
    
    <!-- Administrative Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Pending Documents -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-yellow-700 truncate">Pending Documents</p>
                    <p class="text-xl sm:text-2xl font-bold text-yellow-900 mt-2 truncate">{{ $pendingDocuments ?? 15 }}</p>
                    <p class="text-xs text-yellow-600 mt-1">Awaiting processing</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Appointments Today -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Appointments</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ $appointmentsToday ?? 8 }}</p>
                    <p class="text-xs text-blue-600 mt-1">Scheduled today</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Communications Sent -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">Communications</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">{{ $communicationsSent ?? 42 }}</p>
                    <p class="text-xs text-green-600 mt-1">This week</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Records Updated -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Records Updated</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">{{ $recordsUpdated ?? 23 }}</p>
                    <p class="text-xs text-purple-600 mt-1">This week</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Office Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Today's Schedule</h3>
                <a href="{{ route('appointments.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Priest Meeting</p>
                            <p class="text-xs text-gray-500">9:00 AM - 10:00 AM</p>
                            <p class="text-xs text-gray-400">Office Conference Room</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">Meeting</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Document Signing</p>
                            <p class="text-xs text-gray-500">11:00 AM - 11:30 AM</p>
                            <p class="text-xs text-gray-400">Parishioners: John & Mary</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Document</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Baptism Preparation</p>
                            <p class="text-xs text-gray-500">2:00 PM - 3:00 PM</p>
                            <p class="text-xs text-gray-400">5 families attending</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Preparation</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Office Hours</p>
                            <p class="text-xs text-gray-500">3:30 PM - 5:00 PM</p>
                            <p class="text-xs text-gray-400">General parishioner inquiries</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">Office</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Communications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Recent Communications</h3>
                <a href="{{ route('communications.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Sunday Mass Schedule</p>
                            <p class="text-xs text-gray-500">Sent to all parishioners</p>
                            <p class="text-xs text-gray-400">2 hours ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Email</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Youth Meeting Reminder</p>
                            <p class="text-xs text-gray-500">Sent to youth group</p>
                            <p class="text-xs text-gray-400">5 hours ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">SMS</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Feast Day Announcement</p>
                            <p class="text-xs text-gray-500">Sent to choir members</p>
                            <p class="text-xs text-gray-400">Yesterday</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">WhatsApp</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Collection Report</p>
                            <p class="text-xs text-gray-500">Sent to finance committee</p>
                            <p class="text-xs text-gray-400">2 days ago</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Report</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Document Processing -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Processing Queue</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-red-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-red-800 mb-2">Urgent</h4>
                <p class="text-2xl font-bold text-red-900">{{ $urgentDocuments ?? 3 }}</p>
                <p class="text-xs text-red-600 mt-1">Require immediate attention</p>
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-red-700">• Marriage license - John & Sarah</p>
                    <p class="text-xs text-red-700">• Baptism certificate - Baby Emma</p>
                    <p class="text-xs text-red-700">• Sponsor letter - Michael</p>
                </div>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-yellow-800 mb-2">Processing</h4>
                <p class="text-2xl font-bold text-yellow-900">{{ $processingDocuments ?? 7 }}</p>
                <p class="text-xs text-yellow-600 mt-1">Currently being processed</p>
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-yellow-700">• First communion - Mary</p>
                    <p class="text-xs text-yellow-700">• Confirmation - James</p>
                    <p class="text-xs text-yellow-700">• Transfer letter - Robert</p>
                </div>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">Review</h4>
                <p class="text-2xl font-bold text-blue-900">{{ $reviewDocuments ?? 5 }}</p>
                <p class="text-xs text-blue-600 mt-1">Awaiting review</p>
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-blue-700">• Marriage prep - David & Lisa</p>
                    <p class="text-xs text-blue-700">• RCIA application - Susan</p>
                    <p class="text-xs text-blue-700">• Godparent form - Thomas</p>
                </div>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-green-800 mb-2">Completed</h4>
                <p class="text-2xl font-bold text-green-900">{{ $completedDocuments ?? 12 }}</p>
                <p class="text-xs text-green-600 mt-1">Ready for pickup</p>
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-green-700">• Baptism cert - Baby John</p>
                    <p class="text-xs text-green-700">• Marriage cert - Paul & Anna</p>
                    <p class="text-xs text-green-700">• Confirmation cert - Peter</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Office Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('appointments.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Schedule Appointment</span>
            </a>
            <a href="{{ route('documents.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-yellow-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Process Document</span>
            </a>
            <a href="{{ route('communications.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Send Communication</span>
            </a>
            <a href="{{ route('records.index') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Update Records</span>
            </a>
            <a href="{{ route('reports.office') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2m-3-4h.01M9 16h.01"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Office Reports</span>
            </a>
            <a href="{{ route('parishioners.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 group">
                <svg class="w-8 h-8 text-teal-600 mb-2 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="text-xs font-medium text-gray-700 text-center">Register Parishioner</span>
            </a>
        </div>
    </div>
</div>
@endsection
