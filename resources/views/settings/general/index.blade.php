@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">General Settings</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Configure system-wide settings</p>
        </div>
    </div>
    
    <form method="POST" action="{{ route('settings.general.store') }}" class="space-y-6">
        @csrf
        
        <!-- Application Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Application Settings</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Application Name</label>
                    <input type="text" name="settings[app_name][value]" value="{{ $commonSettings['app_name'] ?? 'TmcsSmart' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <input type="hidden" name="settings[app_name][key]" value="app_name">
                    <input type="hidden" name="settings[app_name][type]" value="string">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Timezone</label>
                    <select name="settings[app_timezone][value]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="Africa/Dar_es_Salaam" {{ ($commonSettings['app_timezone'] ?? '') === 'Africa/Dar_es_Salaam' ? 'selected' : '' }}>Africa/Dar es Salaam</option>
                        <option value="UTC" {{ ($commonSettings['app_timezone'] ?? '') === 'UTC' ? 'selected' : '' }}>UTC</option>
                    </select>
                    <input type="hidden" name="settings[app_timezone][key]" value="app_timezone">
                    <input type="hidden" name="settings[app_timezone][type]" value="string">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Locale</label>
                    <select name="settings[app_locale][value]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="sw" {{ ($commonSettings['app_locale'] ?? '') === 'sw' ? 'selected' : '' }}>Swahili</option>
                        <option value="en" {{ ($commonSettings['app_locale'] ?? '') === 'en' ? 'selected' : '' }}>English</option>
                    </select>
                    <input type="hidden" name="settings[app_locale][key]" value="app_locale">
                    <input type="hidden" name="settings[app_locale][type]" value="string">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Currency</label>
                    <select name="settings[app_currency][value]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="TZS" {{ ($commonSettings['app_currency'] ?? '') === 'TZS' ? 'selected' : '' }}>TZS (Tanzanian Shilling)</option>
                        <option value="USD" {{ ($commonSettings['app_currency'] ?? '') === 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                    </select>
                    <input type="hidden" name="settings[app_currency][key]" value="app_currency">
                    <input type="hidden" name="settings[app_currency][type]" value="string">
                </div>
            </div>
        </div>
        
        <!-- All Settings (if any exist) -->
        @if($settings->isNotEmpty())
        @foreach($settings as $category => $categorySettings)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 capitalize">{{ $category }} Settings</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($categorySettings as $setting)
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                    @if($setting->type === 'boolean')
                        <select name="settings[{{ $setting->key }}][value]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    @elseif($setting->type === 'integer')
                        <input type="number" name="settings[{{ $setting->key }}][value]" value="{{ $setting->value }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @else
                        <input type="text" name="settings[{{ $setting->key }}][value]" value="{{ $setting->value }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @endif
                    <input type="hidden" name="settings[{{ $setting->key }}][key]" value="{{ $setting->key }}">
                    <input type="hidden" name="settings[{{ $setting->key }}][type]" value="{{ $setting->type }}">
                    @if($setting->description)
                    <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif
        
        <div class="flex items-center justify-end space-x-4">
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection

