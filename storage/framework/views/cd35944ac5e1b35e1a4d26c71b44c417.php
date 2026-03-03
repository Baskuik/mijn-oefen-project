<div>
  <button
    type="button"
    wire:click="addToCart"
    wire:loading.attr="disabled"
    wire:target="addToCart"
    class="group/btn w-full relative inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg font-semibold text-base transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-70 bg-slate-900 text-white hover:bg-slate-800 shadow-md hover:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
    :class="{ '!bg-emerald-600 !shadow-lg': $wire.justAdded }"
  >
    <!-- Loading Spinner -->
    <svg 
      wire:loading 
      wire:target="addToCart"
      class="animate-spin h-5 w-5" 
      xmlns="http://www.w3.org/2000/svg" 
      fill="none" 
      viewBox="0 0 24 24"
    >
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>

    <!-- Success Checkmark -->
    <svg 
      x-show="$wire.justAdded"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-0"
      x-transition:enter-end="opacity-100 scale-100"
      style="display: none;"
      xmlns="http://www.w3.org/2000/svg" 
      class="h-5 w-5" 
      fill="none" 
      viewBox="0 0 24 24" 
      stroke="currentColor"
    >
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
    </svg>

    <!-- Cart Icon -->
    <svg 
      wire:loading.remove
      wire:target="addToCart"
      x-show="!$wire.justAdded"
      xmlns="http://www.w3.org/2000/svg" 
      class="h-5 w-5 transition-transform group-hover/btn:scale-110" 
      fill="none" 
      viewBox="0 0 24 24" 
      stroke="currentColor"
    >
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    
    <!-- Button Text -->
    <span wire:loading.remove wire:target="addToCart" x-text="$wire.justAdded ? 'Toegevoegd!' : 'Toevoegen aan winkelwagen'">
      Toevoegen aan winkelwagen
    </span>
    <span wire:loading wire:target="addToCart">Toevoegen...</span>
  </button>

  <!-- Login Modal -->
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showLoginModal): ?>
    <div 
      class="fixed inset-0 z-50 flex items-center justify-center p-4"
      x-data
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
    >
      <!-- Backdrop -->
      <div 
        class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" 
        wire:click="$set('showLoginModal', false)"
      ></div>
      
      <!-- Modal -->
      <div 
        class="relative mx-auto w-full max-w-md rounded-2xl bg-white shadow-2xl"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
      >
        <div class="p-8">
          <!-- Icon -->
          <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-xl bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          
          <h2 class="text-2xl font-bold text-slate-900 mb-2 text-center">Inloggen Vereist</h2>
          <p class="text-slate-600 mb-8 text-center">
            Om producten aan je winkelwagen toe te voegen, moet je eerst inloggen of een account aanmaken.
          </p>
          
          <!-- Action Buttons -->
          <div class="flex flex-col gap-3">
            <a href="<?php echo e(route('login')); ?>"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-slate-900 text-white font-semibold hover:bg-slate-800 transition-all shadow-md hover:shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
              </svg>
              Inloggen
            </a>
            <a href="<?php echo e(route('register')); ?>"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg border-2 border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 hover:border-slate-300 transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
              </svg>
              Account Aanmaken
            </a>
            <button
              type="button"
              wire:click="$set('showLoginModal', false)"
              class="px-6 py-2 text-slate-500 hover:text-slate-700 font-medium transition-colors"
            >
              Annuleren
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/livewire/add-to-cart-button.blade.php ENDPATH**/ ?>