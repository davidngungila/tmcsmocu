@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">➕ Create Group</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Create a new parish group or community</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('groups.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Groups
            </a>
        </div>
    </div>

    <!-- Create Group Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('groups.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Group Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Group Name *</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter group name">
                </div>

                <!-- Group Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Group Type *</label>
                    <select id="type" name="type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select group type</option>
                        <option value="apostolic">Apostolic Group</option>
                        <option value="community">Community</option>
                        <option value="ministry">Ministry</option>
                        <option value="service">Service Group</option>
                        <option value="youth">Youth Group</option>
                        <option value="women">Women Group</option>
                        <option value="men">Men Group</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Leader -->
                <div>
                    <label for="leader_id" class="block text-sm font-medium text-gray-700 mb-2">Group Leader</label>
                    <select id="leader_id" name="leader_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select group leader (optional)</option>
                        <!-- This would be populated with parishioners in a real implementation -->
                    </select>
                </div>

                <!-- Meeting Day -->
                <div>
                    <label for="meeting_day" class="block text-sm font-medium text-gray-700 mb-2">Meeting Day</label>
                    <select id="meeting_day" name="meeting_day"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select meeting day</option>
                        <option value="sunday">Sunday</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                    </select>
                </div>

                <!-- Meeting Time -->
                <div>
                    <label for="meeting_time" class="block text-sm font-medium text-gray-700 mb-2">Meeting Time</label>
                    <input type="time" id="meeting_time" name="meeting_time"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- Meeting Location -->
                <div>
                    <label for="meeting_location" class="block text-sm font-medium text-gray-700 mb-2">Meeting Location</label>
                    <input type="text" id="meeting_location" name="meeting_location"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter meeting location">
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Describe the group's purpose and activities"></textarea>
            </div>

            <!-- Status -->
            <div class="mt-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2 text-sm text-gray-700">Active Group</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full md:w-auto px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Group
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
