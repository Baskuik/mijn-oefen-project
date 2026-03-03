<nav class="bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
    <a href="<?php echo e(route('home')); ?>" class="text-slate-800 font-semibold text-lg hover:text-slate-900">
      MijnShop
    </a>

    <div class="flex items-center gap-4">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('dashboard')); ?>" class="text-slate-700 hover:text-slate-900">Dashboard</a>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->is_admin): ?>
          <a href="<?php echo e(route('filament.admin.pages.dashboard')); ?>" class="text-slate-700 hover:text-slate-900">Admin</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-slate-900 text-white hover:bg-slate-800">
            Uitloggen
          </button>
        </form>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('login')); ?>" class="text-slate-700 hover:text-slate-900">Inloggen</a>
        <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center px-3 py-1.5 rounded-md bg-slate-900 text-white hover:bg-slate-800">
          Registreren
        </a>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</nav><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/components/site-navbar.blade.php ENDPATH**/ ?>