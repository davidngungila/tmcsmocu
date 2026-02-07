@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Add SMS Provider</h1>
        <p class="text-gray-600 mt-1">Configure a new SMS notification provider</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('settings.notification-providers.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-base font-bold text-gray-700 mb-2">Provider Name *</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g., Messaging Service Co" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="type" class="block text-base font-bold text-gray-700 mb-2">Type *</label>
                    <select id="type" name="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <option value="sms" {{ old('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                        <option value="email" {{ old('type') === 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div id="sms-settings">
                <h3 class="text-lg font-bold text-gray-800 mb-4">SMS Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sms_token" class="block text-base font-bold text-gray-700 mb-2">Bearer Token (Recommended)</label>
                        <input type="password" id="sms_token" name="sms_token" value="{{ old('sms_token') }}" placeholder="Bearer Token from API Keys" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <p class="text-xs text-gray-500 mt-1">Get from Customer Info -> Customization -> API Keys</p>
                    </div>
                    
                    <div>
                        <label for="sms_username" class="block text-base font-bold text-gray-700 mb-2">Username (for Basic Auth)</label>
                        <input type="text" id="sms_username" name="sms_username" value="{{ old('sms_username') }}" placeholder="Only if not using Bearer Token" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    </div>
                    
                    <div>
                        <label for="sms_password" class="block text-base font-bold text-gray-700 mb-2">Password (for Basic Auth)</label>
                        <input type="password" id="sms_password" name="sms_password" value="{{ old('sms_password') }}" placeholder="Only if not using Bearer Token" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    </div>
                    
                    <div>
                        <label for="sms_from" class="block text-base font-bold text-gray-700 mb-2">Sender ID/From</label>
                        <input type="text" id="sms_from" name="sms_from" value="{{ old('sms_from') }}" placeholder="e.g., OfisiLink" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="sms_url" class="block text-base font-bold text-gray-700 mb-2">API URL</label>
                        <input type="url" id="sms_url" name="sms_url" value="{{ old('sms_url', 'https://messaging-service.co.tz/api/sms/v2/text/single') }}" placeholder="https://messaging-service.co.tz/api/sms/v2/text/single" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <p class="text-xs text-gray-500 mt-1">Messaging Service API V2 (hardcoded)</p>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-base font-bold text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">{{ old('description') }}</textarea>
            </div>
            
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_primary" value="1" {{ old('is_primary') ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2 text-base text-gray-700">Set as Primary Provider</span>
                </label>
                
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2 text-base text-gray-700">Active</span>
                </label>
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('settings.notification-providers.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-base font-bold">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 transition-colors text-base">
                    Save Provider
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

