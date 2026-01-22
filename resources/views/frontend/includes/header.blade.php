<header class="fixed top-8 left-1/2 -translate-x-1/2 z-50 w-[90%] max-w-7xl" x-data="{ mobileOpen: false, userOpen: false, langOpen: false }">
    <nav class="glass-crystal rounded-full px-6 md:px-8 py-4 flex items-center justify-between relative transition-all duration-300">
        {{-- LEFT — LOGO --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group" wire:navigate>
            <span class="font-serif text-xl font-extralight tracking-widest text-prestige-gold uppercase group-hover:text-gray-800 transition-colors duration-300">
                {{ app_name() }}
            </span>
        </a>

        {{-- CENTER — DESKTOP MENU --}}
        <x-frontend.dynamic-menu 
            location="frontend-header" 
            itemComponent="components.frontend.kuniverse-menu-item" 
            cssClass="hidden lg:flex absolute left-1/2 -translate-x-1/2 items-center gap-6 lg:gap-8" 
        />

        {{-- RIGHT — DESKTOP ACTIONS --}}
        <div class="hidden lg:flex items-center gap-3">
             {{-- Language Switcher --}}
             <div class="relative">
                <button 
                    @click="langOpen = !langOpen" 
                    @click.away="langOpen = false"
                    class="flex items-center gap-1 text-sm font-medium text-gray-700 hover:text-prestige-gold transition-colors duration-200"
                >
                    <span class="material-symbols-outlined text-lg">language</span>
                    <span class="uppercase">{{ app()->currentLocale() }}</span>
                    <span class="material-symbols-outlined text-base transition-transform duration-200" :class="{'rotate-180': langOpen}">expand_more</span>
                </button>
                <div 
                    x-show="langOpen" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                    style="display: none;"
                    class="absolute top-full right-0 mt-3 w-32 glass-crystal rounded-xl py-2 shadow-xl flex flex-col gap-1 text-sm bg-white/80 backdrop-blur-xl border border-white/40"
                >
                    @foreach (config("app.available_locales") as $locale_code => $locale_name)
                        <a 
                            href="{{ route('language.switch', $locale_code) }}"
                            class="px-4 py-2 hover:bg-prestige-gold/10 hover:text-prestige-gold transition-colors text-left"
                            @click="langOpen = false"
                        >
                            {{ $locale_name }}
                        </a>
                    @endforeach
                </div>
            </div>

            @guest
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="flex items-center gap-2 bg-prestige-gold text-white px-5 py-2 rounded-full text-[13px] font-bold uppercase tracking-widest hover:bg-[#a6854e] transition-all hover:scale-105 active:scale-95 shadow-md shadow-prestige-gold/20"
                >
                    <span class="material-symbols-outlined text-lg normal-case">login</span>
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    wire:navigate
                    class="flex items-center gap-2 border border-prestige-gold text-prestige-gold px-5 py-2 rounded-full text-[13px] font-bold uppercase tracking-widest hover:bg-prestige-gold hover:text-white transition-all hover:scale-105 active:scale-95"
                >
                    <span class="material-symbols-outlined text-lg normal-case">person_add</span>
                    Register
                </a>
            @else
                {{-- User Dropdown --}}
                <div class="relative">
                    <button 
                        @click="userOpen = !userOpen" 
                        @click.away="userOpen = false"
                        class="flex items-center gap-2 pl-2 pr-1 py-1 rounded-full border border-gray-200 hover:border-prestige-gold transition-all bg-white/50 hover:bg-white"
                    >
                        <img
                            class="h-8 w-8 rounded-full object-cover ring-2 ring-white"
                            src="{{ Str::startsWith(Auth::user()->avatar, ['http', 'https']) ? Auth::user()->avatar : asset(Auth::user()->avatar) }}"
                            alt="{{ Auth::user()->name }}"
                        />
                        <span class="text-sm font-medium text-gray-700 pr-2 max-w-[100px] truncate">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="material-symbols-outlined text-gray-400 transition-transform duration-200" :class="{'rotate-180': userOpen}">expand_more</span>
                    </button>

                    <div 
                        x-show="userOpen" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        style="display: none;"
                        class="absolute top-full right-0 mt-3 w-56 glass-crystal rounded-xl py-2 shadow-2xl flex flex-col text-sm bg-white/90 backdrop-blur-xl border border-white/50 z-50"
                    >
                        {{-- Header --}}
                        <div class="px-4 py-3 border-b border-gray-100">
                            <span class="block text-sm text-gray-900 font-bold">{{ Auth::user()->name }}</span>
                            <span class="block text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</span>
                        </div>

                        {{-- Menu --}}
                        <div class="py-1">
                            @hasrole('merchant')
                                <a href="{{ route('merchant.dashboard') }}" wire:navigate class="px-4 py-2 hover:bg-prestige-gold/5 hover:text-prestige-gold transition flex items-center gap-3 text-gray-700">
                                    <span class="material-symbols-outlined text-lg">dashboard</span>
                                    Dashboard
                                </a>
                            @else
                                @can('view_backend')
                                    <a href="{{ route('backend.dashboard') }}" wire:navigate class="px-4 py-2 hover:bg-prestige-gold/5 hover:text-prestige-gold transition flex items-center gap-3 text-gray-700">
                                        <span class="material-symbols-outlined text-lg">dashboard</span>
                                        Dashboard
                                    </a>
                                @endcan
                            @endhasrole
                            
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <a href="{{ route('frontend.users.profile') }}" wire:navigate class="block px-4 py-3 hover:bg-gray-50 hover:text-prestige-gold transition flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">person</span> Profile
                                    </a>
                                </li>
                                @unlessrole('admin|merchant')
                                    <li>
                                        <a href="{{ route('frontend.booking.history') }}" wire:navigate class="block px-4 py-3 hover:bg-gray-50 hover:text-prestige-gold transition flex items-center gap-2">
                                            <span class="material-symbols-outlined text-lg">confirmation_number</span> Tiket Saya
                                        </a>
                                    </li>
                                @endunlessrole
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 hover:bg-red-50 hover:text-red-600 transition flex items-center gap-2 text-red-500">
                                            <span class="material-symbols-outlined text-lg">logout</span> Sign out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endguest
        </div>

        {{-- MOBILE — HAMBURGER --}}
        <button
            @click="mobileOpen = !mobileOpen"
            class="lg:hidden text-prestige-gold text-2xl focus:outline-none p-1 rounded-md hover:bg-gray-100/50 transition-colors"
            aria-label="Toggle menu"
        >
            <span class="material-symbols-outlined block transition-transform duration-300" :class="{'rotate-90 opacity-0 absolute': mobileOpen, 'rotate-0 opacity-100': !mobileOpen}">menu</span>
            <span class="material-symbols-outlined block transition-transform duration-300" :class="{'-rotate-90 opacity-0 absolute': !mobileOpen, 'rotate-0 opacity-100': mobileOpen}">close</span>
        </button>

        {{-- MOBILE MENU --}}
        <div
            x-show="mobileOpen"
            style="display: none;"
            @click.away="mobileOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
            class="absolute top-full left-0 w-full mt-4 glass-crystal rounded-3xl px-6 py-8 flex flex-col gap-6 text-center lg:hidden bg-white/95 backdrop-blur-2xl shadow-2xl border border-white/50"
        >
            <x-frontend.dynamic-menu 
                location="frontend-header" 
                itemComponent="components.frontend.kuniverse-mobile-menu-item" 
                cssClass="flex flex-col w-full items-center gap-6" 
            />

            {{-- MOBILE ACTIONS --}}
            <div class="flex flex-col gap-3 pt-6 border-t border-gray-100/50 w-full">
                @guest
                    <a
                        href="{{ route('login') }}"
                        wire:navigate
                        @click="mobileOpen = false"
                        class="flex items-center justify-center gap-2 bg-prestige-gold text-white px-6 py-3 rounded-full text-[12px] font-bold uppercase tracking-widest hover:bg-[#a6854e] transition-all active:scale-95 shadow-lg shadow-prestige-gold/20"
                    >
                        <span class="material-symbols-outlined text-lg">login</span>
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        wire:navigate
                        @click="mobileOpen = false"
                        class="flex items-center justify-center gap-2 border border-prestige-gold text-prestige-gold px-6 py-3 rounded-full text-[12px] font-bold uppercase tracking-widest hover:bg-prestige-gold hover:text-white transition-all active:scale-95"
                    >
                        <span class="material-symbols-outlined text-lg">person_add</span>
                        Register
                    </a>
                @else
                    {{-- User Profile Section in Mobile --}}
                    <div class="flex flex-col items-center gap-2 mb-4">
                        <img
                            class="h-16 w-16 rounded-full object-cover ring-4 ring-white shadow-md mb-2"
                            src="{{ Str::startsWith(Auth::user()->avatar, ['http', 'https']) ? Auth::user()->avatar : asset(Auth::user()->avatar) }}"
                            alt="{{ Auth::user()->name }}"
                        />
                        <div>
                            <span class="block text-gray-900 font-bold text-lg">{{ Auth::user()->name }}</span>
                            <span class="block text-gray-500 text-sm">{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 w-full">
                         @if(auth()->user()->hasRole('merchant'))
                            <a href="{{ route('merchant.dashboard') }}" wire:navigate class="flex flex-col items-center justify-center gap-1 bg-gray-50 hover:bg-prestige-gold/10 p-3 rounded-xl transition text-gray-700 hover:text-prestige-gold">
                                <span class="material-symbols-outlined text-2xl">dashboard</span>
                                <span class="text-xs font-semibold">Dashboard</span>
                            </a>
                        @elseif(auth()->user()->can('view_backend'))
                            <a href="{{ route('backend.dashboard') }}" wire:navigate class="flex flex-col items-center justify-center gap-1 bg-gray-50 hover:bg-prestige-gold/10 p-3 rounded-xl transition text-gray-700 hover:text-prestige-gold">
                                <span class="material-symbols-outlined text-2xl">dashboard</span>
                                <span class="text-xs font-semibold">Dashboard</span>
                            </a>
                        @endif
                        
                        <a href="{{ route('frontend.users.profile') }}" wire:navigate class="flex flex-col items-center justify-center gap-1 bg-gray-50 hover:bg-prestige-gold/10 p-3 rounded-xl transition text-gray-700 hover:text-prestige-gold">
                            <span class="material-symbols-outlined text-2xl">person</span>
                            <span class="text-xs font-semibold">Profile</span>
                        </a>

                        @unlessrole('admin|merchant')
                            <a href="{{ route('frontend.booking.history') }}" wire:navigate class="flex flex-col items-center justify-center gap-1 bg-gray-50 hover:bg-prestige-gold/10 p-3 rounded-xl transition text-gray-700 hover:text-prestige-gold">
                                <span class="material-symbols-outlined text-2xl">confirmation_number</span>
                                <span class="text-xs font-semibold">Tiket Saya</span>
                            </a>
                        @endunlessrole

                        <a href="{{ route('frontend.users.profileEdit') }}" wire:navigate class="flex flex-col items-center justify-center gap-1 bg-gray-50 hover:bg-prestige-gold/10 p-3 rounded-xl transition text-gray-700 hover:text-prestige-gold">
                             <span class="material-symbols-outlined text-2xl">settings</span>
                             <span class="text-xs font-semibold">Settings</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="col-span-2">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-6 py-3 rounded-xl text-sm font-bold transition-all mt-2">
                                <span class="material-symbols-outlined">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>
