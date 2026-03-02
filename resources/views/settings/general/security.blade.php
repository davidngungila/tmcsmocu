@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Usalama</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Badilisha nenosiri na mipangilio ya usalama</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Badilisha Nenosiri</h2>

            <form method="POST" action="{{ route('settings.security.password') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nenosiri la Sasa</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nenosiri Jipya</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Thibitisha Nenosiri Jipya</label>
                    <input type="password" name="password_confirmation" required minlength="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="border-t border-gray-200 pt-6 flex items-center justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                        Badilisha
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Two-Factor Authentication (2FA)</h2>
            <p class="text-sm text-gray-600">Washa au zima 2FA kwa ajili ya ulinzi zaidi.</p>

            <div class="mt-5">
                <a href="{{ route('settings.two-factor.index') }}" class="inline-flex items-center px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm">
                    Nenda 2FA
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
