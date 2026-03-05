<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jouw Winkelmandje - MijnShop</title>

  <!-- Dark mode: apply before CSS renders to prevent flash -->
  <script>
    (function () {
      var t = localStorage.getItem('theme');
      if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>

  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gray-100 dark:bg-slate-950 font-sans min-h-screen transition-colors duration-300">

  <?php echo $__env->make('components.site-navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-black text-gray-800 dark:text-white mb-8">Jouw Bestelling</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($cart) > 0): ?>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 flex items-center gap-6">
              <img src="<?php echo e(asset('storage/' . $details['image'])); ?>" class="w-20 h-20 object-contain rounded-xl flex-shrink-0">
              <div class="flex-grow min-w-0">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white"><?php echo e($details['name']); ?></h3>
                <p class="text-indigo-600 dark:text-indigo-400 font-bold">€<?php echo e(number_format($details['price'], 2)); ?></p>
                <p class="text-gray-500 dark:text-slate-400 text-sm">Aantal: <?php echo e($details['quantity']); ?></p>
                <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST" class="mt-2">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-bold uppercase transition-colors">❌ Verwijderen</button>
                </form>
              </div>
              <div class="text-right font-black text-gray-900 dark:text-white flex-shrink-0">
                €<?php echo e(number_format($details['price'] * $details['quantity'], 2)); ?>

              </div>
            </div>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 h-fit sticky top-10">
          <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Totaaloverzicht</h2>
          <div class="flex justify-between mb-8">
            <span class="text-lg font-bold text-slate-700 dark:text-slate-300">Totaal</span>
            <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">€<?php echo e(number_format($total, 2)); ?></span>
          </div>
          <a href="<?php echo e(route('cart.checkout')); ?>" class="block text-center w-full bg-emerald-500 hover:bg-emerald-600 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:scale-105">
            Naar Betalen
          </a>
        </div>
      </div>
    <?php else: ?>
      <div class="text-center py-20 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-dashed border-gray-300 dark:border-slate-600">
        <p class="text-gray-500 dark:text-slate-400 text-xl mb-6">Je mandje is nog leeg...</p>
        <a href="<?php echo e(route('home')); ?>" class="bg-slate-800 dark:bg-slate-600 hover:bg-slate-700 dark:hover:bg-slate-500 text-white px-8 py-3 rounded-xl font-bold transition-colors">Ga shoppen!</a>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>

  <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views\cart\index.blade.php ENDPATH**/ ?>