<div>
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
</div><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/livewire/add-to-cart.blade.php ENDPATH**/ ?>