@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📋 Parishioner Directory</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Complete directory of all registered parishioners</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('parishioners.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Management
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Parishioners</label>
                <input type="text" id="search" name="search" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Search by name, registration number...">
            </div>
            <div>
                <label for="member_type" class="block text-sm font-medium text-gray-700 mb-2">Member Type</label>
                <select id="member_type" name="member_type" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Types</option>
                    <option value="student">Student</option>
                    <option value="employee">Employee</option>
                    <option value="child">Child</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label for="academic_programme" class="block text-sm font-medium text-gray-700 mb-2">Academic Programme</label>
                <select id="academic_programme" name="academic_programme" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Programmes</option>
                    <option value="Certificate">Certificate</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Bachelor">Bachelor</option>
                    <option value="Master">Master</option>
                    <option value="PhD">PhD</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Parishioners List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Parishioners Directory</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $parishioners->total() }} registered parishioners</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($parishioners as $parishioner)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                            <span class="text-purple-600 font-medium">{{ substr($parishioner->first_name, 0, 1) }}{{ substr($parishioner->last_name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $parishioner->first_name }} {{ $parishioner->middle_name }} {{ $parishioner->last_name }}
                                        </div>
                                        @if($parishioner->registration_number)
                                            <div class="text-sm text-gray-500">{{ $parishioner->registration_number }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $parishioner->member_type == 'student' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $parishioner->member_type == 'employee' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $parishioner->member_type == 'child' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $parishioner->member_type == 'other' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($parishioner->member_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($parishioner->contact_number)
                                    {{ $parishioner->contact_number }}
                                @else
                                    <span class="text-gray-400">No contact</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $parishioner->registration_date ? $parishioner->registration_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $parishioner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $parishioner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('parishioners.show', $parishioner->id) }}" class="text-purple-600 hover:text-purple-900 mr-3">View</a>
                                <a href="{{ route('parishioners.edit', $parishioner->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900 mb-1">No parishioners found</p>
                                    <p class="text-sm text-gray-500 mb-4">No parishioners match your search criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($parishioners->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $parishioners->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
