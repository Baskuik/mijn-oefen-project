<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon GO Web Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">

    {{-- Hoofd Navigatiebalk --}}
    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center font-bold text-xl uppercase tracking-widest">
            <a href="/">Pokémon GO Web Store</a>
            
            <div class="text-sm normal-case tracking-normal font-medium flex items-center gap-4">
                {{-- De Winkelwagen Teller --}}
                @livewire('cart-counter')

                @auth
                    <span class="text-blue-100 italic">Hoi, {{ auth()->user()->name }}</span>
                    <form action="/admin/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline opacity-80 font-bold">Uitloggen</button>
                    </form>
                @else
                    <a href="/admin/login" class="hover:underline font-bold">Inloggen</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Admin Quick Access Bar --}}
    @auth
        @if(auth()->user()->is_admin)
            <div class="bg-gray-900 text-white py-2 border-b border-gray-700">
                <div class="container mx-auto px-4 flex justify-between items-center text-xs font-bold uppercase tracking-wider">
                    <span class="text-gray-400">Admin Mode</span>
                    <a href="/admin" class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded text-gray-900 transition">
                        Naar Dashboard
                    </a>
                </div>
            </div>
        @endif
    @endauth

    <div class="container mx-auto py-10 px-4">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Beschikbare Items</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition flex flex-col">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-contain p-4 bg-gray-50">
                    @endif
                    
                    <div class="p-6 text-center flex-grow">
                        <h2 class="text-xl font-bold text-gray-900">{{ $product->name }}</h2>
                        <p class="text-gray-500 text-sm mb-4">{{ $product->category->name ?? 'Geen categorie' }}</p>
                        
                        <div class="text-2xl font-black text-blue-600 mb-4">
                            €{{ number_format($product->price, 2) }}
                        </div>

                        @if($product->bonus_percentage > 0)
                            <span class="inline-block bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full mb-4">
                                +{{ $product->bonus_percentage }}% extra
                            </span>
                        @endif

                        {{-- De Livewire Knop --}}
                        @livewire('add-to-cart', ['productId' => $product->id], key($product->id))
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @livewireScripts
</body>
</html>