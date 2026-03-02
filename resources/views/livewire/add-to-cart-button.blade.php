<div class="inline-block">
  <button
    type="button"
    wire:click="addToCart"
    class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-amber-600 text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
  >
    In winkelwagen
  </button>

  `@if`($showLoginModal)
    <div class="fixed inset-0 z-50">
      <div class="absolute inset-0 bg-black/50" aria-hidden="true"></div>
      <div class="relative mx-auto mt-24 w-full max-w-md rounded-lg bg-white shadow-xl">
        <div class="p-6">
          <h2 class="text-lg font-semibold text-slate-900 mb-2">Inloggen vereist</h2>
          <p class="text-slate-600 mb-6">
            Log in of registreer om producten aan je winkelwagen toe te voegen.
          </p>
          <div class="flex items-center justify-end gap-3">
            <a href="{{ route('register') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50">
              Registreren
            </a>
            <a href="{{ route('login') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md bg-slate-900 text-white hover:bg-slate-800">
              Inloggen
            </a>
            <button
              type="button"
              wire:click="$set('showLoginModal', false)"
              class="inline-flex items-center px-3 py-1.5 rounded-md text-slate-600 hover:text-slate-800"
            >
              Sluiten
            </button>
          </div>
        </div>
      </div>
    </div>
  `@endif`
</div>