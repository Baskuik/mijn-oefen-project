<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Bestellingen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->is_admin)
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg text-blue-800">Admin Paneel</h3>
                    <p class="text-sm text-blue-600 mb-4">Beheer de gebruikers van je Pokémon store.</p>
                    
                    <a href="{{ route('admin.users.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        Naar Gebruikersbeheer
                    </a>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Jouw Bestellingen</h3>

                            @if($orders->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-gray-600 text-lg mb-4">Je hebt nog geen bestellingen geplaatst.</p>
                            <a href="{{ route('home') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-6 rounded-lg transition">
                                Start met winkelen
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                    <!-- Order Header -->
                                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                        <div class="flex flex-wrap justify-between items-center gap-4">
                                            <div>
                                                <p class="text-sm text-gray-600">Bestelling geplaatst op</p>
                                                <p class="text-lg font-semibold text-gray-900">
                                                    {{ $order->created_at->format('d-m-Y H:i') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Totaal</p>
                                                <p class="text-lg font-bold text-gray-900">
                                                    €{{ number_format($order->total_price, 2, ',', '.') }}
                                                </p>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                    {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                Bestelnummer: <span class="font-mono">#{{ $order->id }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Items -->
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0">
                                                    <!-- Product Image -->
                                                    <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Product Details -->
                                                    <div class="flex-grow">
                                                        <h4 class="font-semibold text-gray-900">
                                                            {{ $item->product ? $item->product->name : 'Product niet beschikbaar' }}
                                                        </h4>
                                                        <p class="text-sm text-gray-600">
                                                            Aantal: {{ $item->quantity }}
                                                        </p>
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="text-right">
                                                        <p class="font-semibold text-gray-900">
                                                            €{{ number_format($item->price, 2, ',', '.') }}
                                                        </p>
                                                        @if($item->quantity > 1)
                                                            <p class="text-xs text-gray-500">
                                                                Totaal: €{{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>