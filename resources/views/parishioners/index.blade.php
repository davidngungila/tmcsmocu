@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">All Members</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage parishioners, students, employees, and children</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('parishioners.import') }}" class="bg-green-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold hover:bg-green-700 transition-colors shadow-sm text-sm sm:text-base whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Import Members
            </a>
            <a href="{{ route('parishioners.create') }}" class="bg-purple-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors shadow-sm text-sm sm:text-base whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Register Member
            </a>
        </div>
    </div>
    
    <!-- Member Type Tabs -->
    <div class="flex flex-wrap gap-2 sm:gap-4">
        <a href="{{ route('parishioners.index') }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold text-sm sm:text-base transition-colors {{ request('type') === null ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            All Members
        </a>
        <a href="{{ route('parishioners.index', ['type' => 'student']) }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold text-sm sm:text-base transition-colors {{ request('type') === 'student' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Students
        </a>
        <a href="{{ route('parishioners.index', ['type' => 'employee']) }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold text-sm sm:text-base transition-colors {{ request('type') === 'employee' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Employees
        </a>
        <a href="{{ route('parishioners.index', ['type' => 'child']) }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold text-sm sm:text-base transition-colors {{ request('type') === 'child' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Children
        </a>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-3 sm:p-4 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-blue-700 truncate">Total Members</p>
                    <p class="text-lg sm:text-xl font-bold text-blue-900 mt-1 truncate">{{ number_format($totalParishioners ?? 0) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-3 sm:p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-green-700 truncate">Active</p>
                    <p class="text-lg sm:text-xl font-bold text-green-900 mt-1 truncate">{{ number_format($activeParishioners ?? 0) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-3 sm:p-4 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-purple-700 truncate">Students</p>
                    <p class="text-lg sm:text-xl font-bold text-purple-900 mt-1 truncate">{{ number_format($studentCount ?? 0) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-3 sm:p-4 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-green-700 truncate">Employees</p>
                    <p class="text-lg sm:text-xl font-bold text-green-900 mt-1 truncate">{{ number_format($employeeCount ?? 0) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-3 sm:p-4 border border-yellow-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-yellow-700 truncate">Children</p>
                    <p class="text-lg sm:text-xl font-bold text-yellow-900 mt-1 truncate">{{ number_format($childCount ?? 0) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-3 sm:p-4 border border-red-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-red-700 truncate">Inactive</p>
                    <p class="text-lg sm:text-xl font-bold text-red-900 mt-1 truncate">{{ number_format($inactiveParishioners ?? 0) }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Advanced Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('parishioners.index') }}" class="space-y-4">
            <!-- Search Row -->
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, registration number, phone, or email..." class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium text-sm whitespace-nowrap">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                    @if(request()->hasAny(['search', 'type', 'gender', 'status', 'academic_programme', 'department']))
                    <a href="{{ route('parishioners.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm whitespace-nowrap">
                        Clear All
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Filter Options Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <select name="type" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="student" {{ request('type') === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="employee" {{ request('type') === 'employee' ? 'selected' : '' }}>Employee</option>
                    <option value="child" {{ request('type') === 'child' ? 'selected' : '' }}>Child</option>
                </select>
                
                <select name="gender" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Genders</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
                
                <select name="status" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                
                <select name="academic_programme" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Programmes</option>
                    <option value="BBICT" {{ request('academic_programme') === 'BBICT' ? 'selected' : '' }}>BBICT</option>
                    <option value="BAPSM" {{ request('academic_programme') === 'BAPSM' ? 'selected' : '' }}>BAPSM</option>
                    <option value="LL.B" {{ request('academic_programme') === 'LL.B' ? 'selected' : '' }}>LL.B</option>
                    <option value="BHRM" {{ request('academic_programme') === 'BHRM' ? 'selected' : '' }}>BHRM</option>
                    <option value="BBA" {{ request('academic_programme') === 'BBA' ? 'selected' : '' }}>BBA</option>
                    <option value="BED" {{ request('academic_programme') === 'BED' ? 'selected' : '' }}>BED</option>
                </select>
                
                <select name="department" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Departments</option>
                    <option value="Academic" {{ request('department') === 'Academic' ? 'selected' : '' }}>Academic</option>
                    <option value="Finance" {{ request('department') === 'Finance' ? 'selected' : '' }}>Finance</option>
                    <option value="Administration" {{ request('department') === 'Administration' ? 'selected' : '' }}>Administration</option>
                    <option value="Library" {{ request('department') === 'Library' ? 'selected' : '' }}>Library</option>
                    <option value="ICT" {{ request('department') === 'ICT' ? 'selected' : '' }}>ICT</option>
                    <option value="Chaplaincy" {{ request('department') === 'Chaplaincy' ? 'selected' : '' }}>Chaplaincy</option>
                    <option value="Maintenance" {{ request('department') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                
                <select name="year_of_study" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Years</option>
                    <option value="1" {{ request('year_of_study') === '1' ? 'selected' : '' }}>Year 1</option>
                    <option value="2" {{ request('year_of_study') === '2' ? 'selected' : '' }}>Year 2</option>
                    <option value="3" {{ request('year_of_study') === '3' ? 'selected' : '' }}>Year 3</option>
                    <option value="4" {{ request('year_of_study') === '4' ? 'selected' : '' }}>Year 4</option>
                    <option value="alumni" {{ request('year_of_study') === 'alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
            </div>
        </form>
    </div>
    
    <!-- Bulk Actions Panel -->
    <div id="bulkActionsPanel" class="hidden bg-yellow-50 border border-yellow-200 rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-yellow-800">
                    <span id="selectedCount">0</span> members selected
                </span>
                <div class="flex gap-2">
                    <button onclick="bulkAction('activate')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                        Activate Selected
                    </button>
                    <button onclick="bulkAction('deactivate')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                        Deactivate Selected
                    </button>
                    <button onclick="bulkAction('export')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                        Export Selected
                    </button>
                </div>
            </div>
            <button onclick="toggleBulkActions()" class="text-yellow-600 hover:text-yellow-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Parishioners Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="text-sm text-gray-700">Select all</span>
                <button onclick="toggleBulkActions()" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Bulk Actions
                </button>
            </div>
            <div class="text-sm text-gray-500">
                Showing {{ $parishioners->count() }} of {{ $parishioners->total() }} members
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-10">
                            <input type="checkbox" id="headerSelectAll" onchange="toggleSelectAll()" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider min-w-[200px]">Member</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-20">Type</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider min-w-[150px]">Contact</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-28">Date</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-16">Status</th>
                        <th class="px-3 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-20">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($parishioners as $parishioner)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-3 py-3 whitespace-nowrap">
                            <input type="checkbox" name="selected_members[]" value="{{ $parishioner->id }}" class="member-checkbox rounded border-gray-300 text-purple-600 focus:ring-purple-500" onchange="updateSelectedCount()">
                        </td>
                        <td class="px-3 py-3">
                            <div class="flex items-center min-w-0">
                                @if($parishioner->photo)
                                <img src="{{ asset('storage/photos/' . $parishioner->photo) }}" alt="{{ $parishioner->full_name }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                @else
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-purple-600 font-bold text-xs">{{ strtoupper(substr($parishioner->first_name, 0, 1)) }}</span>
                                </div>
                                @endif
                                <div class="ml-2 min-w-0 flex-1">
                                    <div class="text-sm font-bold text-gray-900 truncate">{{ $parishioner->full_name }}</div>
                                    @if($parishioner->email)
                                    <div class="text-xs text-gray-500 truncate">{{ $parishioner->email }}</div>
                                    @endif
                                    @if($parishioner->member_type === 'student' && $parishioner->registration_number)
                                    <div class="text-xs text-blue-600 truncate">{{ $parishioner->registration_number }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                $parishioner->member_type === 'student' ? 'bg-blue-100 text-blue-800' : 
                                ($parishioner->member_type === 'employee' ? 'bg-green-100 text-green-800' : 
                                'bg-yellow-100 text-yellow-800') 
                            }}">
                                {{ ucfirst($parishioner->member_type ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-3 py-3">
                            <div class="text-sm text-gray-900 truncate">{{ $parishioner->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">
                            {{ $parishioner->created_at ? $parishioner->created_at->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $parishioner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $parishioner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('parishioners.show', $parishioner->id) }}" class="text-purple-600 hover:text-purple-900 p-1 rounded hover:bg-purple-50" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('parishioners.edit', $parishioner->id) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('parishioners.destroy', $parishioner->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this parishioner?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-sm font-medium">No members found</p>
                                <p class="text-xs text-gray-400 mt-1">Try adjusting your filters or register a new member</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($parishioners->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $parishioners->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function toggleSelectAll() {
    const checkboxes = document.querySelectorAll('.member-checkbox');
    const selectAll = document.getElementById('selectAll') || document.getElementById('headerSelectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.member-checkbox:checked');
    const count = checkboxes.length;
    document.getElementById('selectedCount').textContent = count;
    
    // Show/hide bulk actions panel
    const panel = document.getElementById('bulkActionsPanel');
    if (count > 0) {
        panel.classList.remove('hidden');
    } else {
        panel.classList.add('hidden');
    }
}

function toggleBulkActions() {
    const panel = document.getElementById('bulkActionsPanel');
    panel.classList.toggle('hidden');
}

function bulkAction(action) {
    const checkboxes = document.querySelectorAll('.member-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        alert('Please select at least one member');
        return;
    }
    
    if (action === 'activate' || action === 'deactivate') {
        if (confirm(`Are you sure you want to ${action} ${ids.length} member(s)?`)) {
            // Submit bulk action form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/parishioners/bulk-' + action;
            
            // Add CSRF token
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrf);
            
            // Add selected IDs
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    } else if (action === 'export') {
        // Export functionality
        window.open('/parishioners/export?ids=' + ids.join(','));
    }
}

// Sync both select all checkboxes
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.getElementById('headerSelectAll').checked = this.checked;
    toggleSelectAll();
});

document.getElementById('headerSelectAll')?.addEventListener('change', function() {
    document.getElementById('selectAll').checked = this.checked;
    toggleSelectAll();
});
</script>
@endsection
