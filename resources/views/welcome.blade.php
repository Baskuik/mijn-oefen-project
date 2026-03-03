<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MijnShop</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="antialiased bg-white text-slate-800">
  @include('components.site-navbar')

  <section class="bg-gradient-to-br from-amber-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Welkom bij MijnShop</h1>
      <p class="mt-3 text-slate-600 max-w-2xl">
        Log in om te bestellen, of bekijk ons aanbod en voeg producten toe aan je winkelwagen.
      </p>
      <div class="mt-6 flex gap-3">
        <a href="{{ route('login') }}"
          class="inline-flex items-center px-4 py-2 rounded-md bg-slate-900 text-white hover:bg-slate-800">
          Inloggen
        </a>
        <a href="{{ route('register') }}"
          class="inline-flex items-center px-4 py-2 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50">
          Registreren
        </a>
      </div>
    </div>
  </section>

  @livewireScripts
</body>

</html>