<div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
      <a href="{{ route('home') }}" class="inline-flex items-center text-slate-600 hover:text-slate-900 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Terug naar winkel
      </a>
    </div>

    <h1 class="text-4xl font-bold text-slate-900 mb-8">Winkelwagen</h1>

    @if(count($cart) > 0)
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Cart Items --}}
        <div class="lg:col-span-2 space-y-4">
          @foreach($cart as $id => $item)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
              <div class="flex gap-6">
                {{-- Product Image --}}
                <div class="flex-shrink-0">
                  @if($item['image'])
                    <img src="{{ asset('storage/' . $item['image']) }}"
                         alt="{{ $item['name'] }}"
                         class="w-24 h-24 object-cover rounded-lg">
                  @else
                    <div class="w-24 h-24 bg-slate-200 rounded-lg flex items-center justify-center">
                      <span class="text-slate-400 text-xs">Geen foto</span>
                    </div>
                  @endif
                </div>

                {{-- Product Info --}}
                <div class="flex-grow">
                  <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $item['name'] }}</h3>
                  <p class="text-xl font-bold text-slate-900 mb-4">€{{ number_format($item['price'], 2, ',', '.') }}</p>

                  {{-- Quantity Controls --}}
                  <div class="flex items-center gap-3">
                    <button
                      wire:click="decreaseQuantity({{ $id }})"
                      class="w-10 h-10 rounded-lg border-2 border-slate-300 flex items-center justify-center hover:bg-slate-100 hover:border-slate-400 transition-colors">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                      </svg>
                    </button>

                    <span class="text-lg font-semibold text-slate-900 min-w-[3rem] text-center">{{ $item['quantity'] }}</span>

                    <button
                      wire:click="increaseQuantity({{ $id }})"
                      class="w-10 h-10 rounded-lg border-2 border-slate-300 flex items-center justify-center hover:bg-slate-100 hover:border-slate-400 transition-colors">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                      </svg>
                    </button>
                  </div>
                </div>

                {{-- Price & Remove --}}
                <div class="flex flex-col items-end justify-between">
                  <div class="text-right">
                    <p class="text-sm text-slate-500 mb-1">Subtotaal</p>
                    <p class="text-2xl font-bold text-slate-900">
                      €{{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                    </p>
                  </div>

                  <button
                    wire:click="removeItem({{ $id }})"
                    wire:confirm="Weet je zeker dat je dit product wilt verwijderen?"
                    class="inline-flex items-center gap-2 px-4 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Verwijderen
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-1">
          <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8 sticky top-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Overzicht</h2>

            <div class="space-y-4 mb-6">
              <div class="flex justify-between text-slate-600">
                <span>Subtotaal</span>
                <span class="font-semibold">€{{ number_format($total, 2, ',', '.') }}</span>
              </div>
              <div class="flex justify-between text-slate-600">
                <span>Verzendkosten</span>
                <span class="font-semibold">Gratis</span>
              </div>
              <div class="border-t border-slate-200 pt-4">
                <div class="flex justify-between items-center">
                  <span class="text-xl font-bold text-slate-900">Totaal</span>
                  <span class="text-3xl font-bold text-slate-900">€{{ number_format($total, 2, ',', '.') }}</span>
                </div>
              </div>
            </div>

            <a href="{{ route('checkout') }}"
               class="block w-full text-center px-6 py-4 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white font-bold text-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              Afrekenen
            </a>

            <p class="text-xs text-slate-500 text-center mt-4">
              Veilig betalen met Stripe
            </p>
          </div>
        </div>
      </div>
    @else
      <div class="text-center py-20 bg-white rounded-2xl shadow-sm border-2 border-dashed border-slate-300">
        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-900 mb-2">Je winkelwagen is leeg</h3>
        <p class="text-slate-600 mb-8">Voeg producten toe om te beginnen met winkelen!</p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-8 py-3 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold hover:from-amber-600 hover:to-amber-700 transition-all shadow-md hover:shadow-lg">
          Naar de winkel
        </a>
      </div>
    @endif
  </div>
</div>