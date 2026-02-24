<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Betaalmethode Kiezen - Pokémon GO Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Voor een mooie glow als je een methode selecteert */
        input[type="radio"]:checked + div {
            border-color: #2563eb;
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900">

    <div class="max-w-xl mx-auto py-12 px-4">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black mb-2">Afrekenen</h1>
            <p class="text-gray-500">Selecteer hoe je wilt betalen voor je Pokémon items</p>
        </div>

        <form action="{{ route('cart.process-payment') }}" method="POST" class="space-y-4">
            @csrf

            {{-- iDEAL Optie --}}
            <label class="relative block cursor-pointer">
                <input type="radio" name="payment_method" value="ideal" class="peer hidden" checked>
                <div class="p-5 bg-white border-2 border-gray-200 rounded-2xl transition peer-checked:border-blue-600 peer-checked:bg-blue-50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <img src="https://www.ideal.nl/img/ideal-logo.svg" class="h-8" alt="iDEAL">
                            <span class="font-bold text-lg">iDEAL</span>
                        </div>
                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 flex items-center justify-center">
                            <div class="w-3 h-3 bg-blue-600 rounded-full opacity-0 peer-checked:opacity-100"></div>
                        </div>
                    </div>
                    
                    {{-- Bankenselectie (Alleen bij iDEAL) --}}
                    <select name="bank" class="w-full p-3 border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Kies je bank...</option>
                        <option value="ing">ING</option>
                        <option value="rabobank">Rabobank</option>
                        <option value="abn_amro">ABN AMRO</option>
                        <option value="sns">SNS Bank</option>
                        <option value="revolut">Revolut</option>
                    </select>
                </div>
            </label>

            {{-- PayPal Optie --}}
            <label class="relative block cursor-pointer">
                <input type="radio" name="payment_method" value="paypal" class="peer hidden">
                <div class="p-5 bg-white border-2 border-gray-200 rounded-2xl transition peer-checked:border-blue-600 peer-checked:bg-blue-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-blue-500 font-black italic text-xl">Pay<span class="text-blue-800">Pal</span></span>
                        </div>
                    </div>
                </div>
            </label>

            {{-- Creditcard Optie --}}
            <label class="relative block cursor-pointer">
                <input type="radio" name="payment_method" value="creditcard" class="peer hidden">
                <div class="p-5 bg-white border-2 border-gray-200 rounded-2xl transition peer-checked:border-blue-600 peer-checked:bg-blue-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-lg">Creditcard</span>
                            <div class="flex gap-2">
                                <span class="bg-blue-800 text-white px-2 py-0.5 rounded text-[10px] font-bold">VISA</span>
                                <span class="bg-red-500 text-white px-2 py-0.5 rounded text-[10px] font-bold">MASTER</span>
                            </div>
                        </div>
                    </div>
                </div>
            </label>

            {{-- Betaalknop --}}
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl transition transform active:scale-95 mt-6">
                BETALEN EN BESTELLING AFRONDEN
            </button>
        </form>

        <p class="text-center text-gray-400 text-xs mt-8">
            Beveiligde betaling via Pokémon Payment Gateway &copy; 2026
        </p>
    </div>

</body>
</html>