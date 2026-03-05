<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Betaalmethode Kiezen - MijnShop</title>

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
    input[type="radio"]:checked + div {
      border-color: #4f46e5;
      background-color: #eef2ff;
    }
    .dark input[type="radio"]:checked + div {
      border-color: #6366f1;
      background-color: rgba(99, 102, 241, 0.15);
    }
  </style>
</head>
<body class="bg-gray-100 dark:bg-slate-950 font-sans text-gray-900 dark:text-slate-100 min-h-screen transition-colors duration-300">

  @include('components.site-navbar')

  <div class="max-w-xl mx-auto py-12 px-4">
    <div class="text-center mb-10">
      <h1 class="text-3xl font-black mb-2 text-slate-900 dark:text-white">Afrekenen</h1>
      <p class="text-gray-500 dark:text-slate-400">Selecteer hoe je wilt betalen</p>
    </div>

    <form action="{{ route('cart.process-payment') }}" method="POST" class="space-y-4">
      @csrf

      {{-- iDEAL --}}
      <label class="relative block cursor-pointer">
        <input type="radio" name="payment_method" value="ideal" class="peer hidden" checked>
        <div class="p-5 bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-slate-600 rounded-2xl transition peer-checked:border-indigo-600 dark:peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
              <img src="https://www.ideal.nl/img/ideal-logo.svg" class="h-8" alt="iDEAL">
              <span class="font-bold text-lg text-slate-900 dark:text-white">iDEAL</span>
            </div>
          </div>
          <select name="bank" class="w-full p-3 border border-gray-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
            <option value="">Kies je bank...</option>
            <option value="ing">ING</option>
            <option value="rabobank">Rabobank</option>
            <option value="abn_amro">ABN AMRO</option>
            <option value="sns">SNS Bank</option>
            <option value="revolut">Revolut</option>
          </select>
        </div>
      </label>

      {{-- PayPal --}}
      <label class="relative block cursor-pointer">
        <input type="radio" name="payment_method" value="paypal" class="peer hidden">
        <div class="p-5 bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-slate-600 rounded-2xl transition peer-checked:border-indigo-600 dark:peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20">
          <div class="flex items-center gap-3">
            <span class="text-blue-500 font-black italic text-xl">Pay<span class="text-blue-800 dark:text-blue-400">Pal</span></span>
          </div>
        </div>
      </label>

      {{-- Creditcard --}}
      <label class="relative block cursor-pointer">
        <input type="radio" name="payment_method" value="creditcard" class="peer hidden">
        <div class="p-5 bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-slate-600 rounded-2xl transition peer-checked:border-indigo-600 dark:peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20">
          <div class="flex items-center gap-3">
            <span class="font-bold text-lg text-slate-900 dark:text-white">Creditcard</span>
            <div class="flex gap-2">
              <span class="bg-blue-800 text-white px-2 py-0.5 rounded text-[10px] font-bold">VISA</span>
              <span class="bg-red-500 text-white px-2 py-0.5 rounded text-[10px] font-bold">MASTER</span>
            </div>
          </div>
        </div>
      </label>

      <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white font-black py-4 rounded-2xl shadow-xl transition-all transform active:scale-95 mt-6">
        BETALEN EN BESTELLING AFRONDEN
      </button>
    </form>

    <p class="text-center text-gray-400 dark:text-slate-500 text-xs mt-8">
      Beveiligde betaling via MijnShop Payment Gateway &copy; 2026
    </p>
  </div>

  @livewireScripts
</body>
</html> 