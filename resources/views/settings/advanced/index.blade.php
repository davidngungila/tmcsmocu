@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">⚙️ Mipangilio ya Hali ya Juu</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Mipangilio ya hali ya juu ya mfumo</p>
        </div>
    </div>
    
    <form method="POST" action="{{ route('settings.advanced.store') }}" class="space-y-6">
        @csrf
        
        <!-- Chaplaincy Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📋 Taarifa za Chaplaincy</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jina la Chaplaincy</label>
                    <input type="text" name="chaplaincy_name" value="{{ $settings['chaplaincy_name'] }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Anwani</label>
                    <input type="text" name="chaplaincy_address" value="{{ $settings['chaplaincy_address'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Simu</label>
                    <input type="text" name="chaplaincy_phone" value="{{ $settings['chaplaincy_phone'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Barua Pepe</label>
                    <input type="email" name="chaplaincy_email" value="{{ $settings['chaplaincy_email'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tovuti</label>
                    <input type="text" name="chaplaincy_website" value="{{ $settings['chaplaincy_website'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <!-- Currency Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">💰 Mipangilio ya Sarafu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Sarafu</label>
                    <select name="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="TZS" {{ $settings['currency'] === 'TZS' ? 'selected' : '' }}>TZS (Tanzania Shilling)</option>
                        <option value="USD" {{ $settings['currency'] === 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alama ya Sarafu</label>
                    <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <!-- Date & Time Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📅 Mipangilio ya Tarehe na Muda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Muundo wa Tarehe</label>
                    <select name="date_format" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="dd/mm/yyyy" {{ $settings['date_format'] === 'dd/mm/yyyy' ? 'selected' : '' }}>dd/mm/yyyy</option>
                        <option value="mm/dd/yyyy" {{ $settings['date_format'] === 'mm/dd/yyyy' ? 'selected' : '' }}>mm/dd/yyyy</option>
                        <option value="yyyy-mm-dd" {{ $settings['date_format'] === 'yyyy-mm-dd' ? 'selected' : '' }}>yyyy-mm-dd</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Muundo wa Muda</label>
                    <select name="time_format" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="24hrs" {{ $settings['time_format'] === '24hrs' ? 'selected' : '' }}>24hrs (14:30)</option>
                        <option value="12hrs" {{ $settings['time_format'] === '12hrs' ? 'selected' : '' }}>12hrs (2:30 PM)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Eneo la Saa</label>
                    <select name="timezone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="Africa/Dar_es_Salaam" {{ $settings['timezone'] === 'Africa/Dar_es_Salaam' ? 'selected' : '' }}>Africa/Dar es Salaam</option>
                        <option value="UTC" {{ $settings['timezone'] === 'UTC' ? 'selected' : '' }}>UTC</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Wiki Inaanza</label>
                    <select name="week_starts_on" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="Sunday" {{ $settings['week_starts_on'] === 'Sunday' ? 'selected' : '' }}>Jumapili</option>
                        <option value="Monday" {{ $settings['week_starts_on'] === 'Monday' ? 'selected' : '' }}>Jumatatu</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Language Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">🌐 Mipangilio ya Lugha</h2>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Lugha ya Mfumo</label>
                <select name="system_language" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="Kiswahili" {{ $settings['system_language'] === 'Kiswahili' ? 'selected' : '' }}>Kiswahili</option>
                    <option value="English" {{ $settings['system_language'] === 'English' ? 'selected' : '' }}>English</option>
                </select>
            </div>
        </div>
        
        <!-- Backup Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">💾 Mipangilio ya Kumbukumbu (Backup)</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Backup Moja kwa Moja</label>
                    <select name="backup_frequency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="daily" {{ $settings['backup_frequency'] === 'daily' ? 'selected' : '' }}>Kila siku</option>
                        <option value="weekly" {{ $settings['backup_frequency'] === 'weekly' ? 'selected' : '' }}>Kila wiki</option>
                        <option value="monthly" {{ $settings['backup_frequency'] === 'monthly' ? 'selected' : '' }}>Kila mwezi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Muda wa Backup</label>
                    <input type="time" name="backup_time" value="{{ $settings['backup_time'] }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hifadhi Backup</label>
                    <select name="backup_storage" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="Local" {{ $settings['backup_storage'] === 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Cloud" {{ $settings['backup_storage'] === 'Cloud' ? 'selected' : '' }}>Cloud</option>
                        <option value="Local + Cloud" {{ $settings['backup_storage'] === 'Local + Cloud' ? 'selected' : '' }}>Local + Cloud</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Security Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">🔐 Mipangilio ya Usalama</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="https_enabled" value="1" {{ $settings['https_enabled'] ? 'checked' : '' }}
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">HTTPS: Imewezeshwa</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="two_factor_available" value="1" {{ $settings['two_factor_available'] ? 'checked' : '' }}
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm font-medium text-gray-700">2FA (Two Factor Authentication): Inawezekana</span>
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nguvu ya Nenosiri</label>
                    <select name="password_strength" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="weak" {{ $settings['password_strength'] === 'weak' ? 'selected' : '' }}>Dhaifu</option>
                        <option value="medium" {{ $settings['password_strength'] === 'medium' ? 'selected' : '' }}>Wastani</option>
                        <option value="strong" {{ $settings['password_strength'] === 'strong' ? 'selected' : '' }}>Imara</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kukosa Kuingia (Max Login Attempts)</label>
                    <input type="number" name="max_login_attempts" value="{{ $settings['max_login_attempts'] }}" min="3" max="10" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Muda wa Kuzuia (Lockout Time - Dakika)</label>
                    <input type="number" name="lockout_time" value="{{ $settings['lockout_time'] }}" min="5" max="60" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <div class="flex items-center justify-end space-x-4">
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                Hifadhi Mipangilio
            </button>
        </div>
    </form>
</div>
@endsection

