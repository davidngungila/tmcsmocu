<header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 md:px-6 lg:px-8 shadow-sm sticky top-0 z-30">
    <div class="flex items-center space-x-4">
        <!-- Mobile menu button -->
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Search -->
        <div class="hidden md:flex items-center min-w-0">
            <div class="relative min-w-0">
                <input type="text" placeholder="Tafuta (Ctrl+K)" class="pl-10 pr-4 py-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent w-56 lg:w-64">
                <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="flex items-center space-x-4">
        @php
            $headerAvailableRoles = (Auth::user() && ((Auth::user()->role->slug ?? null) === 'admin'))
                ? \App\Models\Role::orderBy('name')->get()
                : (Auth::user()?->availableRoles() ?? collect());
            $headerActiveRoleId = session('active_role_id');
            $headerActiveRole = $headerActiveRoleId ? $headerAvailableRoles->firstWhere('id', $headerActiveRoleId) : null;
            $headerActiveRole = $headerActiveRole ?: (Auth::user()->role ?? $headerAvailableRoles->first());
            $isImpersonating = session()->has('impersonate_user_id') && session()->has('impersonator_user_id');
            $isAdmin = (Auth::user()->role->slug ?? null) === 'admin';
            $impersonationUsers = $isAdmin ? \App\Models\User::select('id', 'name', 'email')->orderBy('name')->get() : collect();
        @endphp

        <form method="POST" action="{{ route('switch-role') }}" class="flex items-center space-x-2">
            @csrf
            <span class="text-sm text-gray-600 whitespace-nowrap">Role:</span>
            <select name="role_id" onchange="this.form.submit()" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent max-w-44">
                @foreach($headerAvailableRoles as $role)
                    <option value="{{ $role->id }}" {{ ($headerActiveRole && $headerActiveRole->id === $role->id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </form>

        @if($isAdmin)
            @if($isImpersonating)
                <form method="POST" action="{{ route('impersonate.stop') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="px-3 py-2 text-sm border border-red-200 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors">
                        Stop Switching User
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('impersonate.start') }}" class="hidden md:block">
                    @csrf
                    <select name="user_id" onchange="this.form.submit()" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent max-w-56">
                        <option value="">Switch User (Admin)</option>
                        @foreach($impersonationUsers as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </form>
            @endif
        @endif

        <!-- Notifications Dropdown -->
        <div class="relative group" id="notifications-group">
            <button onclick="toggleNotificationsMenu()" class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-1 right-1 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>
            
            <!-- Notifications Dropdown Menu -->
            <div id="notifications-menu" class="absolute right-0 sm:right-0 mt-2 w-[calc(100vw-2rem)] sm:w-72 md:w-80 max-w-sm bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 max-h-[calc(100vh-5rem)] overflow-hidden flex flex-col">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-800">Arifa</h3>
                        <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">3 mpya</span>
                    </div>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Mapato mapya yameandikwa</p>
                                <p class="text-xs text-gray-500 mt-1">TZS 50,000 yameongezwa kwenye mapato</p>
                                <p class="text-xs text-gray-400 mt-1">Dakika 2 zilizopita</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Idhini ya SMS inasubiri</p>
                                <p class="text-xs text-gray-500 mt-1">Kampeni "Sasisho la Wiki" inahitaji idhini</p>
                                <p class="text-xs text-gray-400 mt-1">Dakika 15 zilizopita</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Mwanachama mpya amesajiliwa</p>
                                <p class="text-xs text-gray-500 mt-1">John Doe amesajiliwa</p>
                                <p class="text-xs text-gray-400 mt-1">Saa 1 iliyopita</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 hover:bg-gray-50 cursor-pointer transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Tukio limepangwa</p>
                                <p class="text-xs text-gray-500 mt-1">Misa ya Jumapili imepangwa kesho</p>
                                <p class="text-xs text-gray-400 mt-1">Masaa 2 yaliyopita</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-t border-gray-200 bg-gray-50 text-center">
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">Angalia arifa zote</a>
                </div>
            </div>
        </div>
        
        <!-- User Profile Dropdown -->
        <div class="relative group" id="profile-group">
            <button onclick="toggleProfileMenu()" class="flex items-center space-x-3 hover:bg-gray-50 rounded-lg px-3 py-2 border border-transparent hover:border-gray-200 transition-all duration-200">
                <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm border-2 border-white shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ $isAdmin ? 'System Admin' : (Auth::user()->name ?? 'User') }}</p>
                    <p class="text-xs text-gray-500 leading-tight">{{ $isAdmin ? 'admin@example.com' : (Auth::user()->email ?? '') }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-500 hidden md:block transition-transform group-hover:rotate-180 duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <!-- Profile Dropdown Menu -->
            <div id="profile-menu" class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border-2 border-gray-200 hidden z-50 overflow-hidden transition-all duration-300 opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100">
                <div class="p-2">
                    <div class="px-3 py-2 mb-2 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $isAdmin ? 'System Admin' : (Auth::user()->name ?? 'User') }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $isAdmin ? 'admin@example.com' : (Auth::user()->email ?? '') }}</p>
                                <p class="text-xs text-gray-500 truncate">Role: {{ $headerActiveRole->name ?? 'No Role' }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition-colors border-l-2 border-transparent hover:border-purple-500">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Wasifu Wangu
                    </a>
                    <a href="{{ route('settings.account') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition-colors border-l-2 border-transparent hover:border-purple-500">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.14c1.906-.94 2.1-3.547.194-4.454a2.5 2.5 0 00-3.388 0c-.906.907-1.712 3.514-.194 4.454a1.724 1.724 0 002.573 1.14zm-3.388 1.854a2.5 2.5 0 11-3.388 3.388 2.5 2.5 0 013.388-3.388z"></path>
                        </svg>
                        Mipangilio ya Akunti
                    </a>
                    <a href="{{ route('settings.security') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition-colors border-l-2 border-transparent hover:border-purple-500">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Usalama
                    </a>
                    <div class="border-t border-gray-200 my-2"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors border-l-2 border-transparent hover:border-red-500">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Toka
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleProfileMenu() {
        const menu = document.getElementById('profile-menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('scale-95');
        menu.classList.toggle('opacity-100');
        menu.classList.toggle('scale-100');
    }
    
    function toggleNotificationsMenu() {
        const menu = document.getElementById('notifications-menu');
        const isVisible = !menu.classList.contains('invisible');
        
        if (isVisible) {
            menu.classList.add('opacity-0');
            menu.classList.add('invisible');
        } else {
            menu.classList.remove('opacity-0');
            menu.classList.remove('invisible');
        }
    }
    
    // Close menus when clicking outside
    document.addEventListener('click', function(event) {
        // Profile menu
        const profileButton = event.target.closest('[onclick="toggleProfileMenu()"]');
        const profileMenu = document.getElementById('profile-menu');
        
        if (!profileButton && profileMenu && !profileMenu.contains(event.target)) {
            profileMenu.classList.add('hidden');
            profileMenu.classList.add('opacity-0');
            profileMenu.classList.add('scale-95');
            profileMenu.classList.remove('opacity-100');
            profileMenu.classList.remove('scale-100');
        }
        
        // Notifications menu
        const notificationsButton = event.target.closest('[onclick="toggleNotificationsMenu()"]');
        const notificationsGroup = document.getElementById('notifications-group');
        const notificationsMenu = document.getElementById('notifications-menu');
        
        if (!notificationsButton && notificationsGroup && !notificationsGroup.contains(event.target)) {
            notificationsMenu.classList.add('opacity-0');
            notificationsMenu.classList.add('invisible');
        }
    });
    
    // Show menus on hover (desktop only)
    document.addEventListener('DOMContentLoaded', function() {
        // Profile menu hover
        const profileGroup = document.getElementById('profile-group');
        const profileMenu = document.getElementById('profile-menu');
        
        if (profileGroup && profileMenu) {
            profileGroup.addEventListener('mouseenter', function() {
                if (window.innerWidth >= 768) { // Only on desktop
                    profileMenu.classList.remove('hidden');
                    profileMenu.classList.remove('opacity-0');
                    profileMenu.classList.remove('scale-95');
                    profileMenu.classList.add('opacity-100');
                    profileMenu.classList.add('scale-100');
                }
            });
            
            profileGroup.addEventListener('mouseleave', function() {
                if (window.innerWidth >= 768) { // Only on desktop
                    profileMenu.classList.add('opacity-0');
                    profileMenu.classList.add('scale-95');
                    setTimeout(() => {
                        if (profileMenu.classList.contains('opacity-0')) {
                            profileMenu.classList.add('hidden');
                        }
                    }, 200);
                }
            });
        }
        
        // Notifications menu hover
        const notificationsGroup = document.getElementById('notifications-group');
        const notificationsMenu = document.getElementById('notifications-menu');
        
        if (notificationsGroup && notificationsMenu) {
            notificationsGroup.addEventListener('mouseenter', function() {
                if (window.innerWidth >= 768) { // Only on desktop
                    notificationsMenu.classList.remove('opacity-0');
                    notificationsMenu.classList.remove('invisible');
                }
            });
            
            notificationsGroup.addEventListener('mouseleave', function() {
                if (window.innerWidth >= 768) { // Only on desktop
                    notificationsMenu.classList.add('opacity-0');
                    notificationsMenu.classList.add('invisible');
                }
            });
        }
    });
</script>
