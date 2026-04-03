@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">System Health</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Monitor system performance and health status</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span class="hidden sm:inline">Settings > System Health</span>
            <span class="sm:hidden">System Health</span>
        </div>
    </div>

    <!-- Overall Health Score -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">System Health Score</h2>
                <p class="text-green-100 text-4xl font-bold">98%</p>
                <div class="flex items-center mt-3 space-x-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>All systems operational</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Last check: 2 mins ago</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-white/20 rounded-lg px-4 py-2">
                    <p class="text-sm text-green-100">Status</p>
                    <p class="text-xl font-bold">HEALTHY</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Health Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 sm:p-6 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-green-700 truncate">CPU Usage</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2 truncate">24%</p>
                    <p class="text-xs text-green-600 mt-1">Normal</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 sm:p-6 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-blue-700 truncate">Memory Usage</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-900 mt-2 truncate">67%</p>
                    <p class="text-xs text-blue-600 mt-1">4.2 GB / 6.3 GB</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 sm:p-6 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-purple-700 truncate">Disk Usage</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2 truncate">42%</p>
                    <p class="text-xs text-purple-600 mt-1">12.6 GB / 30 GB</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 sm:p-6 border border-orange-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-orange-700 truncate">Database</p>
                    <p class="text-xl sm:text-2xl font-bold text-orange-900 mt-2 truncate">Healthy</p>
                    <p class="text-xs text-orange-600 mt-1">0.8ms response</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0 ml-2">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- System Components Health -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">System Components</h2>
            <button class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <!-- Web Server -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Web Server</h3>
                                <p class="text-sm text-gray-600">Apache/2.4.58</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Healthy</span>
                            <p class="text-xs text-gray-500 mt-1">Uptime: 99.9%</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Response Time:</span>
                            <span class="font-medium text-gray-800">120ms</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Connections:</span>
                            <span class="font-medium text-gray-800">45 / 150</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Load Average:</span>
                            <span class="font-medium text-gray-800">0.42</span>
                        </div>
                    </div>
                </div>

                <!-- Database -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Database</h3>
                                <p class="text-sm text-gray-600">MySQL 8.0.33</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Healthy</span>
                            <p class="text-xs text-gray-500 mt-1">Connections: 12/100</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Query Time:</span>
                            <span class="font-medium text-gray-800">0.8ms</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Size:</span>
                            <span class="font-medium text-gray-800">2.4 GB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Slow Queries:</span>
                            <span class="font-medium text-gray-800">0</span>
                        </div>
                    </div>
                </div>

                <!-- PHP -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">PHP</h3>
                                <p class="text-sm text-gray-600">PHP 8.4.5</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Healthy</span>
                            <p class="text-xs text-gray-500 mt-1">Memory Limit: 512M</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Memory Usage:</span>
                            <span class="font-medium text-gray-800">128M / 512M</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Max Execution:</span>
                            <span class="font-medium text-gray-800">30s</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">OPcache:</span>
                            <span class="font-medium text-green-600">Enabled</span>
                        </div>
                    </div>
                </div>

                <!-- Cache -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Cache System</h3>
                                <p class="text-sm text-gray-600">Redis 6.2.7</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Healthy</span>
                            <p class="text-xs text-gray-500 mt-1">Hit Rate: 94%</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Memory Usage:</span>
                            <span class="font-medium text-gray-800">245MB / 512MB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Keys:</span>
                            <span class="font-medium text-gray-800">1,247</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Operations/sec:</span>
                            <span class="font-medium text-gray-800">2,340</span>
                        </div>
                    </div>
                </div>

                <!-- Storage -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Storage</h3>
                                <p class="text-sm text-gray-600">Local File System</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">Warning</span>
                            <p class="text-xs text-gray-500 mt-1">42% used</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Space:</span>
                            <span class="font-medium text-gray-800">30 GB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Used Space:</span>
                            <span class="font-medium text-gray-800">12.6 GB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Free Space:</span>
                            <span class="font-medium text-gray-800">17.4 GB</span>
                        </div>
                    </div>
                </div>

                <!-- Email Service -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Email Service</h3>
                                <p class="text-sm text-gray-600">SMTP (Gmail)</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Healthy</span>
                            <p class="text-xs text-gray-500 mt-1">Last sent: 5 mins ago</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium text-green-600">Connected</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sent Today:</span>
                            <span class="font-medium text-gray-800">47</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Failed:</span>
                            <span class="font-medium text-gray-800">0</span>
                        </div>
                    </div>
                </div>

                <!-- SMS Service -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">SMS Service</h3>
                                <p class="text-sm text-gray-600">NextSMS API</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Healthy</span>
                            <p class="text-xs text-gray-500 mt-1">Last sent: 15 mins ago</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium text-green-600">Connected</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sent Today:</span>
                            <span class="font-medium text-gray-800">124</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Balance:</span>
                            <span class="font-medium text-gray-800">8,456</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Performance Metrics</h2>
            <p class="text-sm text-gray-600 mt-1">System performance over the last 24 hours</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Response Time Chart -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-4">Average Response Time</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Current</span>
                            <span class="text-sm font-bold text-green-600">120ms</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Average (24h)</span>
                            <span class="text-sm font-bold text-gray-800">145ms</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Peak</span>
                            <span class="text-sm font-bold text-orange-600">280ms</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Minimum</span>
                            <span class="text-sm font-bold text-green-600">85ms</span>
                        </div>
                    </div>
                </div>

                <!-- Request Statistics -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-4">Request Statistics (24h)</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Requests</span>
                            <span class="text-sm font-bold text-gray-800">12,456</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Successful</span>
                            <span class="text-sm font-bold text-green-600">12,234 (98.2%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Errors</span>
                            <span class="text-sm font-bold text-red-600">222 (1.8%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Requests/Min</span>
                            <span class="text-sm font-bold text-blue-600">8.6</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Health Recommendations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Health Recommendations</h2>
            <p class="text-sm text-gray-600 mt-1">Suggestions to improve system performance</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-start p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Storage Space Warning</h4>
                        <p class="text-sm text-yellow-700 mt-1">Your storage usage is at 42%. Consider cleaning up old files or expanding storage soon.</p>
                    </div>
                </div>

                <div class="flex items-start p-4 bg-green-50 border border-green-200 rounded-lg">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-green-800">Performance Optimized</h4>
                        <p class="text-sm text-green-700 mt-1">Your system is performing well. All critical components are healthy.</p>
                    </div>
                </div>

                <div class="flex items-start p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800">Update Available</h4>
                        <p class="text-sm text-blue-700 mt-1">A new security update is available for your system. Consider updating soon.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
