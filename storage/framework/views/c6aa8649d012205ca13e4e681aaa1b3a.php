<div
    x-data="{ open: $wire.entangle('showVerificationModal') }"
    x-init="$watch('open', v => document.body.classList.toggle('overflow-hidden', v))"
>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
        <div class="text-green-600 dark:text-green-400 text-xs font-bold mb-2 animate-pulse">
            <?php echo e(session('success')); ?>!
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <button
        type="button"
        wire:click="addToCart"
        wire:loading.attr="disabled"
        class="w-full bg-slate-900 hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600 disabled:bg-gray-400 text-white font-bold py-3 rounded-xl transition flex justify-center items-center shadow-md hover:shadow-lg"
    >
        <span wire:loading.remove wire:target="addToCart">
            Toevoegen aan winkelwagen
        </span>

        <span wire:loading wire:target="addToCart" class="flex items-center">
            <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Bezig...
        </span>
    </button>

    
    <div
        x-show="open"
        x-on:keydown.escape.window="open = false; $wire.closeModal()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-center justify-center px-6 md:px-10"
        style="display:none;"
    >
        
        <div
            class="absolute inset-0 bg-black/70 backdrop-blur-lg"
            @click="open = false; $wire.closeModal()"
        ></div>

        
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="relative z-[101] bg-white rounded-3xl shadow-2xl w-full max-w-3xl md:max-w-4xl xl:max-w-5xl p-8 md:p-12"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex items-start gap-5 md:gap-8">
                
                <div class="w-16 h-16 md:w-20 md:h-20 bg-amber-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-10 md:w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <h3 class="text-2xl md:text-3xl xl:text-4xl font-extrabold text-slate-900 mb-3">
                        E-mailadres niet geverifieerd
                    </h3>
                    <p class="text-slate-600 text-base md:text-lg leading-relaxed">
                        Je moet je e-mailadres verifiëren voordat je artikelen aan je winkelwagen kunt toevoegen.
                        Controleer je inbox voor de verificatie-e-mail, of stuur hem opnieuw.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        
                        <button
                            type="button"
                            @click="open = false; $wire.closeModal()"
                            class="sm:flex-1 px-5 py-3 md:py-4 text-base md:text-lg font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors"
                        >
                            Sluiten
                        </button>

                        
                        <form method="POST" action="<?php echo e(route('verification.send')); ?>" class="sm:flex-1">
                            <?php echo csrf_field(); ?>
                            <button
                                type="submit"
                                class="w-full px-5 py-3 md:py-4 text-base md:text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors"
                            >
                                Verificatie-e-mail versturen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/livewire/add-to-cart.blade.php ENDPATH**/ ?>