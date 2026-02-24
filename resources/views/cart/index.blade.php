<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouw Winkelmandje - Pokémon GO Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-blue-600 p-4 text-white shadow-lg mb-10">
        <div class="container mx-auto flex justify-between items-center font-bold">
            <a href="/" class="uppercase tracking-widest text-xl">← Terug naar Store</a>
            <span>Winkelmandje</span>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-black text-gray-800 mb-8">Jouw Bestelling</h1>

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $id => $details)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center">
                            <img src="{{ asset('storage/' . $details['image']) }}" class="w-20 h-20 object-contain mr-6">
                            <div class="flex-grow">
                                <h3 class="font-bold text-lg text-gray-900">{{ $details['name'] }}</h3>
                                <p class="text-blue-600 font-bold">€{{ number_format($details['price'], 2) }}</p>
                                <p class="text-gray-500 text-sm">Aantal: {{ $details['quantity'] }}</p>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold uppercase">❌ Verwijderen</button>
                                </form>
                            </div>
                            <div class="text-right font-black text-gray-900 mr-6">
                                €{{ number_format($details['price'] * $details['quantity'], 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 h-fit sticky top-10">
                    <h2 class="text-xl font-bold mb-4">Totaaloverzicht</h2>
                    <div class="flex justify-between mb-8">
                        <span class="text-lg font-bold">Totaal</span>
                        <span class="text-2xl font-black text-blue-600">€{{ number_format($total, 2) }}</span>
                    </div>
                    
                    {{-- DE AFREKENKNOP --}}
                    <a href="{{ route('cart.checkout') }}" class="block text-center w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:scale-105">
                        Naar Betalen
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-dashed border-gray-300">
                <p class="text-gray-500 text-xl mb-6">Je mandje is nog leeg...</p>
                <a href="/" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold">Ga shoppen!</a>
            </div>
        @endif
    </div>
</body>
</html>