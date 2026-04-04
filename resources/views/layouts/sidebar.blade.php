<aside id="sidebar" class="fixed top-0 left-0 z-50 w-64 h-screen bg-gray-900 border-r border-gray-700 translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" alt="TmcsSmart Logo" class="h-8 w-auto">
                <span class="font-semibold text-white text-base">TmcsSmart</span>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-3">
            @php
                $user = Auth::user();
                $roles = $user->relationLoaded('roles') ? $user->roles : $user->roles()->get();
                $roleSlugs = $roles->pluck('slug')->toArray();
                
                // Debug: Log user and roles
                \Log::info('User: ' . $user->email . ' Roles: ' . json_encode($roleSlugs));
                
                $isFullAccess = in_array('system_admin', $roleSlugs) || in_array('priest', $roleSlugs);
                $canFinance = $isFullAccess || in_array('treasurer', $roleSlugs);
                $canParishioners = $isFullAccess || in_array('secretary', $roleSlugs) || in_array('leader', $roleSlugs);
                $canEvents = $isFullAccess || in_array('secretary', $roleSlugs) || in_array('leader', $roleSlugs);
                $canAssets = $isFullAccess;
                $canLeaders = $isFullAccess || in_array('leader', $roleSlugs);
                $canSms = $isFullAccess || in_array('secretary', $roleSlugs) || in_array('leader', $roleSlugs) || in_array('treasurer', $roleSlugs);
                $canSmsApproval = $isFullAccess || in_array('treasurer', $roleSlugs);
                $canReports = $isFullAccess || in_array('leader', $roleSlugs) || in_array('treasurer', $roleSlugs);
                $canSettings = $isFullAccess;
                $canCommunities = $isFullAccess || in_array('secretary', $roleSlugs) || in_array('leader', $roleSlugs);
                $canGroups = $isFullAccess || in_array('secretary', $roleSlugs) || in_array('leader', $roleSlugs);
                $currentRole = request('role') ? $roles->where('slug', request('role'))->first() : ($roles->first() ?? null);
                
                // Debug: Log permissions
                \Log::info('isFullAccess: ' . $isFullAccess . ' canFinance: ' . $canFinance . ' canParishioners: ' . $canParishioners);
            @endphp
            
           
            
            <!-- Financial Year Selector -->
            @if($isFullAccess || $canFinance)
            <div class="px-2 mb-4">
                <div class="bg-gray-800 rounded-lg p-3">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-gray-400">Financial Year</span>
                        <button onclick="toggleSubmenu('financial-year')" class="text-gray-400 hover:text-white">
                            <svg class="w-4 h-4 transition-transform" id="financial-year-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    @php
                        $activeFinancialYear = \App\Models\FinancialYear::getActive();
                        echo '<div class="text-sm font-medium text-white">' . ($activeFinancialYear ? $activeFinancialYear->name . ' (Active)' : 'No Active Year') . '</div>';
                    @endphp
                    <div id="financial-year-submenu" class="hidden mt-2 space-y-1">
                        @php
                            $financialYears = \App\Models\FinancialYear::orderBy('start_date', 'desc')->take(5)->get();
                            foreach($financialYears as $year):
                                if($year->is_active) continue; // Skip active year since it's shown above
                        @endphp
                        <a href="{{ route('settings.financial-years.index') }}" class="flex items-center px-2 py-1 text-xs text-gray-400 hover:text-white">
                            @if($year->is_closed)
                                <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                            @else
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                            @endif
                            {{ $year->name }}
                            @if($year->is_closed)
                                <span class="text-gray-500 ml-1">(Closed)</span>
                            @else
                                <span class="text-yellow-500 ml-1">(Not Started)</span>
                            @endif
                        </a>
                        @php
                            endforeach;
                        @endphp
                        <a href="{{ route('settings.financial-years.index') }}" class="flex items-center px-2 py-1 text-xs text-purple-400 hover:text-purple-300">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Manage Financial Years
                        </a>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            
            <!-- Members -->
            @if($canParishioners)
            <div>
                <button onclick="toggleSubmenu('members')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Members
                    </div>
                    <svg id="members-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="members-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('parishioners.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        All Members
                    </a>
                    <a href="{{ route('parishioners.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Register Member
                    </a>
                    <a href="{{ route('parishioners.import') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Import Members
                    </a>
                    <a href="{{ route('parishioners.member-types') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Member Types
                    </a>
                    <a href="{{ route('parishioners.manage') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        Import Members
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Member Types
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Manage Member
                    </a>
                </div>
            </div>
            @endif

            <!-- Finance -->
            @if($canFinance)
            <div>
                <button onclick="toggleSubmenu('finance')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2 1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Finance
                    </div>
                    <svg id="finance-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="finance-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('finance.contributions.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Record Contribution
                    </a>
                    <a href="{{ route('finance.contributions.import') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0C0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 0112 0v1zm0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Bulk Import
                    </a>
                    <a href="{{ route('finance.receipts') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Receipts
                    </a>
                    <a href="{{ route('finance.receipts.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Issue Receipt
                    </a>
                    <a href="{{ route('finance.expenses.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0C0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 0112 0v1zm0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Expenses
                    </a>
                    <a href="{{ route('finance.expenses.import') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0C0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 0112 0v1zm0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Bulk Import
                    </a>
                    <a href="{{ route('finance.reports.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4V-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Financial Reports
                    </a>
                </div>
            </div>
            @endif


            

            <!-- Communities -->
            @if($canCommunities)
            <div>
                <button onclick="toggleSubmenu('communities')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Communities
                    </div>
                    <svg id="communities-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="communities-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('communities.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        All Communities
                    </a>
                    <a href="{{ route('communities.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Community
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Assign Leaders
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Community Reports
                    </a>
                </div>
            </div>
            @endif

            <!-- Spiritual Groups -->
            @if($canGroups)
            <div>
                <button onclick="toggleSubmenu('spiritual-groups')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Spiritual Groups
                    </div>
                    <svg id="spiritual-groups-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="spiritual-groups-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('apostolic-groups.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        All Groups
                    </a>
                    <a href="{{ route('apostolic-groups.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Group
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Assign Leaders
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Group Reports
                    </a>
                </div>
            </div>
            @endif

            <!-- Certificates -->
            @if($isFullAccess)
            <div>
                <button onclick="toggleSubmenu('certificates')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Certificates
                    </div>
                    <svg id="certificates-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="certificates-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('certificates.finalist.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Generate Finalist Certificates
                    </a>
                    <a href="{{ route('certificates.group.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Generate Group Certificates
                    </a>
                    <a href="{{ route('certificates.templates') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Certificate Templates
                    </a>
                    <a href="{{ route('public.verify.form') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        Verify Certificate (Public Portal)
                    </a>
                    <a href="{{ route('certificates.log') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Certificate Log
                    </a>
                    <a href="{{ route('certificates.my') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Certificates
                    </a>
                    <a href="{{ route('certificates.pending') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pending Approval
                    </a>
                    <a href="{{ route('certificates.revoked') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Revoked Certificates
                    </a>
                    <a href="{{ route('certificates.bulk-download') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0C0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 0112 0v1zm0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Bulk Download
                    </a>
                    <a href="{{ route('certificates.settings') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.14c1.906-.94 2.1-3.547.194-4.454a2.5 2.5 0 00-3.388 0c-.906.907-1.712 3.514-.194 4.454a1.724 1.724 0 002.573 1.14zm-3.388 1.854a2.5 2.5 0 11-3.388 3.388 2.5 2.5 0 013.388-3.388z"></path>
                        </svg>
                        Certificate Settings
                    </a>
                </div>
            </div>
            @endif

            <!-- Events -->
            @if($canEvents)
            <div>
                <button onclick="toggleSubmenu('events')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Events
                    </div>
                    <svg id="events-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="events-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('events.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Event
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Events
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A15.937 15.937 0 0112 16c4 0 7.8-.7 11.308-2.021M5.121 17.804A15.937 15.937 0 0112 16c-4 0-7.8.7-11.308 2.021M12 12c0 4-1.343 7.25-3.5 9.5m7-9.5c0 4-1.343 7.25-3.5 9.5M12 12c0-4 1.343-7.25 3.5-9.5m-7 9.5c0-4 1.343-7.25 3.5-9.5"></path>
                        </svg>
                        Event Chairperson
                    </a>
                    <a href="{{ route('events.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        All Events
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Event Reports
                    </a>
                </div>
            </div>
            @endif

            <!-- Elections -->
            @if($isFullAccess)
            <div>
                <button onclick="toggleSubmenu('elections')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        Elections
                    </div>
                    <svg id="elections-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="elections-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Manage Elections
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Nominations
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Interviews
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        Voting (if applicable)
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Election Results
                    </a>
                </div>
            </div>
            @endif

            <!-- Assets -->
            @if($canAssets)
            <div>
                <button onclick="toggleSubmenu('assets')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Assets
                    </div>
                    <svg id="assets-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="assets-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('assets.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        All Assets
                    </a>
                    <a href="{{ route('assets.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Register Asset
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4-4m-4 4l4 4"></path>
                        </svg>
                        Check Out / Check In
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Maintenance Schedule
                    </a>
                </div>
            </div>
            @endif

            <!-- Shop (POS) -->
            @if($isFullAccess)
            <div>
                <button onclick="toggleSubmenu('shop')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Shop (POS)
                    </div>
                    <svg id="shop-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="shop-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 002 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2a2 2 0 012-2h.586m0 0a1 1 0 01.707-.293l.586-.586a1 1 0 01.707-.293l1.414 1.414a1 1 0 00.707.293H17"></path>
                        </svg>
                        Point of Sale
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Inventory
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Sales Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Low Stock Alerts
                    </a>
                </div>
            </div>
            @endif

            <!-- Communication -->
            @if($canSms)
            <div>
                <button onclick="toggleSubmenu('communication')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Communication
                    </div>
                    <svg id="communication-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="communication-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Send SMS (NextSMS)
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Email
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.068-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        Broadcast Message
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Scheduled Messages
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Communication Log
                    </a>
                </div>
            </div>
            @endif

            <!-- Reports -->
            @if($canReports)
            <div>
                <button onclick="toggleSubmenu('reports')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Reports
                    </div>
                    <svg id="reports-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="reports-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Member Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Financial Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138 3.42 3.42 0 001.946-.806z"></path>
                        </svg>
                        Certificate Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Event Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        Election Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Asset Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Shop Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Communication Reports
                    </a>
                    <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        System Audit Log
                    </a>
                </div>
            </div>
            @endif

            <!-- Administration (Settings) -->
            @if($canSettings)
            <div>
                <button onclick="toggleSubmenu('administration')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-1.756.426-1.756 2.924 0 3.35a1.724 1.724 0 001.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065 1.756-.426 1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.572c-1.543-.94-3.31.826-2.37 2.37a1.724 1.724 0 00-2.572-1.065c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996-.608 2.296-.07 2.572 1.065 1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.572c-1.756.426-1.756 2.924 0 3.35z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        System Settings
                    </div>
                    <svg id="administration-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="administration-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                    <a href="{{ route('settings.system.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-1.756.426-1.756 2.924 0 3.35a1.724 1.724 0 001.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065 1.756-.426 1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.572c-1.543-.94-3.31.826-2.37 2.37a1.724 1.724 0 00-2.572-1.065c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996-.608 2.296-.07 2.572 1.065 1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.572c-1.756.426-1.756 2.924 0 3.35z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        System Overview
                    </a>
                    <a href="{{ route('settings.permissions.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Roles & Permissions
                    </a>
                    <a href="{{ route('settings.general') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-1.756.426-1.756 2.924 0 3.35a1.724 1.724 0 001.066 2.573c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065 1.756-.426 1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 00-1.066-2.572c-1.543-.94-3.31.826-2.37 2.37a1.724 1.724 0 00-2.572-1.065c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996-.608 2.296-.07 2.572 1.065 1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.572c-1.756.426-1.756 2.924 0 3.35z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        System Settings
                    </a>
                    <a href="{{ route('settings.system.backup.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Backup & Restore
                    </a>
                    <a href="{{ route('locations.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Locations Management
                    </a>
                    <a href="{{ route('finance.contributions.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .434-3 3s.434 3 3 3 3-.434 3-3 3-.434 3-3 3zm0 0l6 6m-6-6L6 6m6-6v6a2 2 0 002 2h2a2 2 0 002-2v-6m-6 0v6a2 2 0 002 2h2a2 2 0 002-2v-6"></path>
                        </svg>
                        Contributions
                    </a>
                    <a href="{{ route('finance.contributions.import') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0C0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 0112 0v1zm0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Bulk Import
                    </a>
                    <a href="{{ route('finance.receipts') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Manage Receipts
                    </a>
                    <a href="{{ route('finance.receipts.create') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        </svg>
                        Manage Expenses
                    </a>
                    <a href="{{ route('finance.expenses.import') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0C0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 0112 0v1zm0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Bulk Import
                    </a>
                    <a href="{{ route('finance.reports.index') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h6a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2v-6m-6 0v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Financial Reports
                    </a>
                    <a href="{{ route('settings.system.health') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        System Health
                    </a>
                </div>
            </div>
            @endif

            <!-- Profile -->
            <div class="border-t border-gray-700 mt-4 pt-4">
                <div>
                    <button onclick="toggleSubmenu('profile')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </div>
                        <svg id="profile-arrow" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="profile-submenu" class="hidden mt-1 ml-7 space-y-0.5">
                        <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                            <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Profile
                        </a>
                        <a href="#" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                            <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Change Password
                        </a>
                        <a href="{{ route('logout') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-400 rounded-md hover:bg-gray-800 hover:text-white">
                            <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>


    <script>
        function toggleSubmenu(menu) {
            const submenu = document.getElementById(menu + '-submenu');
            const arrow = document.getElementById(menu + '-arrow');
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</aside>
