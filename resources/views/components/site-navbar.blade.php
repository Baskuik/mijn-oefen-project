<div class="bg-white shadow-sm border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-slate-900">
                    MyShop
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex space-x-8">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-slate-900 font-medium">Products</a>
            </nav>

            <!-- Right side: Cart + User -->
            <div class="flex items-center gap-5">

                <!-- Cart icon -->
                <a href="{{ route('cart') }}" class="relative text-slate-700 hover:text-slate-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(session('cart_count', 0) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ session('cart_count', 0) }}
                        </span>
                    @endif
                </a>

                <!-- User dropdown (logged in) -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-1.5 text-slate-700 hover:text-slate-900 focus:outline-none transition-colors duration-200">
                                {{-- User circle icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{-- Chevron --}}
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Logged-in name --}}
                            <div class="px-4 py-2 text-xs text-gray-400 border-b border-gray-100 truncate">
                                {{ Auth::user()->name }}
                            </div>

                            <x-dropdown-link :href="route('profile.edit')">
                                Account
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('dashboard')">
                                Bestellingen inzien
                            </x-dropdown-link>

                            {{-- Logout (POST) --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Guest links --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                           class="text-slate-700 hover:text-slate-900 text-sm font-medium transition-colors">
                            Inloggen
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors duration-200">
                            Registreren
                        </a>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</div>