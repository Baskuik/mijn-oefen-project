<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mijn Bestellingen - MijnShop</title>

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
  <style>
    @keyframes fadeInUp { from { opacity:0; transform: translateY(20px);} to { opacity:1; transform: translateY(0);} }
    .order-card { opacity:0; animation: fadeInUp .5s ease forwards; }
  </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 min-h-screen transition-colors duration-300">
  @include('components.site-navbar')

  <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 pt-12 pb-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
          <p class="text-indigo-300 text-sm font-semibold uppercase tracking-widest mb-2">Mijn Account</p>
          <h1 class="text-3xl font-extrabold text-white mb-1">Mijn Bestellingen</h1>
          <p class="text-slate-400 text-sm">Een overzicht van al je eerdere aankopen.</p>
        </div>
        <div class="flex items-center gap-3">
          <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl px-5 py-4 text-center">
            <p class="text-3xl font-extrabold text-white">{{ $orders->count() }}</p>
            <p class="text-xs text-slate-300 font-medium mt-0.5">{{ $orders->count() === 1 ? 'Bestelling' : 'Bestellingen' }}</p>
          </div>
          @if($orders->count() > 0)
            <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl px-5 py-4 text-center">
              <p class="text-3xl font-extrabold text-white">€{{ number_format($orders->sum('total_price'), 2, ',', '.') }}</p>
              <p class="text-xs text-slate-300 font-medium mt-0.5">Totaal besteed</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-14 pb-16">
    @if($orders->isEmpty())
      <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700 text-center py-20 px-6">
        <div class="w-24 h-24 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-700 dark:text-slate-200 mb-2">Nog geen bestellingen</h3>
        <p class="text-slate-400 dark:text-slate-500 text-sm mb-8">Je hebt hier nog niets besteld. Begin met shoppen!</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 dark:bg-slate-600 text-white font-semibold rounded-xl hover:bg-slate-700 dark:hover:bg-slate-500 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          Naar de shop
        </a>
      </div>
    @else
      <div class="space-y-4">
        @foreach($orders as $index => $order)
          @php
            $statusColor = match($order->status) {
              'paid' => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-400 dark:border-emerald-700',
              'pending' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-900/40 dark:text-amber-400 dark:border-amber-700',
              'cancelled' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-400 dark:border-red-700',
              default => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:border-slate-600',
            };
            $statusLabel = match($order->status) {
              'paid' => 'Betaald',
              'pending' => 'In behandeling',
              'cancelled' => 'Geannuleerd',
              default => ucfirst($order->status),
            };
            $statusIcon = match($order->status) {
              'paid' => 'M5 13l4 4L19 7',
              'pending' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
              'cancelled' => 'M6 18L18 6M6 6l12 12',
              default => 'M13 16h-1v-4h-1m1-4h.01',
            };
          @endphp

          <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }"
               class="order-card bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700 overflow-hidden"
               style="animation-delay: {{ $index * 0.07 }}s;">

            <button @click="open = !open" class="w-full text-left flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-5 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors focus:outline-none">
              <div class="flex items-center gap-5">
                <div class="w-11 h-11 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                  </svg>
                </div>
                <div>
                  <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">Bestelling</p>
                  <p class="font-bold text-slate-900 dark:text-white text-base">#{{ $order->id }}</p>
                </div>
                <div class="hidden sm:block w-px h-8 bg-slate-200 dark:bg-slate-600"></div>
                <div class="hidden sm:block">
                  <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">Datum</p>
                  <p class="font-semibold text-slate-700 dark:text-slate-300 text-sm">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div class="hidden sm:block w-px h-8 bg-slate-200 dark:bg-slate-600"></div>
                <div class="hidden sm:block">
                  <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">Artikelen</p>
                  <p class="font-semibold text-slate-700 dark:text-slate-300 text-sm">{{ $order->items->count() }} {{ $order->items->count() === 1 ? 'artikel' : 'artikelen' }}</p>
                </div>
              </div>

              <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full border {{ $statusColor }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $statusIcon }}" />
                  </svg>
                  {{ $statusLabel }}
                </span>
                <div class="text-right">
                  <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">Totaal</p>
                  <p class="font-extrabold text-slate-900 dark:text-white text-lg">€{{ number_format($order->total_price, 2, ',', '.') }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 dark:text-slate-500 transition-transform duration-300 flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </div>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="border-t border-slate-100 dark:border-slate-700">

              <div class="divide-y divide-slate-50 dark:divide-slate-700">
                @foreach($order->items as $item)
                  <div class="flex items-center justify-between px-6 py-4 gap-4 hover:bg-slate-50/60 dark:hover:bg-slate-700/30 transition-colors">
                    <div class="flex items-center gap-4 min-w-0">
                      @if($item->product?->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-14 h-14 rounded-xl object-cover flex-shrink-0 border border-slate-100 dark:border-slate-600 shadow-sm">
                      @else
                        <div class="w-14 h-14 flex-shrink-0"></div>
                      @endif
                      <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate">
                          {{ $item->product?->name ?? 'Product #' . $item->product_id }}
                        </p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                          Aantal: <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $item->quantity }}</span>
                          · €{{ number_format($item->price, 2, ',', '.') }} per stuk
                        </p>
                      </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                      <p class="text-base font-bold text-slate-900 dark:text-white">€{{ number_format($item->price * $item->quantity, 2, ',', '.') }}</p>
                    </div>
                  </div>
                @endforeach
              </div>

              <div class="flex items-center justify-between px-6 py-4 bg-slate-50 dark:bg-slate-700/40 border-t border-slate-100 dark:border-slate-700">
                <p class="text-xs text-slate-400 dark:text-slate-500">Besteld op {{ $order->created_at->format('d F Y \o\m H:i') }}</p>
                <div class="flex items-center gap-2">
                  <span class="text-sm text-slate-500 dark:text-slate-400 font-medium">Totaal:</span>
                  <span class="text-base font-extrabold text-slate-900 dark:text-white">€{{ number_format($order->total_price, 2, ',', '.') }}</span>
                </div>
              </div>
            </div>

          </div>
        @endforeach
      </div>

      <div class="mt-8 text-center">
        <a href="{{ route('home') }}" class="text-sm text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">← Terug naar de shop</a>
      </div>
    @endif
  </div>

  @livewireScripts
</body>
</html> 