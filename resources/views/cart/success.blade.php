<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Geslaagd! - Pokémon Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white p-10 rounded-3xl shadow-2xl text-center border border-gray-100">
        {{-- Een vrolijke icoon --}}
        <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-5xl">
            ✓
        </div>

        <h1 class="text-3xl font-black text-gray-900 mb-4">Gevangen!</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Bedankt voor je bestelling. De betaling is gelukt en we maken je items direct klaar voor verzending naar je Pokédex.
        </p>

        <div class="space-y-3">
            <a href="/" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-blue-200">
                Terug naar de Store
            </a>
            <p class="text-xs text-gray-400">Een bevestiging is onderweg naar je e-mail.</p>
        </div>
    </div>

    {{-- Optioneel: wat confetti effect met CSS --}}
    <style>
        body {
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>

</body>
</html>