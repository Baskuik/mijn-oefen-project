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

            <!-- Right Side: Conditional Display Based on Auth Status -->
            <div class="flex items-center space-x-4">
                @guest
                    <!-- Register & Login Buttons (when logged out) -->
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-md transition">
                        Register
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition">
                        Login
                    </a>
                @endguest

                @auth
                    <!-- Cart Icon (when logged in) -->
                    <a href="{{ route('cart') }}" class="relative text-slate-700 hover:text-slate-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if(session('cart_count', 0) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ session('cart_count', 0) }}
                            </span>
                        @endif
                    </a>

                    <!-- User Icon with Dropdown (when logged in) -->
                    <div x-data="{ open: false }" class="relative">
                        <!-- User Icon Button -->
                        <button @click="open = !open" class="text-slate-700 hover:text-slate-900 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50"
                             style="display: none;">
                            
                            <!-- Account Link (placeholder) -->
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                Account
                            </a>

                            <!-- Mijn bestellingen Link (placeholder) -->
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                Mijn bestellingen
                            </a>

                            <!-- Divider -->
                            <div class="border-t border-slate-200 my-1"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>