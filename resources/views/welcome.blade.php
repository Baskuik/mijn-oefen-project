<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MijnShop - Premium Online Winkel</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="antialiased bg-slate-50 text-slate-900">
  @include('components.site-navbar')

  {{-- Hero Section --}}
  <section class="relative bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNnoiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLW9wYWNpdHk9Ii4xIi8+PC9nPjwvc3ZnPg==')] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
      <div class="text-center">
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight drop-shadow-2xl">
          Welkom bij <span class="inline-block transform hover:scale-105 transition-transform">MijnShop</span>
        </h1>
        <p class="text-xl sm:text-2xl text-white/95 max-w-3xl mx-auto leading-relaxed mb-10 drop-shadow-lg">
          Jouw bestemming voor kwaliteitsproducten. Shop nu en profiteer van gratis verzending vanaf €50!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="#producten" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-orange-600 font-bold text-lg rounded-full shadow-2xl hover:shadow-orange-500/50 hover:scale-105 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            Shop Nu
          </a>
          <a href="#aanbiedingen" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/20 backdrop-blur-sm text-white font-bold text-lg rounded-full border-2 border-white/50 hover:bg-white/30 hover:scale-105 transition-all duration-300">
            🔥 Bekijk Deals
          </a>
        </div>
      </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
      <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f8fafc"/>
      </svg>
    </div>
  </section>

  {{-- Products Section --}}
  <section id="producten" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    @if($categories && $categories->count() > 0)
      @foreach($categories as $category)
        @if($category->products->count() > 0)
          <div class="mb-20">
            <div class="flex items-center mb-10">
              <div class="flex-grow h-1 bg-gradient-to-r from-transparent via-orange-300 to-transparent"></div>
              <h2 class="text-4xl font-bold text-slate-900 mx-8 relative">
                {{ $category->name }}
                <span class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full"></span>
              </h2>
              <div class="flex-grow h-1 bg-gradient-to-r from-transparent via-orange-300 to-transparent"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
              @foreach($category->products as $product)
                <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border-2 border-transparent hover:border-orange-200 transform hover:-translate-y-3">
                  {{-- Sale Badge --}}
                  @if($product->bonus_percentage)
                    <div class="absolute top-4 right-4 z-10">
                      <div class="bg-gradient-to-br from-red-500 to-pink-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-xl transform rotate-12 animate-pulse">
                        -{{ $product->bonus_percentage }}% SALE
                      </div>
                    </div>
                    @endif

                  {{-- Product Image --}}
                  @if($product->image)
                    <div class="relative aspect-square bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
                      <img src="{{ asset('storage/' . $product->image) }}" 
                           alt="{{ $product->name }}"
                           class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                      <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                  @else
                    <div class="aspect-square bg-gradient-to-br from-slate-200 via-slate-100 to-slate-200 flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  @endif
                  
                  <div class="p-6">
                    {{-- Product Title --}}
                    <h3 class="font-bold text-slate-900 text-xl mb-3 line-clamp-2 min-h-[3.5rem] group-hover:text-orange-600 transition-colors">
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
                        <span class="text-4xl font-extrabold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent">
                          €{{ number_format($product->price, 2, ',', '.') }}
                        </span>
                        <span class="text-slate-500 text-sm">incl. BTW</span>
                      </div>
                    </div>
                    
                    {{-- Add to Cart Button --}}
                    <livewire:add-to-cart-button :product-id="$product->id" :key="'cart-' . $product->id" />
                  </div>

                  {{-- Hover Glow Effect --}}
                  <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-amber-400/0 via-orange-400/0 to-red-400/0 group-hover:from-amber-400/10 group-hover:via-orange-400/10 group-hover:to-red-400/10 transition-all duration-500 pointer-events-none"></div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endforeach
    @else
      <div class="text-center py-32 bg-gradient-to-br from-slate-50 to-slate-100 rounded-3xl shadow-inner border-2 border-dashed border-slate-300">
        <div class="flex items-center justify-center w-32 h-32 mx-auto mb-8 rounded-full bg-gradient-to-br from-slate-200 to-slate-300 shadow-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
        </div>
        <h3 class="text-3xl font-bold text-slate-900 mb-3">Geen producten beschikbaar</h3>
        <p class="text-lg text-slate-600">Kom binnenkort terug voor geweldige nieuwe producten!</p>
      </div>
    @endif
  </section>

  {{-- Features Section --}}
  <section class="bg-gradient-to-br from-slate-900 to-slate-800 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
          <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Gratis Verzending</h3>
          <p class="text-slate-300">Vanaf €50 bezorgen we gratis bij je thuis</p>
        </div>
        <div class="text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
          <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">Veilig Betalen</h3>
          <p class="text-slate-300">Beveiligd met Stripe & SSL encryptie</p>
        </div>
        <div class="text-center p-8 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10">
          <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">24/7 Support</h3>
          <p class="text-slate-300">Wij staan altijd voor je klaar</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Toast Notification --}}
  <div x-data="{ show: false, message: '' }"
    @product-added-to-cart.window="show = true; message = $event.detail.name + ' toegevoegd!'; setTimeout(() => show = false, 3000)"
    x-show="show" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-8"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-8 right-8 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-5 rounded-2xl shadow-2xl z-50 max-w-md"
    style="display: none;">
    <div class="flex items-center gap-4">
      <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <div>
        <p class="font-bold text-lg" x-text="message"></p>
        <p class="text-white/90 text-sm">Bekijk je <a href="{{ route('cart') }}" class="underline font-semibold">winkelwagen</a></p>
      </div>
    </div>
  </div>

  @livewireScripts
</body>

</html>