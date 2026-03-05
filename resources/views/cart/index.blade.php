<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jouw Winkelmandje - MijnShop</title>

  <!-- Dark mode: apply before CSS renders to prevent flash -->
  <script>
    (function () {
      var t = localStorage.getItem('theme');
      if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body class="bg-gray-100 dark:bg-slate-950 font-sans min-h-screen transition-colors duration-300">

  @include('components.site-navbar')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-black text-gray-800 dark:text-white mb-8">Jouw Bestelling</h1>

    @if(count($cart) > 0)
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
          @foreach($cart as $id => $details)
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 flex items-center gap-6">
              <img src="{{ asset('storage/' . $details['image']) }}" class="w-20 h-20 object-contain rounded-xl flex-shrink-0">
              <div class="flex-grow min-w-0">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $details['name'] }}</h3>
                <p class="text-indigo-600 dark:text-indigo-400 font-bold">€{{ number_format($details['price'], 2) }}</p>
                <p class="text-gray-500 dark:text-slate-400 text-sm">Aantal: {{ $details['quantity'] }}</p>
                <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-2">
                  @csrf
                  <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-bold uppercase transition-colors">❌ Verwijderen</button>
                </form>
              </div>
              <div class="text-right font-black text-gray-900 dark:text-white flex-shrink-0">
                €{{ number_format($details['price'] * $details['quantity'], 2) }}
              </div>
            </div>
          @endforeach
        </div>

        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 h-fit sticky top-10">
          <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Totaaloverzicht</h2>
          <div class="flex justify-between mb-8">
            <span class="text-lg font-bold text-slate-700 dark:text-slate-300">Totaal</span>
            <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">€{{ number_format($total, 2) }}</span>
          </div>
          <a href="{{ route('cart.checkout') }}" class="block text-center w-full bg-emerald-500 hover:bg-emerald-600 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:scale-105">
            Naar Betalen
          </a>
        </div>
      </div>
    @else
      <div class="text-center py-20 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-dashed border-gray-300 dark:border-slate-600">
        <p class="text-gray-500 dark:text-slate-400 text-xl mb-6">Je mandje is nog leeg...</p>
        <a href="{{ route('home') }}" class="bg-slate-800 dark:bg-slate-600 hover:bg-slate-700 dark:hover:bg-slate-500 text-white px-8 py-3 rounded-xl font-bold transition-colors">Ga shoppen!</a>
      </div>
    @endif
  </div>

  @livewireScripts
</body>
</html>