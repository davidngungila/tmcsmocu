@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📧 Mipangilio ya Barua Pepe</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Simamia watoa huduma wa barua pepe na mipangilio ya SMTP</p>
        </div>
        <a href="{{ route('settings.notification-providers.create') }}?type=email" class="bg-purple-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors shadow-sm text-sm sm:text-base">
            Ongeza Mtoa Huduma Mpya
        </a>
    </div>
    
    <!-- Email Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Leo</p>
            <p class="text-2xl font-bold text-gray-900">{{ $emailStats['today'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">barua</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Wiki Hii</p>
            <p class="text-2xl font-bold text-gray-900">{{ $emailStats['this_week'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">barua</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Mwezi Huu</p>
            <p class="text-2xl font-bold text-gray-900">{{ $emailStats['this_month'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">barua</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Barua Zilizofeli</p>
            <p class="text-2xl font-bold text-red-600">{{ $emailStats['failed'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">barua</p>
        </div>
    </div>
    
    <!-- Primary Provider -->
    @if($primaryProvider)
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm border border-blue-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    <span class="text-blue-600 text-lg">◉</span>
                    <p class="text-sm font-medium text-blue-700">Mtoa Huduma Unaofanya Kazi</p>
                </div>
                <p class="text-xl font-bold text-blue-900">{{ $primaryProvider->name }}</p>
                <p class="text-xs text-blue-600 mt-1">
                    @if($primaryProvider->is_active)
                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></span> Inafanya Kazi
                    @else
                        <span class="inline-block w-2 h-2 bg-red-500 rounded-full mr-1"></span> Imezuiwa
                    @endif
                </p>
                @if($primaryProvider->mail_from_address)
                <p class="text-xs text-blue-600 mt-1">Kutoka: {{ $primaryProvider->mail_from_address }}</p>
                @endif
            </div>
            <a href="{{ route('settings.notification-providers.edit', $primaryProvider->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-bold text-sm">
                Hariri
            </a>
        </div>
    </div>
    @endif
    
    <!-- All Email Providers -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Watoa Huduma wa Barua Pepe</h2>
        
        @if($providers->isEmpty())
        <div class="text-center py-8 text-gray-500">
            <p class="text-sm">Hakuna watoa huduma wa barua pepe waliowekwa.</p>
            <a href="{{ route('settings.notification-providers.create') }}?type=email" class="text-purple-600 hover:text-purple-700 font-bold text-sm mt-2 inline-block">
                Ongeza Mtoa Huduma wa Kwanza
            </a>
        </div>
        @else
        <div class="space-y-3">
            @foreach($providers as $provider)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <h3 class="font-bold text-gray-800">{{ $provider->name }}</h3>
                            @if($provider->is_primary)
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Primary</span>
                            @endif
                            @if($provider->is_active)
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">Active</span>
                            @else
                            <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded-full">Inactive</span>
                            @endif
                        </div>
                        @if($provider->mail_host)
                        <p class="text-xs text-gray-600">Host: {{ $provider->mail_host }}:{{ $provider->mail_port }}</p>
                        @endif
                        @if($provider->mail_from_address)
                        <p class="text-xs text-gray-600">Kutoka: {{ $provider->mail_from_address }}</p>
                        @endif
                        @if($provider->description)
                        <p class="text-xs text-gray-500 mt-1">{{ $provider->description }}</p>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('settings.notification-providers.edit', $provider->id) }}" class="text-blue-600 hover:text-blue-700 text-sm font-bold">
                            Hariri
                        </a>
                        @if(!$provider->is_primary)
                        <form method="POST" action="{{ route('settings.notification-providers.set-primary', $provider->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-blue-600 hover:text-blue-700 text-sm font-bold">
                                Weka kama Primary
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    
    <!-- Email Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Mipangilio ya Kutuma</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tuma Ujumbe Kwa</label>
                <input type="text" value="SMTP" class="w-full px-4 py-2 border border-gray-300 rounded-lg" readonly>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Kikomo cha Kutuma kwa Siku</label>
                <input type="number" value="500" class="w-full px-4 py-2 border border-gray-300 rounded-lg" readonly>
            </div>
        </div>
    </div>
</div>
@endsection

