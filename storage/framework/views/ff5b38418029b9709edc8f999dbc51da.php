<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Bestellingen - MijnShop</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-slate-50 min-h-screen">

    <?php echo $__env->make('components.site-navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Mijn Bestellingen</h1>
            <p class="text-slate-500 mt-1">Een overzicht van al je eerdere aankopen.</p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->isEmpty()): ?>
            
            <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-slate-300">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-700 mb-2">Nog geen bestellingen</h3>
                <p class="text-slate-500 mb-6">Je hebt hier nog niets gekocht. Ga shoppen!</p>
                <a href="<?php echo e(route('home')); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Naar de shop
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Bestelling</p>
                                    <p class="font-semibold text-slate-800">#<?php echo e($order->id); ?></p>
                                </div>
                                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Datum</p>
                                    <p class="font-medium text-slate-700"><?php echo e($order->created_at->format('d M Y')); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                
                                <?php
                                    $statusColor = match($order->status) {
                                        'paid'      => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                        default     => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                    $statusLabel = match($order->status) {
                                        'paid'      => 'Betaald',
                                        'pending'   => 'In behandeling',
                                        'cancelled' => 'Geannuleerd',
                                        default     => ucfirst($order->status),
                                    };
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border <?php echo e($statusColor); ?>">
                                    <?php echo e($statusLabel); ?>

                                </span>
                                <div class="text-right">
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Totaal</p>
                                    <p class="font-bold text-slate-900 text-lg">€<?php echo e(number_format($order->total_price, 2, ',', '.')); ?></p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="divide-y divide-slate-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <div class="flex items-center justify-between px-6 py-4 gap-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-800 truncate">Product #<?php echo e($item->product_id); ?></p>
                                            <p class="text-xs text-slate-500">Aantal: <?php echo e($item->quantity); ?></p>
                                        </div>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700 flex-shrink-0">
                                        €<?php echo e(number_format($item->price * $item->quantity, 2, ',', '.')); ?>

                                    </p>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/orders/index.blade.php ENDPATH**/ ?>