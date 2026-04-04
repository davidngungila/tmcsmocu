@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">👥 Group Details</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View and manage group information</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('groups.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Groups
            </a>
            <a href="{{ route('groups.edit', $id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Group
            </a>
        </div>
    </div>

    <!-- Group Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center mb-6">
            <div class="flex-shrink-0 h-16 w-16 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-semibold text-gray-800">Group Information</h2>
                <p class="text-sm text-gray-600">Group ID: {{ $id }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Group Details</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Group ID:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Status:</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Created:</span>
                        <span class="text-sm font-medium text-gray-900">N/A</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Statistics</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Total Members:</span>
                        <span class="text-sm font-medium text-gray-900">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Active Members:</span>
                        <span class="text-sm font-medium text-gray-900">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Meetings:</span>
                        <span class="text-sm font-medium text-gray-900">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Group Members -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Group Members</h2>
            <p class="text-sm text-gray-600 mt-1">Manage group membership</p>
        </div>
        
        <div class="p-6">
            <div class="text-center text-gray-500 py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900 mb-1">No members found</p>
                <p class="text-sm text-gray-500">This group doesn't have any members yet</p>
            </div>
        </div>
    </div>
</div>
@endsection
