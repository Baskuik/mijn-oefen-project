<div class="bg-white shadow-sm border-b border-slate-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo -->
      <div class="flex-shrink-0">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-slate-900">MijnShop</a>
      </div>

      <!-- Nav -->
      <nav class="flex space-x-8">
        <a href="{{ route('home') }}" class="text-slate-700 hover:text-slate-900 font-medium">Producten</a>
      </nav>

      <!-- Right: Cart + User -->
      <div class="flex items-center gap-5">

        <!-- Cart (Livewire component — updates in real time) -->
        <livewire:cart-counter />

        <!-- User -->
        @auth
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button class="flex items-center gap-1.5 text-slate-700 hover:text-slate-900 focus:outline-none transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
              </button>
            </x-slot>

            <x-slot name="content">
              <div class="px-4 py-2 text-xs text-gray-400 border-b border-gray-100 truncate">
                {{ Auth::user()->name }}
              </div>

              <x-dropdown-link :href="route('account.index')">Account</x-dropdown-link>
              <x-dropdown-link :href="route('orders.index')">Bestellingen inzien</x-dropdown-link>

              <div class="border-t border-gray-100 my-1"></div>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                  </svg>
                  Uitloggen
                </button>
              </form>
            </x-slot>
          </x-dropdown>
        @else
          <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-slate-700 hover:text-slate-900 text-sm font-medium transition-colors">Inloggen</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors">
              Registreren
            </a>
          </div>
        @endauth

      </div>
    </div>
  </div>
</div>