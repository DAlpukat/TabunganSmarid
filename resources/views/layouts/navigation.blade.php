<nav x-data="{ open: false }" class="glass-effect border-b border-[rgba(225,213,181,0.2)]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-[#e1d5b5]" />
                        <span class="text-xl font-bold gradient-text">MONETIX</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#e1d5b5] hover:text-[#d2c39a] transition-colors">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.index')" class="text-[#e1d5b5] hover:text-[#d2c39a] transition-colors">
                        {{ __('Hutang') }}
                    </x-nav-link>
                    <x-nav-link :href="route('budgets.index')" :active="request()->routeIs('budgets.*')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Anggaran
                    </x-nav-link>
                    <x-nav-link href="{{ route('announcements.public.index') }}" :active="request()->routeIs('announcements.public.index')" class="text-[#e1d5b5] hover:text-[#d2c39a] transition-colors">
                        {{ __('Berita') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown & Streak (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Streak Display (Desktop) -->
                <x-streak-icon />

                <!-- Profile Dropdown -->
                <div class="relative ms-3" x-data="{ open: false }">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[#e1d5b5] bg-transparent hover:text-[#d2c39a] focus:outline-none transition ease-in-out duration-150 glass-effect">
                                <!-- Tampilkan Foto Profil -->
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                                         class="h-8 w-8 rounded-full object-cover mr-2 border border-[#e1d5b5]">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-[rgba(225,213,181,0.2)] flex items-center justify-center mr-2 text-sm font-bold text-[#e1d5b5] border border-[#e1d5b5]">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div class="text-[#e1d5b5]">{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4 text-[#e1d5b5]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-[rgba(225,213,181,0.2)]">
                                <div class="font-medium text-[#e1d5b5]">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-[#d2c39a]">{{ Auth::user()->email }}</div>
                            </div>

                            <!-- Admin Panel Menu -->
                            @if(auth()->user()->is_admin)
                                <div class="border-t border-[rgba(225,213,181,0.2)] py-1">
                                    <div class="px-4 py-2 text-xs font-semibold text-green-400 uppercase tracking-wider">Admin Panel</div>
                                    
                                    <x-dropdown-link :href="route('admin.users.index')">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        {{ __('Kelola Pengguna') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('announcements.index')">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                                        </svg>
                                        {{ __('Kelola Berita') }}
                                    </x-dropdown-link>
                                </div>
                            @endif

                            <!-- Regular Menu -->
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#e1d5b5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Logout -->
                            <div class="border-t border-[rgba(225,213,181,0.2)]"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-[#e1d5b5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[#e1d5b5] hover:text-[#d2c39a] hover:bg-[rgba(225,213,181,0.1)] focus:outline-none focus:bg-[rgba(225,213,181,0.1)] focus:text-[#d2c39a] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden glass-effect border-t border-[rgba(225,213,181,0.2)]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.index')">
                {{ __('Hutang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('announcements.public.index')" :active="request()->routeIs('announcements.public.index')">
                {{ __('Berita') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[rgba(225,213,181,0.2)]">
            <div class="flex items-center px-4">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="h-10 w-10 rounded-full object-cover mr-3 border border-[#e1d5b5]">
                @else
                    <div class="h-10 w-10 rounded-full bg-[rgba(225,213,181,0.2)] flex items-center justify-center mr-3 text-lg font-bold text-[#e1d5b5] border border-[#e1d5b5]">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-grow">
                    <div class="font-medium text-base text-[#e1d5b5]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-[#d2c39a]">{{ Auth::user()->email }}</div>
                    <x-streak-icon class="mt-1" size="6" textClass="text-sm" id="Mobile" />
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Admin Menu di Mobile -->
                @if(auth()->user()->is_admin)
                    <div class="pt-3 pb-2 px-4 text-xs font-semibold text-green-400 uppercase tracking-wider border-b border-[rgba(225,213,181,0.2)]">Admin Panel</div>
                    
                    <x-responsive-nav-link :href="route('admin.users.index')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        {{ __('Kelola Pengguna') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('announcements.index')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                        </svg>
                        {{ __('Kelola Berita') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#e1d5b5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#e1d5b5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>