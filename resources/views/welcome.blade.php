<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MijnShop - Welkom</title>

  <!-- DNS prefetch for external resources -->
  <link rel="dns-prefetch" href="https://fonts.bunny.net">
  <link rel="dns-prefetch" href="https://www.youtube-nocookie.com">
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>

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
    .reveal { opacity: 0; transform: translateY(40px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-delay-1 { transition-delay: .05s; }
    .reveal-delay-2 { transition-delay: .15s; }
    .reveal-delay-3 { transition-delay: .25s; }
    .reveal-delay-4 { transition-delay: .35s; }
    .reveal:not(.visible) { transition-delay: 0s !important; }

    .hero-video-wrapper { position: absolute; inset: 0; overflow: hidden; z-index: 0; }
    .hero-video-wrapper iframe {
      position: absolute; top: 50%; left: 50%;
      width: 177.78vh; height: 56.25vw; min-width: 100%; min-height: 100%;
      transform: translate(-50%, -50%); pointer-events: none; border: 0;
    }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: translateY(0);} }
    .hero-title { animation: fadeInUp .9s ease forwards; }
    .hero-subtitle { opacity: 0; animation: fadeInUp .9s ease .3s forwards; }
    .hero-buttons { opacity: 0; animation: fadeInUp .9s ease .6s forwards; }

    @keyframes pulseBadge { 0%,100%{ transform: scale(1);} 50%{ transform: scale(1.06);} }
    .sale-badge { animation: pulseBadge 2s ease-in-out infinite; }

    .feature-card { transition: transform .3s ease, box-shadow .3s ease; }
    .feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(0,0,0,.35); }

    #scroll-top-btn {
      position: fixed; bottom: 2rem; left: 2rem; z-index: 40;
      opacity: 0; transform: translateY(12px);
      transition: opacity .3s ease, transform .3s ease; pointer-events: none;
    }
    #scroll-top-btn.visible { opacity: 1; transform: translateY(0); pointer-events: auto; }

    .filter-pill { transition: background-color .2s, color .2s, border-color .2s, box-shadow .2s; }
  </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
  @include('components.site-navbar')

  <!-- Hero -->
  <section class="relative overflow-hidden flex items-center" style="min-height:85vh;">
    <div id="hero-video-wrapper" class="hero-video-wrapper bg-slate-900"></div>
    <div class="absolute inset-0 bg-black/55 z-10"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/40 via-indigo-900/20 to-purple-900/30 z-10"></div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 w-full text-center">
      <h1 class="hero-title text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight drop-shadow-2xl">
        {{ \App\Models\SiteSetting::get('hero_title', 'Welkom bij de') }}
        <span class="text-indigo-300">{{ \App\Models\SiteSetting::get('hero_title_highlight', 'Pokémon go Webstore') }}</span>
      </h1>
      <p class="hero-subtitle text-xl sm:text-2xl text-white/95 max-w-3xl mx-auto leading-relaxed mb-10 drop-shadow-lg">
        {{ \App\Models\SiteSetting::get('hero_subtitle', 'Jouw bestemming voor kwaliteitsproducten. Shop nu en profiteer van gratis verzending vanaf €50!') }}
      </p>
      <div class="hero-buttons flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#producten" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-slate-800 font-bold text-lg rounded-lg shadow-lg hover:shadow-xl hover:bg-slate-50 hover:scale-105 transition-all duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          Shop Nu
        </a>
        <a href="#aanbiedingen" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold text-lg rounded-lg border border-white/30 hover:bg-white/20 hover:scale-105 transition-all duration-300">
          🔥 Bekijk Deals
        </a>
      </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
      <a href="#producten" aria-label="Scroll naar producten">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
      </a>
    </div>
  </section>

  <!-- Products -->
  <section id="producten" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($categories->count() > 0)

      <!-- Search + Sort + Filters -->
      <div class="mb-12 reveal">

        <div class="flex flex-col sm:flex-row gap-3 max-w-3xl mx-auto mb-6">
          <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input id="product-search" type="text" placeholder="Zoek producten..." autocomplete="off"
                   class="w-full pl-12 pr-12 py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-800 dark:focus:ring-slate-400 focus:border-transparent text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 transition-all duration-200">
            <button id="search-clear" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors hidden" aria-label="Zoekopdracht wissen">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <div class="relative">
            <select id="product-sort"
                    class="appearance-none w-full sm:w-52 pl-4 pr-10 py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-800 dark:focus:ring-slate-400 focus:border-transparent text-slate-700 dark:text-slate-300 transition-all duration-200 cursor-pointer">
              <option value="">Sorteren op...</option>
              <option value="price-asc">Prijs: laag → hoog</option>
              <option value="price-desc">Prijs: hoog → laag</option>
              <option value="name-asc">Naam: A → Z</option>
              <option value="name-desc">Naam: Z → A</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
          </div>
        </div>

        <!-- Category pills -->
        <div class="flex flex-wrap justify-center gap-2 mb-3">
          <button class="filter-pill category-pill active px-5 py-2 rounded-full text-sm font-medium border bg-slate-800 text-white border-slate-800" data-filter="all" onclick="filterByCategory(this, 'all')">
            Alle categorieën
          </button>
          @foreach($categories as $cat)
            @if($cat->products->count() > 0)
              <button class="filter-pill category-pill px-5 py-2 rounded-full text-sm font-medium border bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-slate-400 dark:hover:border-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700"
                      data-filter="{{ $cat->slug }}" onclick="filterByCategory(this, '{{ $cat->slug }}')">
                {{ $cat->name }}
              </button>
            @endif
          @endforeach
        </div>

        <!-- Special filter toggle pills -->
        <div class="flex flex-wrap justify-center gap-2">
          <button class="filter-pill special-pill px-5 py-2 rounded-full text-sm font-medium border bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-rose-400 hover:text-rose-600 dark:hover:border-rose-500 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-700 transition-all"
                  data-special="sale" onclick="toggleSpecialFilter(this, 'sale')">
            🔥 Sale
          </button>
          <button class="filter-pill special-pill px-5 py-2 rounded-full text-sm font-medium border bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-amber-400 hover:text-amber-600 dark:hover:border-amber-500 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-slate-700 transition-all"
                  data-special="featured" onclick="toggleSpecialFilter(this, 'featured')">
            ⭐ Uitgelicht
          </button>
        </div>
      </div>

      <div id="no-results" class="hidden text-center py-24">
        <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-slate-700 dark:text-slate-200 mb-2">Geen producten gevonden</h3>
        <p class="text-slate-500 dark:text-slate-400">Probeer een andere zoekterm of categorie.</p>
      </div>

      @foreach($categories as $category)
        @if($category->products->count() > 0)
          <div class="category-section mb-20" data-category="{{ $category->slug }}">
            <div class="flex items-center mb-10 reveal">
              <div class="flex-grow h-0.5 bg-gradient-to-r from-transparent via-slate-300 dark:via-slate-700 to-transparent"></div>
              <h2 class="text-4xl font-bold text-slate-900 dark:text-white mx-8 relative">
                {{ $category->name }}
                <span class="absolute -bottom-2 left-0 right-0 h-1 bg-slate-800 dark:bg-slate-400 rounded-full"></span>
              </h2>
              <div class="flex-grow h-0.5 bg-gradient-to-r from-transparent via-slate-300 dark:via-slate-700 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
              @foreach($category->products as $product)
                <div class="product-card reveal reveal-delay-{{ ($loop->index % 4) + 1 }} group relative bg-white dark:bg-slate-800 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 transform hover:-translate-y-2"
                     data-product-name="{{ strtolower($product->name) }}"
                     data-product-description="{{ strtolower($product->description ?? '') }}"
                     data-product-category="{{ $category->slug }}"
                     data-on-sale="{{ $product->bonus_percentage ? 'true' : 'false' }}"
                     data-is-featured="{{ $product->is_featured ? 'true' : 'false' }}"
                     data-price="{{ $product->price }}">

                  @if($product->bonus_percentage)
                    <div class="absolute top-4 right-4 z-10">
                      <div class="sale-badge bg-rose-600 text-white text-sm font-bold px-3 py-1.5 rounded-lg shadow-lg">
                        -{{ $product->bonus_percentage }}% SALE
                      </div>
                    </div>
                  @endif

                  @if($product->image)
                    <div class="relative aspect-square bg-slate-50 dark:bg-slate-700 overflow-hidden">
                      <img src="{{ asset('storage/' . $product->image) }}"
                           alt="{{ $product->name }}"
                           loading="lazy"
                           width="400" height="400"
                           class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                      <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                  @else
                    <div class="aspect-square bg-slate-50 dark:bg-slate-700 flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                  @endif

                  <div class="p-6">
                    <h3 class="font-semibold text-slate-900 dark:text-white text-lg mb-3 line-clamp-2 min-h-[3.5rem] group-hover:text-slate-700 dark:group-hover:text-slate-200 transition-colors">
                      {{ $product->name }}
                    </h3>

                    @if($product->description)
                      <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2 leading-relaxed min-h-[2.5rem]">
                        {{ $product->description }}
                      </p>
                    @endif

                    <div class="mb-5">
                      <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white">€{{ number_format($product->price, 2, ',', '.') }}</span>
                        <span class="text-slate-500 dark:text-slate-400 text-sm">incl. BTW</span>
                      </div>
                    </div>

                    <!-- Add-to-cart -->
                    <div x-data="{ busy: false, done: false }">
                      @auth
                        <!-- Logged-in: AJAX add-to-cart; show verify modal on 403 -->
                        <button
                          type="button"
                          x-on:click.prevent="
                            if (busy) return;
                            busy = true;

                            fetch('{{ route('cart.store') }}', {
                              method: 'POST',
                              headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                                'X-Requested-With': 'XMLHttpRequest'
                              },
                              body: JSON.stringify({ product_id: {{ $product->id }} })
                            })
                            .then(function (r) {
                              if (r.status === 403) {
                                busy = false;
                                window.dispatchEvent(new CustomEvent('show-verify-modal'));
                                return null;
                              }
                              return r.json().catch(function () { return null; });
                            })
                            .then(function (d) {
                              busy = false;
                              if (!d || !d.ok) return;

                              done = true;
                              setTimeout(function () { done = false; }, 2500);
                              window.dispatchEvent(new CustomEvent('product-added-to-cart', { detail: { name: d.product_name } }));
                              if (typeof Livewire !== 'undefined') Livewire.dispatch('cart-updated');
                            })
                            .catch(function () { busy = false; });
                          "
                          :disabled="busy"
                          class="w-full bg-slate-900 hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600 disabled:bg-gray-400 text-white font-bold py-3 rounded-xl transition flex justify-center items-center shadow-md hover:shadow-lg"
                        >
                          <template x-if="!busy && !done">
                            <span>Toevoegen aan winkelwagen</span>
                          </template>
                          <template x-if="busy">
                            <span class="flex items-center">
                              <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                              </svg>
                              Bezig...
                            </span>
                          </template>
                          <template x-if="done">
                            <span class="flex items-center gap-2">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                              Toegevoegd!
                            </span>
                          </template>
                        </button>
                      @else
                        <!-- Guests: show auth-required modal -->
                        <button
                          type="button"
                          x-on:click.prevent="window.dispatchEvent(new CustomEvent('show-auth-modal'))"
                          class="w-full bg-slate-900 hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold py-3 rounded-xl transition flex justify-center items-center shadow-md hover:shadow-lg"
                        >
                          Toevoegen aan winkelwagen
                        </button>
                      @endauth
                    </div>
                    <!-- End add-to-cart -->

                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endforeach

    @else
      <div class="text-center py-32 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-dashed border-slate-300 dark:border-slate-700">
        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-8 rounded-full bg-slate-200 dark:bg-slate-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        </div>
        <h3 class="text-2xl font-semibold text-slate-900 dark:text-white mb-3">Geen producten beschikbaar</h3>
        <p class="text-slate-600 dark:text-slate-400">Kom binnenkort terug voor geweldige nieuwe producten!</p>
      </div>
    @endif
  </section>

  <!-- Features -->
  <section class="bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-950 dark:to-slate-900 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="feature-card reveal text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
        <div class="w-16 h-16 bg-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-white mb-2">
          {{ \App\Models\SiteSetting::get('feature_1_title', 'Gratis Verzending') }}
        </h3>
        <p class="text-slate-300">
          {{ \App\Models\SiteSetting::get('feature_1_text', 'Vanaf €50 bezorgen we gratis bij je thuis') }}
        </p>
      </div>

      <div class="feature-card reveal reveal-delay-2 text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
        <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-white mb-2">
          {{ \App\Models\SiteSetting::get('feature_2_title', 'Veilig Betalen') }}
        </h3>
        <p class="text-slate-300">
          {{ \App\Models\SiteSetting::get('feature_2_text', 'Beveiligd met Stripe & SSL encryptie') }}
        </p>
      </div>

      <div class="feature-card reveal reveal-delay-3 text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
        <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-white mb-2">
          {{ \App\Models\SiteSetting::get('feature_3_title', '24/7 Support') }}
        </h3>
        <p class="text-slate-300">
          {{ \App\Models\SiteSetting::get('feature_3_text', 'Wij staan altijd voor je klaar') }}
        </p>
      </div>
    </div>
  </section>

  <!-- Toast -->
  <div x-data="{ show: false, message: '' }"
       x-on:product-added-to-cart.window="show = true; message = $event.detail.name + ' toegevoegd!'; setTimeout(() => show = false, 3000)"
       x-show="show"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 translate-y-8"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed bottom-8 right-8 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-xl z-50 max-w-md"
       style="display:none;">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      </div>
      <div>
        <p class="font-semibold" x-text="message"></p>
        <p class="text-white/90 text-sm">Bekijk je <a href="{{ route('cart') }}" class="underline">winkelwagen</a></p>
      </div>
    </div>
  </div>

  <!-- Verify-email modal (logged-in but unverified) -->
  <div x-data="{ open: false }"
       x-on:show-verify-modal.window="open = true"
       x-init="$watch('open', v => document.body.classList.toggle('overflow-hidden', v))"
       x-show="open"
       x-on:keydown.escape.window="open = false"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-[9999] flex items-center justify-center px-4 sm:px-6"
       style="display:none;">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-lg" x-on:click="open = false"></div>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative z-[10000] bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
         role="dialog" aria-modal="true">
      <div class="h-1.5 w-full bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500"></div>
      <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
          </div>
          <h3 class="text-base font-bold text-slate-900 dark:text-white">E-mailadres niet geverifieerd</h3>
        </div>
        <button type="button" x-on:click="open = false"
                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <div class="px-6 py-5 space-y-4">
        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
          Je e‑mailadres is nog niet geverifieerd. Verifieer je adres om artikelen toe te voegen aan je winkelwagen.
        </p>
        <ul class="space-y-2">
          <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/>
            </svg>
            Controleer je inbox voor de verificatie‑e‑mail.
          </li>
          <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/>
            </svg>
            Stuur de e‑mail opnieuw als je hem niet hebt ontvangen.
          </li>
          <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/>
            </svg>
            Na verificatie kun je direct artikelen toevoegen.
          </li>
        </ul>
      </div>
      <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-700">
        <button type="button" x-on:click="open = false"
                class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-xl transition-colors shadow-sm">
          Sluiten
        </button>
        <form method="POST" action="{{ route('verification.send') }}">
          @csrf
          <button type="submit"
                  class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 rounded-xl transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Verificatie-e-mail versturen
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Auth-required modal (guests) -->
  <div x-data="{ open: false }"
       x-on:show-auth-modal.window="open = true"
       x-init="$watch('open', v => document.body.classList.toggle('overflow-hidden', v))"
       x-show="open"
       x-on:keydown.escape.window="open = false"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-[9999] flex items-center justify-center px-4 sm:px-6"
       style="display:none;">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-lg" x-on:click="open = false"></div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative z-[10000] bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
         role="dialog" aria-modal="true">
      <div class="h-1.5 w-full bg-gradient-to-r from-indigo-400 via-blue-400 to-indigo-500"></div>

      <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </div>
          <h3 class="text-base font-bold text-slate-900 dark:text-white">Inloggen en e‑mail verifiëren vereist</h3>
        </div>
        <button type="button" x-on:click="open = false"
                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="px-6 py-5 space-y-4">
        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
          Je bent niet ingelogd. Log in (of maak een account aan) en verifieer je e‑mailadres om artikelen aan je winkelwagen toe te voegen.
        </p>
        <ul class="space-y-2">
          <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/></svg>
            Na inloggen sturen we (indien nodig) een verificatie‑e‑mail.
          </li>
          <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/></svg>
            Zodra je e‑mail is geverifieerd kun je direct producten toevoegen.
          </li>
        </ul>
      </div>

      <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-700">
        <button type="button" x-on:click="open = false"
                class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-xl transition-colors shadow-sm">
          Sluiten
        </button>
        <a href="{{ route('register') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 dark:text-white dark:bg-indigo-700 dark:hover:bg-indigo-600 rounded-xl transition-all shadow-sm">
          Registreren
        </a>
        <a href="{{ route('login') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 rounded-xl transition-all shadow-sm">
          Inloggen
        </a>
      </div>
    </div>
  </div>

  <!-- Scroll-to-top -->
  <button id="scroll-top-btn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
          class="w-12 h-12 bg-slate-800 dark:bg-slate-700 hover:bg-slate-700 dark:hover:bg-slate-600 text-white rounded-full shadow-lg flex items-center justify-center transition-colors duration-200"
          aria-label="Scroll naar boven">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
  </button>

  <!-- JS -->
  <script>
    // Inject YouTube hero video AFTER page has loaded (keeps initial render fast)
    window.addEventListener('load', function () {
      var wrapper = document.getElementById('hero-video-wrapper');
      if (wrapper) {
        var videoId = '{{ \App\Models\SiteSetting::get('hero_video_id', 'gsuG1HiS-gA') }}';
        var iframe = document.createElement('iframe');
        iframe.src = 'https://www.youtube-nocookie.com/embed/' + videoId + '?autoplay=1&mute=1&loop=1&playlist=' + videoId + '&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1';
        iframe.title = 'Hero background video';
        iframe.allow = 'autoplay; encrypted-media';
        iframe.allowFullscreen = true;
        wrapper.appendChild(iframe);
      }
    });

    // Reveal that replays on re-enter
    (function () {
      var els = document.querySelectorAll('.reveal');
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) entry.target.classList.add('visible');
          else entry.target.classList.remove('visible');
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
      els.forEach(function (el) { observer.observe(el); });
    })();

    // Scroll-top toggle
    (function () {
      var btn = document.getElementById('scroll-top-btn');
      window.addEventListener('scroll', function () {
        btn.classList.toggle('visible', window.scrollY > 350);
      }, { passive: true });
    })();

    // Filters + sort
    var activeCategory = 'all';
    var activeSpecials = new Set();
    var activeSort     = '';

    function runFilter() {
      var query    = document.getElementById('product-search').value.toLowerCase().trim();
      var cards    = Array.from(document.querySelectorAll('.product-card'));
      var sections = document.querySelectorAll('.category-section');
      var totalVisible = 0;

      cards.forEach(function (card) {
        var name     = card.dataset.productName        || '';
        var desc     = card.dataset.productDescription || '';
        var cat      = card.dataset.productCategory    || '';
        var onSale   = card.dataset.onSale             === 'true';
        var featured = card.dataset.isFeatured         === 'true';

        var matchSearch   = !query || name.includes(query) || desc.includes(query);
        var matchCategory = activeCategory === 'all' || cat === activeCategory;
        var matchSale     = !activeSpecials.has('sale')     || onSale;
        var matchFeatured = !activeSpecials.has('featured') || featured;

        if (matchSearch && matchCategory && matchSale && matchFeatured) {
          card.style.display = '';
          totalVisible++;
        } else {
          card.style.display = 'none';
        }
      });

      sections.forEach(function (section) {
        var grid = section.querySelector('.grid');
        if (!grid || !activeSort) return;
        var visibleCards = Array.from(grid.querySelectorAll('.product-card')).filter(function (c) {
          return c.style.display !== 'none';
        });
        visibleCards.sort(function (a, b) {
          if (activeSort === 'price-asc')  return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
          if (activeSort === 'price-desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
          if (activeSort === 'name-asc')   return (a.dataset.productName || '').localeCompare(b.dataset.productName || '');
          if (activeSort === 'name-desc')  return (b.dataset.productName || '').localeCompare(a.dataset.productName || '');
          return 0;
        });
        visibleCards.forEach(function (card) { grid.appendChild(card); });
      });

      sections.forEach(function (section) {
        var anyVisible = Array.from(section.querySelectorAll('.product-card'))
          .some(function (c) { return c.style.display !== 'none'; });
        section.style.display = anyVisible ? '' : 'none';
      });

      document.getElementById('no-results').classList.toggle('hidden', totalVisible > 0);
      document.getElementById('search-clear').classList.toggle('hidden', !query);
    }

    function filterByCategory(btn, slug) {
      activeCategory = slug;
      document.querySelectorAll('.category-pill').forEach(function (b) {
        b.classList.remove('bg-slate-800', 'text-white', 'border-slate-800', 'active');
        b.classList.add('bg-white', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300', 'border-slate-200', 'dark:border-slate-700');
      });
      btn.classList.add('bg-slate-800', 'text-white', 'border-slate-800', 'active');
      btn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300', 'border-slate-200', 'dark:border-slate-700');
      runFilter();
    }

    function toggleSpecialFilter(btn, tag) {
      if (activeSpecials.has(tag)) {
        activeSpecials.delete(tag);
        btn.classList.remove('ring-2');
        if (tag === 'sale') {
          btn.classList.remove('bg-rose-50', 'dark:bg-rose-900/20', 'border-rose-500', 'text-rose-600', 'dark:text-rose-400');
          btn.classList.add('bg-white', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300', 'border-slate-200', 'dark:border-slate-700');
        } else {
          btn.classList.remove('bg-amber-50', 'dark:bg-amber-900/20', 'border-amber-500', 'text-amber-600', 'dark:text-amber-400');
          btn.classList.add('bg-white', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300', 'border-slate-200', 'dark:border-slate-700');
        }
      } else {
        activeSpecials.add(tag);
        btn.classList.add('ring-2');
        if (tag === 'sale') {
          btn.classList.add('bg-rose-50', 'dark:bg-rose-900/20', 'border-rose-500', 'text-rose-600', 'dark:text-rose-400');
          btn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300', 'border-slate-200', 'dark:border-slate-700');
        } else {
          btn.classList.add('bg-amber-50', 'dark:bg-amber-900/20', 'border-amber-500', 'text-amber-600', 'dark:text-amber-400');
          btn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300', 'border-slate-200', 'dark:border-slate-700');
        }
      }
      runFilter();
    }

    // Show scroll-to-top on scroll
    document.addEventListener('DOMContentLoaded', function () {
      var searchInput = document.getElementById('product-search');
      var clearBtn    = document.getElementById('search-clear');
      var sortSelect  = document.getElementById('product-sort');

      searchInput.addEventListener('input', runFilter);
      clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        runFilter();
        searchInput.focus();
      });
      sortSelect.addEventListener('change', function () {
        activeSort = this.value;
        runFilter();
      });
    });
  </script>

  @livewireScripts
</body>
</html>