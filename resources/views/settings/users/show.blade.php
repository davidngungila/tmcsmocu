@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">User Profile</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View detailed user information and activities</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('settings.users.edit', $user->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('settings.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <!-- User Profile Card -->
    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-sm border border-purple-200 p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-purple-500 flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-2xl sm:text-3xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ $user->email }}</p>
                <div class="flex flex-wrap items-center gap-3 mt-3">
                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                        {{ $user->role->name ?? 'No Role' }}
                    </span>
                    <span class="px-3 py-1 text-sm font-bold rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                    </span>
                    @if($user->id === auth()->id())
                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-purple-100 text-purple-800">
                        Current User
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 text-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <p class="text-xs sm:text-sm font-medium text-gray-600">Events</p>
            <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">{{ number_format($eventsCreated ?? 0) }}</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 text-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs sm:text-sm font-medium text-gray-600">Income</p>
            <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">{{ number_format($incomeTransactions ?? 0) }}</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 text-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-xs sm:text-sm font-medium text-gray-600">Expenses</p>
            <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">{{ number_format($expenseTransactions ?? 0) }}</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 text-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-teal-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <p class="text-xs sm:text-sm font-medium text-gray-600">SMS</p>
            <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">{{ number_format($smsCampaigns ?? 0) }}</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 text-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <p class="text-xs sm:text-sm font-medium text-gray-600">Sacraments</p>
            <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">{{ number_format($sacramentSales ?? 0) }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">User Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-base font-bold text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <p class="text-base font-bold text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                                {{ $user->role->name ?? 'No Role' }}
                            </span>
                            @if($user->role)
                            <span class="text-xs text-gray-500">({{ $user->role->slug }})</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Account Created</label>
                        <p class="text-base font-bold text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                        <p class="text-base font-bold text-gray-900">{{ $user->updated_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                    @if($user->email_verified_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Verified</label>
                        <p class="text-base font-bold text-gray-900">{{ $user->email_verified_at->format('M d, Y H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email_verified_at->diffForHumans() }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Role & Permissions -->
            @if($user->role)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Role & Permissions</h2>
                <div class="mb-4">
                    <h3 class="text-sm font-bold text-gray-700 mb-2">Role: {{ $user->role->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $user->role->description ?? 'No description available' }}</p>
                </div>
                @if(!empty($permissions))
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Assigned Permissions</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($permissions as $permission)
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            {{ ucwords(str_replace('_', ' ', $permission)) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @else
                <p class="text-sm text-gray-500">No specific permissions assigned to this role.</p>
                @endif
            </div>
            @endif
            
            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Activities</h2>
                
                <!-- Recent Events -->
                @if($recentEvents->count() > 0)
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Recent Events Created</h3>
                    <div class="space-y-2">
                        @foreach($recentEvents as $event)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $event->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 ml-2">
                                {{ ucfirst(str_replace('_', ' ', $event->type)) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Recent Transactions -->
                @if($recentTransactions->count() > 0)
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Recent Financial Transactions</h3>
                    <div class="space-y-2">
                        @foreach($recentTransactions as $transaction)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $transaction->description ?? 'Transaction' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="text-right ml-2">
                                <p class="text-sm font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }} TZS {{ number_format($transaction->amount, 2) }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Recent SMS Campaigns -->
                @if($recentSmsCampaigns->count() > 0)
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Recent SMS Campaigns</h3>
                    <div class="space-y-2">
                        @foreach($recentSmsCampaigns as $campaign)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $campaign->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $campaign->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $campaign->status === 'approved' ? 'bg-green-100 text-green-800' : ($campaign->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }} ml-2">
                                {{ ucfirst(str_replace('_', ' ', $campaign->status)) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($recentEvents->isEmpty() && $recentTransactions->isEmpty() && $recentSmsCampaigns->isEmpty())
                <p class="text-sm text-gray-500 text-center py-4">No recent activities found.</p>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-2">
                    <a href="{{ route('settings.users.edit', $user->id) }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-center">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit User
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('settings.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete User
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            
            <!-- Account Security -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Account Security</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Email Verified</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $user->email_verified_at ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Password Set</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            Yes
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Account Age</span>
                        <span class="text-sm font-bold text-gray-900">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
