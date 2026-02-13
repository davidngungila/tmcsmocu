@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">⚙️ Mipangilio ya Mfumo</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Simamia mipangilio yote ya mfumo</p>
        </div>
    </div>
    
    <!-- Financial Year Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">📅 Mwaka wa Fedha</h2>
            <a href="{{ route('settings.financial-years.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-bold">
                Mipangilio ya Mwaka wa Fedha →
            </a>
        </div>
        
        @if($activeYear)
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Mwaka Unaofanya Kazi</p>
                    <p class="text-xl font-bold text-purple-900 mt-1">{{ $activeYear->name }}</p>
                    <p class="text-xs text-purple-600 mt-1">
                        {{ \Carbon\Carbon::parse($activeYear->start_date)->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse($activeYear->end_date)->format('d/m/Y') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">◉</span>
                </div>
            </div>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-sm text-yellow-800">Hakuna mwaka wa fedha unaofanya kazi. <a href="{{ route('settings.financial-years.create') }}" class="font-bold underline">Fungua mwaka mpya</a></p>
        </div>
        @endif
    </div>
    
    <!-- System Health Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">🖥️ Afya ya Mfumo</h2>
            <a href="{{ route('settings.system.health') }}" class="text-purple-600 hover:text-purple-700 text-sm font-bold">
                Angalia Zaidi →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Database Status -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-green-700">Database</p>
                    <span class="text-green-600 text-lg">◉</span>
                </div>
                <p class="text-xs text-green-600">
                    @if($systemHealth['database']['connected'] ?? false)
                        Imara
                    @else
                        Haijaunganishwa
                    @endif
                </p>
                @if(isset($systemHealth['database']['size_mb']))
                <p class="text-xs text-green-600 mt-1">Ukubwa: {{ number_format($systemHealth['database']['size_mb'], 2) }} MB</p>
                @endif
            </div>
            
            <!-- Server Status -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-blue-700">Server</p>
                    <span class="text-blue-600 text-lg">◉</span>
                </div>
                @if(isset($systemHealth['server']['cpu_usage']))
                <p class="text-xs text-blue-600">CPU: {{ $systemHealth['server']['cpu_usage'] }}%</p>
                @endif
                @if(isset($systemHealth['server']['memory_usage']))
                <p class="text-xs text-blue-600 mt-1">
                    Memory: {{ number_format($systemHealth['server']['memory_usage']['used'] ?? 0, 1) }}MB / 
                    {{ number_format($systemHealth['server']['memory_usage']['total'] ?? 0, 1) }}MB
                </p>
                @endif
            </div>
            
            <!-- Performance -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-purple-700">Utendaji</p>
                    <span class="text-purple-600 text-lg">◉</span>
                </div>
                @if(isset($systemHealth['performance']['response_time']))
                <p class="text-xs text-purple-600">Muda wa Kujibu: {{ $systemHealth['performance']['response_time'] }}ms</p>
                @endif
                @if(isset($systemHealth['performance']['online_users']))
                <p class="text-xs text-purple-600 mt-1">Watumiaji Mtandaoni: {{ $systemHealth['performance']['online_users'] }}</p>
                @endif
            </div>
        </div>
        
        @if(isset($systemHealth['database']['last_backup']))
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Backup ya Mwisho: {{ $systemHealth['database']['last_backup'] ?? 'Hajafanywa' }}</p>
                <form method="POST" action="{{ route('settings.system.backup') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors font-bold">
                        Fanya Backup Sasa
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Watumiaji Wote</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Walio hai: {{ $stats['active_users'] ?? 0 }} | 
                        Waliozuiwa: {{ $stats['suspended_users'] ?? 0 }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Majukumu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_roles'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Miamala ya Fedha</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_transactions'] ?? 0) }}</p>
                </div>
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Mipangilio</p>
                    <p class="text-2xl font-bold text-gray-900">6</p>
                    <p class="text-xs text-gray-500 mt-1">Sehemu zote</p>
                </div>
                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.14c1.906-.94 2.1-3.547.194-4.454a2.5 2.5 0 00-3.388 0c-.906.907-1.712 3.514-.194 4.454a1.724 1.724 0 002.573 1.14zm-3.388 1.854a2.5 2.5 0 11-3.388 3.388 2.5 2.5 0 013.388-3.388z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Settings Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Financial Year -->
        <a href="{{ route('settings.financial-years.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">📅</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Mwaka wa Fedha</h3>
            </div>
            <p class="text-sm text-gray-600">Simamia miaka ya fedha na vipindi</p>
        </a>
        
        <!-- Users -->
        <a href="{{ route('settings.users.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">👥</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Watumiaji</h3>
            </div>
            <p class="text-sm text-gray-600">Simamia watumiaji na majukumu</p>
        </a>
        
        <!-- Permissions -->
        <a href="{{ route('settings.permissions.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">🔐</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Ruhusa</h3>
            </div>
            <p class="text-sm text-gray-600">Simamia ruhusa na majukumu</p>
        </a>
        
        <!-- General Settings -->
        <a href="{{ route('settings.general') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">⚙️</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Mipangilio ya Jumla</h3>
            </div>
            <p class="text-sm text-gray-600">Mipangilio ya mfumo kwa ujumla</p>
        </a>
        
        <!-- SMS Settings -->
        <a href="{{ route('settings.sms.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">📱</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Mipangilio ya SMS</h3>
            </div>
            <p class="text-sm text-gray-600">Simamia SMS na watoa huduma</p>
        </a>
        
        <!-- Email Settings -->
        <a href="{{ route('settings.email.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-purple-300 hover:shadow-md transition-all">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">📧</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Mipangilio ya Barua Pepe</h3>
            </div>
            <p class="text-sm text-gray-600">Simamia barua pepe na SMTP</p>
        </a>
    </div>
</div>
@endsection

