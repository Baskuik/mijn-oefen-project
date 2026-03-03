<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MijnShop - Jouw Online Webwinkel</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="antialiased bg-gradient-to-br from-slate-50 to-slate-100 text-slate-800">
  @include('components.site-navbar')

  {{-- Hero Section --}}
  <section class="bg-gradient-to-br from-amber-50 via-white to-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center">
        <h1 class="text-5xl sm:text-6xl font-bold text-slate-900 mb-6 leading-tight">
          Welkom bij <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-amber-600">MijnShop</span>
        </h1>
        <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
          Ontdek ons uitgebreide assortiment en shop eenvoudig online. Gratis verzending vanaf €50!
        </p>
      </div>
    </div>
  </section>

  {{-- Products Section --}}
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($categories && $categories->count() > 0)
      @foreach($categories as $category)
        @if($category->products->count() > 0)
          <div class="mb-16">
            <div class="flex items-center mb-8">
              <h2 class="text-3xl font-bold text-slate-900">{{ $category->name }}</h2>
              <div class="flex-grow h-0.5 bg-gradient-to-r from-slate-300 to-transparent ml-6"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
              @foreach($category->products as $product)
                <div
                  class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-slate-200 hover:border-amber-200 transform hover:-translate-y-2">
                  {{-- Product Image --}}
                  @if($product->image)
                    <div class="aspect-square bg-slate-100 overflow-hidden">
                      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                  @else
                    <div class="aspect-square bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-slate-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  @endif

                  <div class="p-6">
                    {{-- Product Title --}}
                    <h3 class="font-bold text-slate-900 text-xl mb-3 line-clamp-2 group-hover:text-amber-600 transition-colors">
                      {{ $product->name }}
                    </h3>

                    {{-- Product Description --}}
                    @if($product->description)
                      <p class="text-slate-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                        {{ $product->description }}
                      </p>
                    @endif

                    {{-- Price & Discount --}}
                    <div class="flex items-center justify-between mb-5">
                      <div>
                        <span class="text-3xl font-bold text-slate-900">
                          €{{ number_format($product->price, 2, ',', '.') }}
                        </span>
                      </div>

                      @if($product->bonus_percentage)
                        <span
                          class="bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-bold px-3 py-1.5 rounded-full shadow-md">
                          -{{ $product->bonus_percentage }}%
                        </span>
                      @endif
                    </div>

                    {{-- Add to Cart Button --}}
                    <livewire:add-to-cart-button :product-id="$product->id" :key="'cart-' . $product->id" />
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endforeach
    @else
      <div class="text-center py-20 bg-white rounded-2xl shadow-sm border-2 border-dashed border-slate-300">
        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-900 mb-2">Geen producten beschikbaar</h3>
        <p class="text-slate-600">Kom binnenkort terug voor nieuwe producten!</p>
      </div>
    @endif
  </section>

  {{-- Toast Notification --}}
  <div x-data="{ show: false, message: '' }"
    @product-added-to-cart.window="show = true; message = 'Product toegevoegd aan winkelwagen!'; setTimeout(() => show = false, 3000)"
    x-show="show" x-transition
    class="fixed bottom-8 right-8 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl z-50" style="display: none;">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      <span class="font-semibold" x-text="message"></span>
    </div>
  </div>

  @livewireScripts
</body>

</html>