@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Mipangilio ya Akunti</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Taarifa na mipangilio ya akunti yako</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Taarifa za Akunti</h2>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between gap-4">
                    <span class="text-gray-600">Jina</span>
                    <span class="font-semibold text-gray-800 truncate">{{ Auth::user()->name ?? '' }}</span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-gray-600">Barua Pepe</span>
                    <span class="font-semibold text-gray-800 truncate">{{ Auth::user()->email ?? '' }}</span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-gray-600">Role</span>
                    <span class="font-semibold text-gray-800 truncate">{{ Auth::user()->role->name ?? '' }}</span>
                </div>
            </div>

            <div class="mt-5 flex items-center justify-end">
                <a href="{{ route('profile.show') }}" class="px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold text-sm">
                    Hariri Wasifu
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Usalama</h2>
            <p class="text-sm text-gray-600">Badilisha nenosiri au washa 2FA.</p>

            <div class="mt-5 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('settings.security') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm text-center">
                    Usalama
                </a>
                <a href="{{ route('settings.two-factor.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm text-center">
                    Two-Factor (2FA)
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
