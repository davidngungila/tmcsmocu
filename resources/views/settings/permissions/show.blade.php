@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('settings.permissions.index') }}" class="text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Role Details: {{ $role->display_name ?? $role->name }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ $role->description }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('settings.permissions.edit', $role->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit Permissions</span>
            </a>
        </div>
    </div>

    <!-- Role Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center rounded-full bg-purple-100">
                    <span class="text-purple-600 font-bold text-xl">{{ substr($role->name, 0, 2) }}</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $role->display_name ?? $role->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $role->slug }}</p>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Access Level</p>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($role->level === 'super_admin') bg-red-100 text-red-800
                    @elseif($role->level === 'leadership') bg-yellow-100 text-yellow-800
                    @elseif($role->level === 'standard') bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($role->level) }}
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Status</p>
                @if($role->is_active)
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                        Inactive
                    </span>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Assigned Users</p>
                <p class="text-lg font-semibold text-gray-900">{{ $role->users()->count() }}</p>
            </div>
        </div>
        @if($role->responsibilities)
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm font-medium text-gray-600 mb-2">Responsibilities</p>
            <p class="text-gray-700">{{ $role->responsibilities }}</p>
        </div>
        @endif
    </div>

    <!-- Permissions Overview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Permissions Overview</h2>
            <p class="text-gray-600 mt-1">Summary of permissions assigned to this role</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-3xl font-bold text-blue-600">{{ $role->permissions()->where('category', 'read')->count() }}</div>
                <div class="text-sm text-blue-800 mt-1">Read Permissions</div>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <div class="text-3xl font-bold text-orange-600">{{ $role->permissions()->where('category', 'write')->count() }}</div>
                <div class="text-sm text-orange-800 mt-1">Write Permissions</div>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-lg">
                <div class="text-3xl font-bold text-red-600">{{ $role->permissions()->where('category', 'admin')->count() }}</div>
                <div class="text-sm text-red-800 mt-1">Admin Permissions</div>
            </div>
        </div>

        <div class="space-y-6">
            @foreach($groupedPermissions as $module => $permissions)
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ ucfirst($module) }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($permissions as $permission)
                    <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm text-gray-700">{{ $permission->display_name }}</span>
                        @if($permission->category === 'admin')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Admin</span>
                        @elseif($permission->category === 'write')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Write</span>
                        @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Read</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
