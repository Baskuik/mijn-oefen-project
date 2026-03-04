<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Bestellingen - MijnShop</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .order-card {
            opacity: 0;
            animation: fadeInUp 0.5s ease forwards;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen">

    <?php echo $__env->make('components.site-navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 pt-12 pb-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div>
                    <p class="text-indigo-300 text-sm font-semibold uppercase tracking-widest mb-2">Mijn Account</p>
                    <h1 class="text-3xl font-extrabold text-white mb-1">Mijn Bestellingen</h1>
                    <p class="text-slate-400 text-sm">Een overzicht van al je eerdere aankopen.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl px-5 py-4 text-center">
                        <p class="text-3xl font-extrabold text-white"><?php echo e($orders->count()); ?></p>
                        <p class="text-xs text-slate-300 font-medium mt-0.5"><?php echo e($orders->count() === 1 ? 'Bestelling' : 'Bestellingen'); ?></p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->count() > 0): ?>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl px-5 py-4 text-center">
                            <p class="text-3xl font-extrabold text-white">€<?php echo e(number_format($orders->sum('total_price'), 0, ',', '.')); ?></p>
                            <p class="text-xs text-slate-300 font-medium mt-0.5">Totaal besteed</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-14 pb-16">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->isEmpty()): ?>
            
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 text-center py-20 px-6">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Nog geen bestellingen</h3>
                <p class="text-slate-400 text-sm mb-8">Je hebt hier nog niets besteld. Begin met shoppen!</p>
                <a href="<?php echo e(route('home')); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-slate-800 text-white font-semibold rounded-xl hover:bg-slate-700 active:scale-95 transition-all duration-200 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Naar de shop
                </a>
            </div>

        <?php else: ?>
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
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
                        $statusIcon = match($order->status) {
                            'paid'      => 'M5 13l4 4L19 7',
                            'pending'   => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                            'cancelled' => 'M6 18L18 6M6 6l12 12',
                            default     => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        };
                    ?>

                    
                    <div x-data="{ open: <?php echo e($loop->first ? 'true' : 'false'); ?> }"
                         class="order-card bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden"
                         style="animation-delay: <?php echo e($loop->index * 0.07); ?>s;">

                        
                        <button @click="open = !open"
                                class="w-full text-left flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-5 hover:bg-slate-50 transition-colors duration-150 focus:outline-none">
                            <div class="flex items-center gap-5">
                                
                                <div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Bestelling</p>
                                    <p class="font-bold text-slate-900 text-base">#<?php echo e($order->id); ?></p>
                                </div>
                                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>
                                <div class="hidden sm:block">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Datum</p>
                                    <p class="font-semibold text-slate-700 text-sm"><?php echo e($order->created_at->format('d M Y')); ?></p>
                                </div>
                                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>
                                <div class="hidden sm:block">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Artikelen</p>
                                    <p class="font-semibold text-slate-700 text-sm"><?php echo e($order->items->count()); ?> <?php echo e($order->items->count() === 1 ? 'artikel' : 'artikelen'); ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full border <?php echo e($statusColor); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="<?php echo e($statusIcon); ?>" />
                                    </svg>
                                    <?php echo e($statusLabel); ?>

                                </span>

                                
                                <div class="text-right">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Totaal</p>
                                    <p class="font-extrabold text-slate-900 text-lg">€<?php echo e(number_format($order->total_price, 2, ',', '.')); ?></p>
                                </div>

                                
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5 text-slate-400 transition-transform duration-300 flex-shrink-0"
                                     :class="open ? 'rotate-180' : ''"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="border-t border-slate-100">

                            <div class="divide-y divide-slate-50">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <div class="flex items-center justify-between px-6 py-4 gap-4 hover:bg-slate-50/60 transition-colors">
                                        <div class="flex items-center gap-4 min-w-0">
                                            
                                            <div class="w-12 h-12 bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-slate-800 truncate">
                                                    <?php echo e($item->product?->name ?? 'Product #' . $item->product_id); ?>

                                                </p>
                                                <p class="text-xs text-slate-400 mt-0.5">
                                                    Aantal: <span class="font-semibold text-slate-600"><?php echo e($item->quantity); ?></span>
                                                    &nbsp;·&nbsp;
                                                    €<?php echo e(number_format($item->price, 2, ',', '.')); ?> per stuk
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-base font-bold text-slate-900">
                                                €<?php echo e(number_format($item->price * $item->quantity, 2, ',', '.')); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>

                            
                            <div class="flex items-center justify-between px-6 py-4 bg-slate-50 border-t border-slate-100">
                                <p class="text-xs text-slate-400">Besteld op <?php echo e($order->created_at->format('d F Y \o\m H:i')); ?></p>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-slate-500 font-medium">Totaal:</span>
                                    <span class="text-base font-extrabold text-slate-900">€<?php echo e(number_format($order->total_price, 2, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            
            <div class="mt-8 text-center">
                <a href="<?php echo e(route('home')); ?>" class="text-sm text-slate-400 hover:text-slate-700 transition-colors">
                    ← Terug naar de shop
                </a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/orders/index.blade.php ENDPATH**/ ?>