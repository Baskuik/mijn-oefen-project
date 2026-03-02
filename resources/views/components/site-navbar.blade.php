<nav class="bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
    <a href="{{ route('home') }}" class="text-slate-800 font-semibold text-lg hover:text-slate-900">
      MijnShop
    </a>

    <div class="flex items-center gap-4">
      `@auth`
        <a href="{{ route('dashboard') }}" class="text-slate-700 hover:text-slate-900">Dashboard</a>

        `@if` (auth()->user()->is_admin)
          <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-slate-700 hover:text-slate-900">Admin</a>
        `@endif`

        <form method="POST" action="{{ route('logout') }}">
          `@csrf`
          <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-slate-900 text-white hover:bg-slate-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3"/>
            </svg>
            Uitloggen
          </button>
        </form>
      `@endauth`

      `@guest`
        <a href="{{ route('login') }}" class="text-slate-700 hover:text-slate-900">Inloggen</a>
        <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-slate-900 text-white hover:bg-slate-800">
          Registreren
        </a>
      `@endguest`
    </div>
  </div>
</nav>