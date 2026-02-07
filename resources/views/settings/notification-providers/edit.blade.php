@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Edit {{ $provider->type === 'email' ? 'Email' : 'SMS' }} Provider
            </h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">
                Update {{ $provider->type === 'email' ? 'email (SMTP)' : 'SMS gateway' }} provider configuration for system notifications
            </p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('settings.notification-providers.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <!-- Provider Status Card -->
    <div class="bg-gradient-to-br {{ $provider->type === 'email' ? 'from-blue-50 to-blue-100 border-blue-200' : 'from-teal-50 to-teal-100 border-teal-200' }} rounded-xl shadow-sm border p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 {{ $provider->type === 'email' ? 'bg-blue-500' : 'bg-teal-500' }} rounded-xl flex items-center justify-center shadow-lg">
                    @if($provider->type === 'email')
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    @else
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    @endif
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $provider->name }}</h2>
                    <p class="text-gray-600 mt-1 text-sm">{{ $provider->description ?? 'No description' }}</p>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $provider->is_primary ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $provider->is_primary ? 'Primary' : 'Secondary' }}
                        </span>
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $provider->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $provider->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase">
                            {{ $provider->type }}
                        </span>
                    </div>
                </div>
            </div>
            @if($provider->type === 'sms' && isset($usageStats))
            <div class="text-right">
                <p class="text-xs sm:text-sm font-medium text-gray-600">Total Campaigns</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ number_format($usageStats['total_campaigns'] ?? 0) }}</p>
            </div>
            @endif
        </div>
    </div>
    
    @if($provider->type === 'sms' && isset($usageStats))
    <!-- SMS Usage Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Sent</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-600 mt-2">{{ number_format($usageStats['total_sent'] ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Failed</p>
                    <p class="text-xl sm:text-2xl font-bold text-red-600 mt-2">{{ number_format($usageStats['total_failed'] ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Success Rate</p>
                    @php
                        $total = ($usageStats['total_sent'] ?? 0) + ($usageStats['total_failed'] ?? 0);
                        $successRate = $total > 0 ? (($usageStats['total_sent'] ?? 0) / $total) * 100 : 0;
                    @endphp
                    <p class="text-xl sm:text-2xl font-bold {{ $successRate >= 90 ? 'text-green-600' : ($successRate >= 70 ? 'text-yellow-600' : 'text-red-600') }} mt-2">
                        {{ number_format($successRate, 1) }}%
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Provider Configuration -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Provider Configuration</h2>
                
                <form method="POST" action="{{ route('settings.notification-providers.update', $provider->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Provider Name *</label>
                        <input type="text" name="name" value="{{ old('name', $provider->name) }}" required
                            placeholder="A descriptive name for this {{ $provider->type }} provider"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <input type="hidden" name="type" value="{{ $provider->type }}">
                    
                    @if($provider->type === 'email')
                        <!-- Email Configuration -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <h3 class="text-base font-bold text-gray-800">SMTP Configuration</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Mailer Type *</label>
                                    <select name="mailer_type" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                                        <option>SMTP</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">SMTP is the standard mailer type</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Host *</label>
                                    <input type="text" name="mail_host" value="{{ old('mail_host', $provider->mail_host) }}" required
                                        placeholder="smtp.gmail.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @error('mail_host')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Port *</label>
                                    <input type="number" name="mail_port" value="{{ old('mail_port', $provider->mail_port) }}" required min="1" max="65535"
                                        placeholder="587"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Common ports: 587 (TLS), 465 (SSL), 25 (Standard)</p>
                                    @error('mail_port')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Encryption *</label>
                                    <select name="mail_encryption" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="tls" {{ old('mail_encryption', $provider->mail_encryption) === 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ old('mail_encryption', $provider->mail_encryption) === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    </select>
                                    @error('mail_encryption')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Username</label>
                                    <input type="text" name="mail_username" value="{{ old('mail_username', $provider->mail_username) }}"
                                        placeholder="your-email@gmail.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @error('mail_username')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMTP Password</label>
                                    <input type="password" name="mail_password" value=""
                                        placeholder="Leave blank to keep current password"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password. For Gmail, use App Password (not your regular password)</p>
                                    @error('mail_password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">From Email Address</label>
                                    <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $provider->mail_from_address) }}"
                                        placeholder="sender@example.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @error('mail_from_address')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">From Name</label>
                                    <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $provider->mail_from_name) }}"
                                        placeholder="OfisiLink"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @error('mail_from_name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- SMS Configuration -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <h3 class="text-base font-bold text-gray-800">SMS Gateway Configuration</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMS Bearer Token (Recommended)</label>
                                    <input type="password" name="sms_token" value=""
                                        placeholder="Leave blank to keep current token"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Bearer Token from API Keys (recommended). Leave blank to keep current.</p>
                                    @error('sms_token')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMS Username (for Basic Auth)</label>
                                    <input type="text" name="sms_username" value="{{ old('sms_username', $provider->sms_username) }}"
                                        placeholder="Leave empty if using Bearer Token"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Only needed if not using Bearer Token</p>
                                    @error('sms_username')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMS Password (for Basic Auth)</label>
                                    <input type="password" name="sms_password" value=""
                                        placeholder="Leave blank to keep current password"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Only needed if not using Bearer Token. Leave blank to keep current.</p>
                                    @error('sms_password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMS From (Sender Name)</label>
                                    <input type="text" name="sms_from" value="{{ old('sms_from', $provider->sms_from) }}"
                                        placeholder="OfisiLink"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Name displayed as sender (if supported by gateway)</p>
                                    @error('sms_from')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">SMS API URL *</label>
                                    <input type="url" name="sms_url" value="{{ old('sms_url', $provider->sms_url ?: 'https://messaging-service.co.tz/api/sms/v2/text/single') }}" required
                                        placeholder="https://messaging-service.co.tz/api/sms/v2/text/single"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Messaging Service API V2 (hardcoded)</p>
                                    @error('sms_url')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="border-t border-gray-200 pt-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="2"
                            placeholder="Optional description for this provider"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $provider->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $provider->is_active) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Active - Provider will be available for use</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" name="is_primary" value="1" {{ old('is_primary', $provider->is_primary) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Set as Primary - Primary provider is used first</span>
                        </label>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('settings.notification-providers.index') }}" 
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                            Update Provider
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Recent Campaigns (SMS only) -->
            @if($provider->type === 'sms' && isset($usageStats['recent_campaigns']) && $usageStats['recent_campaigns']->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Recent SMS Campaigns</h2>
                <div class="space-y-2">
                    @foreach($usageStats['recent_campaigns'] as $campaign)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $campaign->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $campaign->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="flex items-center space-x-2 ml-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $campaign->status === 'approved' ? 'bg-green-100 text-green-800' : ($campaign->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $campaign->status)) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ number_format($campaign->recipient_count ?? 0) }} recipients</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Test Configuration -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-20">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Test Configuration</h2>
                <p class="text-sm text-gray-600 mb-4">Test your configuration before saving to ensure everything works correctly.</p>
                
                @if($provider->type === 'email')
                    <!-- Email Test -->
                    <form id="test-email-form" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Test Email Address</label>
                            <input type="email" id="test-email" name="test_email" required
                                placeholder="david.ngungila@emca.tech"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-bold text-sm">
                            Test Connection
                        </button>
                        <div id="email-status" class="text-sm font-medium mt-2 hidden"></div>
                    </form>
                @else
                    <!-- SMS Test -->
                    <form id="test-sms-form" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Test Phone Number</label>
                            <input type="text" id="test-phone" name="test_phone" required
                                placeholder="255712345678"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                            <p class="text-xs text-gray-500 mt-1">Format: 255XXXXXXXXX (12 digits starting with 255)</p>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-bold text-sm">
                            Test Connection
                        </button>
                        <div id="sms-status" class="text-sm font-medium mt-2 hidden"></div>
                    </form>
                @endif
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500">Connection Status</p>
                    <div id="connection-status" class="text-sm font-medium mt-2 text-gray-400">
                        Click "Test Connection" to check status
                    </div>
                </div>
            </div>
            
            @if($provider->type === 'sms')
            <!-- SMS Balance Check -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">SMS Balance</h2>
                <p class="text-sm text-gray-600 mb-4">Check your SMS account balance</p>
                
                <button id="check-balance-btn" type="button" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-bold text-sm">
                    Check Balance
                </button>
                
                <div id="balance-result" class="mt-4 hidden">
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">SMS Balance:</span>
                            <span id="balance-amount" class="text-sm font-bold text-gray-900"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Display:</span>
                            <span id="balance-display" class="text-sm font-bold text-gray-900"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Type:</span>
                            <span id="balance-type" class="text-sm font-bold text-gray-900"></span>
                        </div>
                    </div>
                </div>
                
                <div id="balance-error" class="mt-4 hidden">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p id="balance-error-message" class="text-sm text-red-600"></p>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Provider Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Provider Information</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Created At</label>
                        <p class="text-sm font-bold text-gray-900">{{ $provider->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Last Updated</label>
                        <p class="text-sm font-bold text-gray-900">{{ $provider->updated_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Provider Type</label>
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 uppercase">
                            {{ $provider->type }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    @if($provider->type === 'email')
    document.getElementById('test-email-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const button = form.querySelector('button[type="submit"]');
        const statusDiv = document.getElementById('email-status');
        const connectionStatus = document.getElementById('connection-status');
        const testEmail = document.getElementById('test-email').value;
        
        button.disabled = true;
        button.textContent = 'Testing...';
        statusDiv.classList.remove('hidden', 'text-green-600', 'text-red-600');
        statusDiv.textContent = 'Testing connection...';
        statusDiv.classList.add('text-blue-600');
        connectionStatus.textContent = 'Testing...';
        connectionStatus.classList.remove('text-gray-400', 'text-green-600', 'text-red-600');
        connectionStatus.classList.add('text-blue-600');
        
        try {
            const response = await fetch('{{ route("settings.notification-providers.test-email", $provider->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ test_email: testEmail })
            });
            
            const data = await response.json();
            
            if (data.success) {
                statusDiv.textContent = '✓ ' + data.message;
                statusDiv.classList.remove('text-blue-600', 'text-red-600');
                statusDiv.classList.add('text-green-600');
                connectionStatus.textContent = 'Connected';
                connectionStatus.classList.remove('text-blue-600', 'text-red-600');
                connectionStatus.classList.add('text-green-600');
            } else {
                statusDiv.textContent = '✗ ' + data.message;
                statusDiv.classList.remove('text-blue-600', 'text-green-600');
                statusDiv.classList.add('text-red-600');
                connectionStatus.textContent = 'Failed';
                connectionStatus.classList.remove('text-blue-600', 'text-green-600');
                connectionStatus.classList.add('text-red-600');
            }
        } catch (error) {
            statusDiv.textContent = '✗ Error: ' + error.message;
            statusDiv.classList.remove('text-blue-600', 'text-green-600');
            statusDiv.classList.add('text-red-600');
            connectionStatus.textContent = 'Error';
            connectionStatus.classList.remove('text-blue-600', 'text-green-600');
            connectionStatus.classList.add('text-red-600');
        } finally {
            button.disabled = false;
            button.textContent = 'Test Connection';
        }
    });
    @else
    document.getElementById('test-sms-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const button = form.querySelector('button[type="submit"]');
        const statusDiv = document.getElementById('sms-status');
        const connectionStatus = document.getElementById('connection-status');
        const testPhone = document.getElementById('test-phone').value;
        
        button.disabled = true;
        button.textContent = 'Testing...';
        statusDiv.classList.remove('hidden', 'text-green-600', 'text-red-600');
        statusDiv.textContent = 'Testing connection...';
        statusDiv.classList.add('text-blue-600');
        connectionStatus.textContent = 'Testing...';
        connectionStatus.classList.remove('text-gray-400', 'text-green-600', 'text-red-600');
        connectionStatus.classList.add('text-blue-600');
        
        try {
            const response = await fetch('{{ route("settings.notification-providers.test-sms", $provider->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ test_phone: testPhone })
            });
            
            const data = await response.json();
            
            if (data.success) {
                statusDiv.textContent = '✓ ' + data.message;
                statusDiv.classList.remove('text-blue-600', 'text-red-600');
                statusDiv.classList.add('text-green-600');
                connectionStatus.textContent = 'Connected';
                connectionStatus.classList.remove('text-blue-600', 'text-red-600');
                connectionStatus.classList.add('text-green-600');
            } else {
                statusDiv.textContent = '✗ ' + data.message;
                statusDiv.classList.remove('text-blue-600', 'text-green-600');
                statusDiv.classList.add('text-red-600');
                connectionStatus.textContent = 'Failed';
                connectionStatus.classList.remove('text-blue-600', 'text-green-600');
                connectionStatus.classList.add('text-red-600');
            }
        } catch (error) {
            statusDiv.textContent = '✗ Error: ' + error.message;
            statusDiv.classList.remove('text-blue-600', 'text-green-600');
            statusDiv.classList.add('text-red-600');
            connectionStatus.textContent = 'Error';
            connectionStatus.classList.remove('text-blue-600', 'text-green-600');
            connectionStatus.classList.add('text-red-600');
        } finally {
            button.disabled = false;
            button.textContent = 'Test Connection';
        }
    });
    
    // SMS Balance Check
    document.getElementById('check-balance-btn').addEventListener('click', async function() {
        const button = this;
        const balanceResult = document.getElementById('balance-result');
        const balanceError = document.getElementById('balance-error');
        
        button.disabled = true;
        button.textContent = 'Checking...';
        balanceResult.classList.add('hidden');
        balanceError.classList.add('hidden');
        
        try {
            const response = await fetch('{{ route("settings.notification-providers.balance", $provider->id) }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.balance) {
                document.getElementById('balance-amount').textContent = data.balance.sms_balance ? number_format(data.balance.sms_balance) : 'N/A';
                document.getElementById('balance-display').textContent = data.balance.display || 'N/A';
                document.getElementById('balance-type').textContent = data.balance.type || 'N/A';
                balanceResult.classList.remove('hidden');
                balanceError.classList.add('hidden');
            } else {
                document.getElementById('balance-error-message').textContent = data.message || 'Failed to check balance';
                balanceError.classList.remove('hidden');
                balanceResult.classList.add('hidden');
            }
        } catch (error) {
            document.getElementById('balance-error-message').textContent = 'Error: ' + error.message;
            balanceError.classList.remove('hidden');
            balanceResult.classList.add('hidden');
        } finally {
            button.disabled = false;
            button.textContent = 'Check Balance';
        }
    });
    
    function number_format(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    @endif
</script>
@endsection
