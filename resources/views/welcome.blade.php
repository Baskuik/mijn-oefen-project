<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MijnShop - Welkom</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  <style>
    /* ── Scroll-reveal base ── */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .reveal-delay-1 { transition-delay: 0.05s; }
    .reveal-delay-2 { transition-delay: 0.15s; }
    .reveal-delay-3 { transition-delay: 0.25s; }
    .reveal-delay-4 { transition-delay: 0.35s; }

    /* ── YouTube video hero ── */
    .hero-video-wrapper {
      position: absolute;
      inset: 0;
      overflow: hidden;
      z-index: 0;
    }
    .hero-video-wrapper iframe {
      position: absolute;
      top: 50%;
      left: 50%;
      /* Keep 16:9 and always fill the container */
      width: 177.78vh;
      height: 56.25vw;
      min-width: 100%;
      min-height: 100%;
      transform: translate(-50%, -50%);
      pointer-events: none;
      border: 0;
    }

    /* ── Hero text entrance animations ── */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .hero-title {
      animation: fadeInUp 0.9s ease forwards;
    }
    .hero-subtitle {
      opacity: 0;
      animation: fadeInUp 0.9s ease 0.3s forwards;
    }
    .hero-buttons {
      opacity: 0;
      animation: fadeInUp 0.9s ease 0.6s forwards;
    }

    /* ── Sale badge pulse ── */
    @keyframes pulseBadge {
      0%, 100% { transform: scale(1); }
      50%       { transform: scale(1.06); }
    }
    .sale-badge {
      animation: pulseBadge 2s ease-in-out infinite;
    }

    /* ── Feature card hover lift ── */
    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px -12px rgba(0,0,0,0.35);
    }

    /* ── Scroll-to-top button ── */
    #scroll-top-btn {
      position: fixed;
      bottom: 2rem;
      left: 2rem;
      z-index: 40;
      opacity: 0;
      transform: translateY(12px);
      transition: opacity 0.3s ease, transform 0.3s ease;
      pointer-events: none;
    }
    #scroll-top-btn.visible {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }
  </style>
</head>

<body class="bg-slate-50">
  @include('components.site-navbar')

  {{-- ── Hero Section with YouTube Video Background ── --}}
  <section class="relative overflow-hidden flex items-center" style="min-height: 85vh;">

    {{-- YouTube background --}}
    <div class="hero-video-wrapper">
      <iframe
        src="https://www.youtube-nocookie.com/embed/gsuG1HiS-gA?autoplay=1&mute=1&loop=1&playlist=gsuG1HiS-gA&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1"
        title="Hero background video"
        allow="autoplay; encrypted-media"
        allowfullscreen
      ></iframe>
    </div>

    {{-- Dark overlay --}}
    <div class="absolute inset-0 bg-black/55 z-10"></div>
    {{-- Colour tint --}}
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/40 via-indigo-900/20 to-purple-900/30 z-10"></div>

    {{-- Hero content --}}
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 w-full">
      <div class="text-center">
        <h1 class="hero-title text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight drop-shadow-2xl">
          Welkom bij <span class="text-indigo-300">MijnShop</span>
        </h1>
        <p class="hero-subtitle text-xl sm:text-2xl text-white/95 max-w-3xl mx-auto leading-relaxed mb-10 drop-shadow-lg">
          Jouw bestemming voor kwaliteitsproducten. Shop nu en profiteer van gratis verzending vanaf €50!
        </p>
        <div class="hero-buttons flex flex-col sm:flex-row gap-4 justify-center">
          <a href="#producten"
             class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-slate-800 font-bold text-lg rounded-lg shadow-lg hover:shadow-xl hover:bg-slate-50 hover:scale-105 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            Shop Nu
          </a>
          <a href="#aanbiedingen"
             class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold text-lg rounded-lg border border-white/30 hover:bg-white/20 hover:scale-105 transition-all duration-300">
            🔥 Bekijk Deals
          </a>
        </div>
      </div>
    </div>

    {{-- Bounce scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
      <a href="#producten" aria-label="Scroll naar producten">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </a>
    </div>
  </section>

  {{-- ── Products Section ── --}}
  <section id="producten" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($categories->count() > 0)
      @foreach($categories as $category)
        @if($category->products->count() > 0)
          <div class="mb-20">

            {{-- Category header --}}
            <div class="flex items-center mb-10 reveal">
              <div class="flex-grow h-0.5 bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>
              <h2 class="text-4xl font-bold text-slate-900 mx-8 relative">
                {{ $category->name }}
                <span class="absolute -bottom-2 left-0 right-0 h-1 bg-slate-800 rounded-full"></span>
              </h2>
              <div class="flex-grow h-0.5 bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>
            </div>

            {{-- Product grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
              @foreach($category->products as $product)
                <div class="reveal reveal-delay-{{ ($loop->index % 4) + 1 }} group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-200 hover:border-slate-300 transform hover:-translate-y-2">

                  {{-- Sale Badge --}}
                  @if($product->bonus_percentage)
                    <div class="absolute top-4 right-4 z-10">
                      <div class="sale-badge bg-rose-600 text-white text-sm font-bold px-3 py-1.5 rounded-lg shadow-lg">
                        -{{ $product->bonus_percentage }}% SALE
                      </div>
                    </div>
                  @endif

                  {{-- Product Image --}}
                  @if($product->image)
                    <div class="relative aspect-square bg-slate-50 overflow-hidden">
                      <img src="{{ asset('storage/' . $product->image) }}"
                           alt="{{ $product->name }}"
                           class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                      <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                  @else
                    <div class="aspect-square bg-slate-50 flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  @endif

                  <div class="p-6">
                    {{-- Product Title --}}
                    <h3 class="font-semibold text-slate-900 text-lg mb-3 line-clamp-2 min-h-[3.5rem] group-hover:text-slate-700 transition-colors">
                      {{ $product->name }}
                    </h3>

                    {{-- Product Description --}}
                    @if($product->description)
                      <p class="text-slate-600 text-sm mb-4 line-clamp-2 leading-relaxed min-h-[2.5rem]">
                        {{ $product->description }}
                      </p>
                    @endif

                    {{-- Price --}}
                    <div class="mb-5">
                      <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-900">
                          €{{ number_format($product->price, 2, ',', '.') }}
                        </span>
                        <span class="text-slate-500 text-sm">incl. BTW</span>
                      </div>
                    </div>

                    {{-- Add to Cart Button — untouched --}}
                    <livewire:add-to-cart-button :product-id="$product->id" :key="'cart-' . $product->id" />
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endforeach
    @else
      <div class="text-center py-32 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-8 rounded-full bg-slate-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-slate-900 mb-3">Geen producten beschikbaar</h3>
        <p class="text-slate-600">Kom binnenkort terug voor geweldige nieuwe producten!</p>
      </div>
    @endif
  </section>

  {{-- ── Features Section ── --}}
  <section class="bg-gradient-to-br from-slate-900 to-slate-800 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="feature-card reveal text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
          <div class="w-16 h-16 bg-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">Gratis Verzending</h3>
          <p class="text-slate-300">Vanaf €50 bezorgen we gratis bij je thuis</p>
        </div>

        <div class="feature-card reveal reveal-delay-2 text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
          <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">Veilig Betalen</h3>
          <p class="text-slate-300">Beveiligd met Stripe & SSL encryptie</p>
        </div>

        <div class="feature-card reveal reveal-delay-3 text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
          <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">24/7 Support</h3>
          <p class="text-slate-300">Wij staan altijd voor je klaar</p>
        </div>

      </div>
    </div>
  </section>

  {{-- ── Toast Notification (Alpine.js — unchanged) ── --}}
  <div x-data="{ show: false, message: '' }"
    @product-added-to-cart.window="show = true; message = $event.detail.name + ' toegevoegd!'; setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-8"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-8 right-8 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-xl z-50 max-w-md"
    style="display: none;">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <div>
        <p class="font-semibold" x-text="message"></p>
        <p class="text-white/90 text-sm">Bekijk je <a href="{{ route('cart') }}" class="underline">winkelwagen</a></p>
      </div>
    </div>
  </div>

  {{-- ── Scroll-to-top button ── --}}
  <button id="scroll-top-btn"
          onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
          class="w-12 h-12 bg-slate-800 hover:bg-slate-700 text-white rounded-full shadow-lg flex items-center justify-center transition-colors duration-200"
          aria-label="Scroll naar boven">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
  </button>

  {{-- ── Scroll reveal + scroll-to-top JS ── --}}
  <script>
    // Scroll reveal
    (function () {
      var els = document.querySelectorAll('.reveal');
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

      els.forEach(function (el) { observer.observe(el); });
    })();

    // Scroll-to-top button visibility
    (function () {
      var btn = document.getElementById('scroll-top-btn');
      window.addEventListener('scroll', function () {
        btn.classList.toggle('visible', window.scrollY > 350);
      }, { passive: true });
    })();
  </script>

  @livewireScripts
</body>

</html>