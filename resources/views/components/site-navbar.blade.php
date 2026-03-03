<nav class="bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
    <a href="{{ route('home') }}" class="text-slate-800 font-semibold text-lg hover:text-slate-900">
      🛍️ MijnShop
    </a>

    <div class="flex items-center gap-6">
      @auth
        <livewire:cart-counter />
        <a href="{{ route('dashboard') }}" class="text-slate-700 hover:text-slate-900 font-medium">Dashboard</a>

        @if (auth()->user()->is_admin)
          <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-slate-700 hover:text-slate-900 font-medium">Admin</a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-slate-800 transition-colors">
            Uitloggen
          </button>
          </form>
      @endauth

      @guest
        <a href="{{ route('login') }}" class="text-slate-700 hover:text-slate-900 font-medium">Inloggen</a>
        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-slate-800 transition-colors">
          Registreren
        </a>
      @endguest
    </div>
  </div>
</nav>