@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">🔐 Uthibitishaji wa Mambo Mawili (2FA)</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Washa au zima uthibitishaji wa mambo mawili kwa akaunti yako</p>
        </div>
    </div>
    
    @if(session('recovery_codes'))
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <h3 class="text-lg font-bold text-yellow-800 mb-3">⚠️ Nambari za Uokoaji</h3>
        <p class="text-sm text-yellow-700 mb-4">Hifadhi nambari hizi kwa salama. Zitatumika kama utapoteza kifaa chako cha 2FA.</p>
        <div class="bg-white rounded-lg p-4 border border-yellow-300">
            <div class="grid grid-cols-2 gap-2 font-mono text-sm">
                @foreach(session('recovery_codes') as $code)
                <div class="p-2 bg-gray-50 rounded border border-gray-200">{{ $code }}</div>
                @endforeach
            </div>
        </div>
        <p class="text-xs text-yellow-600 mt-4">⚠️ Hii ni mara ya pekee utakayoona nambari hizi. Hifadhi kwa salama!</p>
    </div>
    @endif
    
    <!-- 2FA Status -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Hali ya 2FA</h2>
        
        @if($user->two_factor_enabled)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bold text-green-800">2FA Imezeweshwa</p>
                    <p class="text-sm text-green-600 mt-1">
                        Imehakikiwa: {{ $user->two_factor_confirmed_at ? $user->two_factor_confirmed_at->format('d/m/Y H:i') : 'Hajahakikiwa' }}
                    </p>
                </div>
                <span class="text-green-600 text-2xl">✓</span>
            </div>
        </div>
        
        <form method="POST" action="{{ route('settings.two-factor.disable') }}" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Thibitisha kwa Nenosiri</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors font-bold">
                Zima 2FA
            </button>
        </form>
        
        @if($user->two_factor_recovery_codes)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-md font-bold text-gray-800 mb-3">Nambari za Uokoaji</h3>
            <p class="text-sm text-gray-600 mb-4">Unaweza kutengeneza nambari mpya za uokoaji ikiwa umepoteza zako.</p>
            <form method="POST" action="{{ route('settings.two-factor.regenerate') }}">
                @csrf
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors font-bold">
                    Tengeneza Nambari Mpya za Uokoaji
                </button>
            </form>
        </div>
        @endif
        
        @else
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bold text-gray-800">2FA Imezuiwa</p>
                    <p class="text-sm text-gray-600 mt-1">Washa 2FA ili kuongeza usalama wa akaunti yako</p>
                </div>
                <span class="text-gray-400 text-2xl">✗</span>
            </div>
        </div>
        
        <form method="POST" action="{{ route('settings.two-factor.enable') }}">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold">
                Washa 2FA
            </button>
        </form>
        @endif
    </div>
    
    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <h3 class="text-lg font-bold text-blue-800 mb-3">Maelekezo</h3>
        <ul class="space-y-2 text-sm text-blue-700">
            <li>• 2FA huongeza usalama wa akaunti yako kwa kuongeza hatua ya ziada ya uthibitishaji</li>
            <li>• Baada ya kuwasha 2FA, utahitaji msimbo wa 2FA kila wakati utakapoingia</li>
            <li>• Hifadhi nambari za uokoaji kwa salama - zitasaidia ikiwa utapoteza kifaa chako</li>
            <li>• Unaweza kutumia programu za uwakilishi kama Google Authenticator au Authy</li>
        </ul>
    </div>
</div>
@endsection

