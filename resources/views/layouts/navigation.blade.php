<nav x-data="{ open: false }" class="glass-effect border-b border-[rgba(225,213,181,0.2)]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-[#e1d5b5]" />
                        <span class="text-xl font-bold gradient-text">DEGODEGA</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#e1d5b5] hover:text-[#d2c39a] transition-colors">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" class="text-[#e1d5b5] hover:text-[#d2c39a] transition-colors">
                        {{ __('Transaksi') }}
                    </x-nav-link>
                    <x-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.index')" class="text-[#e1d5b5] hover:text-[#d2c39a] transition-colors">
                        {{ __('Hutang') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown & Streak (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Streak Display (Desktop) -->
                <x-streak-icon />

                <!-- Profile Dropdown -->
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
                        <!-- Dropdown content remains the same -->
                        <div class="px-4 py-2 border-b border-[rgba(225,213,181,0.2)]">
                            <div class="font-medium text-[#e1d5b5]">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-[#d2c39a]">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center text-[#e1d5b5] hover:bg-[rgba(225,213,181,0.1)]">
                            <svg class="w-4 h-4 mr-2 text-[#e1d5b5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="flex items-center text-[#e1d5b5] hover:bg-[rgba(225,213,181,0.1)]">
                                <svg class="w-4 h-4 mr-2 text-[#e1d5b5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#e1d5b5] hover:text-[#d2c39a]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" class="text-[#e1d5b5] hover:text-[#d2c39a]">
                {{ __('Transaksi') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.index')" class="text-[#e1d5b5] hover:text-[#d2c39a]">
                {{ __('Hutang') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[rgba(225,213,181,0.2)]">
            <div class="flex items-center px-4">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                         class="h-10 w-10 rounded-full object-cover mr-3 border border-[#e1d5b5]">
                @else
                    <div class="h-10 w-10 rounded-full bg-[rgba(225,213,181,0.2)] flex items-center justify-center mr-3 text-lg font-bold text-[#e1d5b5] border border-[#e1d5b5]">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-grow">
                    <div class="font-medium text-base text-[#e1d5b5]">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-[#d2c39a]">{{ Auth::user()->email }}</div>
                    <!-- ... di dalam bagian responsive navigation ... -->
                    <!-- apiapi -->
                    <x-streak-icon class="mt-1" size="6" textClass="text-sm" id="Mobile" />
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center text-[#e1d5b5] hover:text-[#d2c39a]">
                    <svg class="w-5 h-5 mr-2 text-[#e1d5b5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="flex items-center text-[#e1d5b5] hover:text-[#d2c39a]">
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