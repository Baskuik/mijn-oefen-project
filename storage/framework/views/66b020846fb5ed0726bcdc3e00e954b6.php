<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Betaling Geslaagd - MijnShop</title>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="antialiased bg-slate-50 text-slate-800 min-h-screen">
    <?php echo $__env->make('components.site-navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
    <div class="bg-white rounded-2xl shadow-xl p-12">
      <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 rounded-full bg-green-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>

      <h1 class="text-4xl font-bold text-slate-900 mb-4">Betaling Geslaagd! 🎉</h1>
      <p class="text-xl text-slate-600 mb-8">
        Bedankt voor je bestelling! Je ontvangt binnenkort een bevestiging per e-mail.
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="<?php echo e(route('home')); ?>" 
           class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold hover:from-amber-600 hover:to-amber-700 transition-all shadow-md hover:shadow-lg">
          Terug naar winkel
        </a>
        <a href="<?php echo e(route('orders.index')); ?>" 
           class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-lg border-2 border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition-all">
          Mijn bestellingen
        </a>
      </div>
    </div>
  </div>
</body>
</html><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/checkout/success.blade.php ENDPATH**/ ?>