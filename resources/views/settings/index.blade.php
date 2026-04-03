@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">System Settings</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage system configuration and preferences</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-1.756.426-1.756 2.924 0 3.35a1.724 1.724 0 001.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065 1.756-.426 1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.572c-1.543-.94-3.31.826-2.37 2.37a1.724 1.724 0 00-2.572-1.065c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996-.608 2.296-.07 2.572 1.065 1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.572c-1.756.426-1.756 2.924 0 3.35z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="hidden sm:inline">Settings > System Settings</span>
            <span class="sm:hidden">System Settings</span>
        </div>
    </div>

    <!-- System Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- System Status -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 sm:p-6 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">System Status</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">Healthy</p>
                    <p class="text-xs text-green-600 mt-1">Uptime: 99.9%</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Active Users -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 sm:p-6 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Active Users</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">{{ number_format($activeUsers ?? 0) }}</p>
                    <p class="text-xs text-blue-600 mt-1">Online now</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Storage Usage -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 sm:p-6 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Storage Used</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">2.4 GB</p>
                    <p class="text-xs text-purple-600 mt-1">of 10 GB</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Last Backup -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 sm:p-6 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Last Backup</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">2 hrs</p>
                    <p class="text-xs text-orange-600 mt-1">ago</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Settings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Roles & Permissions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('settings.roles') }}'">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Roles & Permissions</h3>
                    <p class="text-sm text-gray-600">Manage user roles and permissions</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Roles</span>
                    <span class="font-semibold text-gray-800">{{ $totalRoles ?? 5 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Active Users</span>
                    <span class="font-semibold text-gray-800">{{ $totalUsers ?? 0 }}</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <button class="text-purple-600 hover:text-purple-700 font-medium text-sm">Manage Roles →</button>
            </div>
        </div>

        <!-- System Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('settings.system') }}'">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-1.756.426-1.756 2.924 0 3.35a1.724 1.724 0 001.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065 1.756-.426 1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.572c-1.543-.94-3.31.826-2.37 2.37a1.724 1.724 0 00-2.572-1.065c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996-.608 2.296-.07 2.572 1.065 1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.572c-1.756.426-1.756 2.924 0 3.35z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">System Settings</h3>
                    <p class="text-sm text-gray-600">Configure system preferences</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">App Version</span>
                    <span class="font-semibold text-gray-800">v2.1.0</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Environment</span>
                    <span class="font-semibold text-green-600">Production</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <button class="text-blue-600 hover:text-blue-700 font-medium text-sm">Configure →</button>
            </div>
        </div>

        <!-- Financial Year Setup -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('settings.financial-year') }}'">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Financial Year Setup</h3>
                    <p class="text-sm text-gray-600">Manage financial year periods</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Current FY</span>
                    <span class="font-semibold text-gray-800">2026/2027</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Status</span>
                    <span class="font-semibold text-green-600">Active</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <button class="text-green-600 hover:text-green-700 font-medium text-sm">Manage Years →</button>
            </div>
        </div>

        <!-- Backup & Restore -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('settings.backup') }}'">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Backup & Restore</h3>
                    <p class="text-sm text-gray-600">System backup management</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Last Backup</span>
                    <span class="font-semibold text-gray-800">2 hrs ago</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Auto Backup</span>
                    <span class="font-semibold text-green-600">Enabled</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <button class="text-orange-600 hover:text-orange-700 font-medium text-sm">Manage Backups →</button>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('settings.activity-log') }}'">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Activity Log</h3>
                    <p class="text-sm text-gray-600">View system activity history</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Today's Activities</span>
                    <span class="font-semibold text-gray-800">{{ $todayActivities ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Logs</span>
                    <span class="font-semibold text-gray-800">{{ $totalLogs ?? 0 }}</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <button class="text-red-600 hover:text-red-700 font-medium text-sm">View Logs →</button>
            </div>
        </div>

        <!-- System Health -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('settings.health') }}'">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">System Health</h3>
                    <p class="text-sm text-gray-600">Monitor system performance</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Health Score</span>
                    <span class="font-semibold text-green-600">98%</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Issues</span>
                    <span class="font-semibold text-gray-800">0</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <button class="text-teal-600 hover:text-teal-700 font-medium text-sm">Check Health →</button>
            </div>
        </div>
    </div>

    <!-- Recent System Activities -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Recent System Activities</h2>
            <a href="{{ route('settings.activity-log') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($recentActivities ?? [] as $activity)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $activity->description }}</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs text-gray-500">{{ $activity->created_at->format('M d, Y H:i') }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $activity->type === 'info' ? 'bg-blue-100 text-blue-700' : ($activity->type === 'warning' ? 'bg-yellow-100 text-yellow-700' : ($activity->type === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700')) }}">
                                {{ ucfirst($activity->type) }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-xs text-gray-500">{{ $activity->user->name ?? 'System' }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm">No recent activities</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
