@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header with Financial Year Info -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold">⚙️ Mipangilio ya Hali ya Juu</h1>
                <p class="text-purple-100 mt-1 text-sm sm:text-base">St. Joseph Chaplaincy - Moshi Co-operative University</p>
            </div>
            <div class="text-right">
                @php
                    $activeYear = \App\Models\FinancialYear::getActive();
                @endphp
                @if($activeYear)
                <p class="text-sm text-purple-100">📅 MWAKA WA FEDHA: {{ $activeYear->name }}</p>
                <p class="text-xs text-purple-200">
                    {{ \Carbon\Carbon::parse($activeYear->start_date)->format('d/m/Y') }} - 
                    {{ \Carbon\Carbon::parse($activeYear->end_date)->format('d/m/Y') }}
                </p>
                @endif
            </div>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('settings.advanced.store') }}" class="space-y-6">
        @csrf
        
        <!-- Chaplaincy Information Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button type="button" onclick="toggleSection('chaplaincy')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">📋</span>
                    <h2 class="text-lg font-bold text-gray-800">Taarifa za Chaplaincy</h2>
                </div>
                <svg id="chaplaincy-arrow" class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="chaplaincy-section" class="px-6 pb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jina la Chaplaincy</label>
                        <input type="text" name="chaplaincy_name" value="{{ $settings['chaplaincy_name'] }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Anwani</label>
                        <input type="text" name="chaplaincy_address" value="{{ $settings['chaplaincy_address'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="S.L.P 123, Moshi">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Simu</label>
                        <input type="text" name="chaplaincy_phone" value="{{ $settings['chaplaincy_phone'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="+255 123 456 789">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Barua Pepe</label>
                        <input type="email" name="chaplaincy_email" value="{{ $settings['chaplaincy_email'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="info@stjosephmocu.org">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tovuti</label>
                        <input type="text" name="chaplaincy_website" value="{{ $settings['chaplaincy_website'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="www.stjosephmocu.org">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Logo</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16 w-auto border border-gray-300 rounded-lg p-2 bg-white">
                            <div>
                                <form method="POST" action="{{ route('settings.advanced.upload-logo') }}" enctype="multipart/form-data" class="inline">
                                    @csrf
                                    <input type="file" name="logo" id="logo-input" accept="image/*" class="hidden" onchange="this.form.submit()">
                                    <button type="button" onclick="document.getElementById('logo-input').click()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold text-sm">
                                        Badilisha Logo
                                    </button>
                                </form>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (Max 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Currency Settings Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button type="button" onclick="toggleSection('currency')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">💰</span>
                    <h2 class="text-lg font-bold text-gray-800">Mipangilio ya Sarafu</h2>
                </div>
                <svg id="currency-arrow" class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="currency-section" class="px-6 pb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sarafu</label>
                        <select name="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="TZS" {{ $settings['currency'] === 'TZS' ? 'selected' : '' }}>TZS (Tanzania Shilling)</option>
                            <option value="USD" {{ $settings['currency'] === 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                            <option value="KES" {{ $settings['currency'] === 'KES' ? 'selected' : '' }}>KES (Kenyan Shilling)</option>
                            <option value="UGX" {{ $settings['currency'] === 'UGX' ? 'selected' : '' }}>UGX (Ugandan Shilling)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alama ya Sarafu</label>
                        <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="TZS">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Muundo wa Fedha</label>
                        <input type="text" value="1,000,000.00" readonly
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                        <p class="text-xs text-gray-500 mt-1">Muundo wa kuonyesha namba za fedha</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Date & Time Settings Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button type="button" onclick="toggleSection('datetime')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">📅</span>
                    <h2 class="text-lg font-bold text-gray-800">Mipangilio ya Tarehe na Muda</h2>
                </div>
                <svg id="datetime-arrow" class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="datetime-section" class="px-6 pb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Muundo wa Tarehe</label>
                        <select name="date_format" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="dd/mm/yyyy" {{ $settings['date_format'] === 'dd/mm/yyyy' ? 'selected' : '' }}>dd/mm/yyyy (31/12/2025)</option>
                            <option value="mm/dd/yyyy" {{ $settings['date_format'] === 'mm/dd/yyyy' ? 'selected' : '' }}>mm/dd/yyyy (12/31/2025)</option>
                            <option value="yyyy-mm-dd" {{ $settings['date_format'] === 'yyyy-mm-dd' ? 'selected' : '' }}>yyyy-mm-dd (2025-12-31)</option>
                            <option value="dd-mm-yyyy" {{ $settings['date_format'] === 'dd-mm-yyyy' ? 'selected' : '' }}>dd-mm-yyyy (31-12-2025)</option>
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
                        <label class="block text-sm font-bold text-gray-700 mb-2">Eneo la Saa (Timezone)</label>
                        <select name="timezone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="Africa/Dar_es_Salaam" {{ $settings['timezone'] === 'Africa/Dar_es_Salaam' ? 'selected' : '' }}>Africa/Dar es Salaam (EAT)</option>
                            <option value="Africa/Nairobi" {{ $settings['timezone'] === 'Africa/Nairobi' ? 'selected' : '' }}>Africa/Nairobi (EAT)</option>
                            <option value="Africa/Kampala" {{ $settings['timezone'] === 'Africa/Kampala' ? 'selected' : '' }}>Africa/Kampala (EAT)</option>
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
        </div>
        
        <!-- Language Settings Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button type="button" onclick="toggleSection('language')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">🌐</span>
                    <h2 class="text-lg font-bold text-gray-800">Mipangilio ya Lugha</h2>
                </div>
                <svg id="language-arrow" class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="language-section" class="px-6 pb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Lugha ya Mfumo</label>
                        <select name="system_language" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="Kiswahili" {{ $settings['system_language'] === 'Kiswahili' ? 'selected' : '' }}>Kiswahili</option>
                            <option value="English" {{ $settings['system_language'] === 'English' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Lugha za Ujumbe</label>
                        <select multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" disabled>
                            <option selected>Kiswahili</option>
                            <option selected>English</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Lugha zinazotumika kwa ujumbe na arifa</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Backup Settings Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button type="button" onclick="toggleSection('backup')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">💾</span>
                    <h2 class="text-lg font-bold text-gray-800">Mipangilio ya Kumbukumbu (Backup)</h2>
                </div>
                <svg id="backup-arrow" class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="backup-section" class="px-6 pb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Backup Moja kwa Moja</label>
                        <select name="backup_frequency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="daily" {{ $settings['backup_frequency'] === 'daily' ? 'selected' : '' }}>Kila siku</option>
                            <option value="weekly" {{ $settings['backup_frequency'] === 'weekly' ? 'selected' : '' }}>Kila wiki</option>
                            <option value="monthly" {{ $settings['backup_frequency'] === 'monthly' ? 'selected' : '' }}>Kila mwezi</option>
                            <option value="manual" {{ $settings['backup_frequency'] === 'manual' ? 'selected' : '' }}>Mkono peke yake</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Muda wa Backup</label>
                        <input type="time" name="backup_time" value="{{ $settings['backup_time'] }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Muda wa kufanya backup kiotomatiki</p>
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
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-blue-800">Backup za Mwisho 5</p>
                            <p class="text-xs text-blue-600 mt-1">Hakuna backup zilizofanywa bado</p>
                        </div>
                        <a href="{{ route('settings.system.backup') }}" class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-bold">
                            Fanya Backup Sasa
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Security Settings Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button type="button" onclick="toggleSection('security')" class="w-full flex items-center justify-between p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">🔐</span>
                    <h2 class="text-lg font-bold text-gray-800">Mipangilio ya Usalama</h2>
                </div>
                <svg id="security-arrow" class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="security-section" class="px-6 pb-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                        <input type="checkbox" name="https_enabled" value="1" {{ $settings['https_enabled'] ? 'checked' : '' }}
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 w-5 h-5">
                        <div>
                            <label class="text-sm font-bold text-gray-700">HTTPS: Imewezeshwa</label>
                            <p class="text-xs text-gray-500">Tumia muunganisho salama</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                        <input type="checkbox" name="two_factor_available" value="1" {{ $settings['two_factor_available'] ? 'checked' : '' }}
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 w-5 h-5">
                        <div>
                            <label class="text-sm font-bold text-gray-700">2FA (Two Factor Authentication): Inawezekana</label>
                            <p class="text-xs text-gray-500">Washa uthibitishaji wa mambo mawili</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nguvu ya Nenosiri</label>
                        <select name="password_strength" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="weak" {{ $settings['password_strength'] === 'weak' ? 'selected' : '' }}>Dhaifu (Herufi 6+)</option>
                            <option value="medium" {{ $settings['password_strength'] === 'medium' ? 'selected' : '' }}>Wastani (Herufi 8+, Namba, Herufi)</option>
                            <option value="strong" {{ $settings['password_strength'] === 'strong' ? 'selected' : '' }}>Imara (Herufi 12+, Namba, Herufi, Alama Maalum)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kukosa Kuingia (Max Login Attempts)</label>
                        <input type="number" name="max_login_attempts" value="{{ $settings['max_login_attempts'] }}" min="3" max="10" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Idadi ya majaribio ya kuingia kabla ya kuzuiwa</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Muda wa Kuzuia (Lockout Time - Dakika)</label>
                        <input type="number" name="lockout_time" value="{{ $settings['lockout_time'] }}" min="5" max="60" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Muda wa kuzuia baada ya majaribio mengi ya kuingia</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <a href="{{ route('settings.system.index') }}" class="text-gray-600 hover:text-gray-800 font-bold">
                ← Rudi kwenye Mipangilio
            </a>
            <div class="flex items-center space-x-4">
                <button type="button" onclick="window.location.reload()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-bold">
                    Ghairi
                </button>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                    Hifadhi Mipangilio
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleSection(sectionId) {
        const section = document.getElementById(sectionId + '-section');
        const arrow = document.getElementById(sectionId + '-arrow');
        
        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        } else {
            section.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }
    
    // Initialize all sections as expanded by default
    document.addEventListener('DOMContentLoaded', function() {
        // All sections are expanded by default (no hidden class)
        // User can collapse them by clicking
    });
</script>
@endsection
