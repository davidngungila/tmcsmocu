<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ingia - TmcsSmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse-dots {
            animation: pulse 1.5s ease-in-out infinite;
        }
        .pulse-dots:nth-child(2) {
            animation-delay: 0.2s;
        }
        .pulse-dots:nth-child(3) {
            animation-delay: 0.4s;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Gradient Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-100 rounded-full opacity-20 blur-3xl"></div>
    </div>
    
    <!-- Loading Screen (shown initially) -->
    <div id="loadingScreen" class="absolute inset-0 bg-white z-50 flex flex-col items-center justify-center">
        <div class="relative">
            <!-- Outer Circle -->
            <div class="w-24 h-24 border-4 border-blue-100 rounded-full"></div>
            <!-- Inner Spinning Circle -->
            <div class="absolute top-0 left-0 w-24 h-24 border-4 border-transparent border-t-blue-600 rounded-full spinner"></div>
            <!-- Inner Crescent -->
            <div class="absolute top-2 left-2 w-20 h-20 border-4 border-blue-800 rounded-full" style="clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);"></div>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mt-8">Inaweka mipangilio ya mfumo wako...</h2>
        <p class="text-blue-600 mt-2 text-sm">Tunaandaa uzoefu bora wa mfumo</p>
        
        <!-- Progress Bar -->
        <div class="w-64 h-2 bg-gray-200 rounded-full mt-6 overflow-hidden">
            <div id="progressBar" class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-full transition-all duration-1000" style="width: 0%"></div>
        </div>
        
        <!-- Loading Dots -->
        <div class="flex space-x-2 mt-4">
            <div class="w-2 h-2 bg-blue-600 rounded-full pulse-dots"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full pulse-dots"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full pulse-dots"></div>
        </div>
    </div>
    
    <!-- Login Form (hidden initially) -->
    <div id="loginForm" class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md opacity-0 transition-opacity duration-500">
        <div class="text-center mb-8">
            <img src="{{ asset('logo.png') }}" alt="TmcsSmart Logo" class="h-16 w-auto mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-800">TmcsSmart</h1>
            <p class="text-gray-600 mt-2">Chaptance ya Mt. Yoseph Mfanyakazi</p>
        </div>
        
        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('2fa_required') || session()->has('2fa_user_id'))
            <!-- 2FA Verification Form -->
            <div id="2faForm">
                <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                    <p class="font-bold">Thibitisha Kuingia</p>
                    <p class="text-sm mt-1">Tafadhali ingiza msimbo wa 2FA kutoka kwenye programu yako ya uwakilishi</p>
                    <p class="text-xs mt-2 text-blue-600">⚠️ Simu haipo? Unaweza kuvuka 2FA kwa kubofya kitufe cha "Vuka 2FA" hapa chini</p>
                </div>
                
                <form method="POST" action="{{ route('login.2fa.verify') }}" class="space-y-6" id="twoFaVerifyForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('2fa_email') }}">
                    <input type="hidden" name="password" value="{{ session('2fa_password') }}">
                    <input type="hidden" name="remember" value="{{ session('2fa_remember') }}">
                    
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Msimbo wa 2FA au Nambari za Uokoaji</label>
                        <input type="text" id="code" name="code" autofocus maxlength="20"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-center text-xl tracking-widest"
                            placeholder="Ingiza msimbo wa 2FA au nambari za uokoaji">
                        <p class="text-xs text-gray-500 mt-2 text-center">Ingiza msimbo wa 2FA (tarakimu 6) au nambari za uokoaji (herufi 8)</p>
                    </div>
                    
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                            Thibitisha na Msimbo wa 2FA
                        </button>
                        
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">au</span>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('login.2fa.bypass') }}" class="w-full" id="twoFaBypassForm">
                            @csrf
                            <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-lg font-medium hover:bg-yellow-600 transition-colors flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Vuka 2FA (Simu Haipo)</span>
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 text-center">Kuvuka 2FA kunaweza kuathiri usalama wa akaunti yako</p>
                    </div>
                    
                    <a href="{{ route('login') }}" class="block text-center text-sm text-purple-600 hover:text-purple-700">
                        Rudi kwenye kuingia
                    </a>
                </form>
            </div>
        @else
            <!-- Regular Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginFormElement">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Barua Pepe</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nenosiri</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-600">Nikumbuke</span>
                    </label>
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700">Umesahau nenosiri?</a>
                </div>
                
                <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                    Ingia
                </button>
            </form>
        @endif
    </div>
    
    <script>
        // Simulate loading progress
        let progress = 0;
        const progressBar = document.getElementById('progressBar');
        const loadingScreen = document.getElementById('loadingScreen');
        const loginForm = document.getElementById('loginForm');
        
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) {
                progress = 100;
                clearInterval(interval);
                
                // Hide loading screen and show login form
                setTimeout(() => {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                        loginForm.style.opacity = '1';
                    }, 500);
                }, 300);
            }
            progressBar.style.width = progress + '%';
        }, 200);

        function showAuthSplash() {
            if (loadingScreen) {
                loadingScreen.style.display = 'flex';
                loadingScreen.style.opacity = '1';
            }
            if (loginForm) {
                loginForm.style.opacity = '0';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const loginFormElement = document.getElementById('loginFormElement');
            const twoFaVerifyForm = document.getElementById('twoFaVerifyForm');
            const twoFaBypassForm = document.getElementById('twoFaBypassForm');

            if (loginFormElement) {
                loginFormElement.addEventListener('submit', function() {
                    showAuthSplash();
                });
            }

            if (twoFaVerifyForm) {
                twoFaVerifyForm.addEventListener('submit', function() {
                    showAuthSplash();
                });
            }

            if (twoFaBypassForm) {
                twoFaBypassForm.addEventListener('submit', function() {
                    showAuthSplash();
                });
            }
        });
        
        // Auto-focus on 2FA code input
        @if(session('2fa_required'))
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.focus();
                // Auto-submit when 6 digits are entered
                codeInput.addEventListener('input', function(e) {
                    if (e.target.value.length === 6) {
                        showAuthSplash();
                        e.target.form.submit();
                    }
                });
            }
        });
        @endif
    </script>
</body>
</html>
