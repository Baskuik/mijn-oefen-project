<div class="bg-white shadow-sm border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-slate-900">
                    MyShop
                </a>
            </div>

        <!-- Navigation Links -->
        <nav class="flex space-x-8">
            <a href="<?php echo e(route('home')); ?>" class="text-slate-700 hover:text-slate-900 font-medium">Products</a>
        </nav>

            <!-- Cart -->
            <div class="flex items-center">
                <a href="<?php echo e(route('cart')); ?>" class="relative text-slate-700 hover:text-slate-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('cart_count', 0) > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <?php echo e(session('cart_count', 0)); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/components/site-navbar.blade.php ENDPATH**/ ?>