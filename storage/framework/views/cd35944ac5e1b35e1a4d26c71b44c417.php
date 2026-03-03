<div class="inline-block w-full">
  <button
    type="button"
    wire:click="addToCart"
    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    In winkelwagen
  </button>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showLoginModal): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showLoginModal', false)"></div>
      <div class="relative mx-auto w-full max-w-md rounded-2xl bg-white shadow-2xl transform transition-all">
        <div class="p-8">
          <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-amber-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          
          <h2 class="text-2xl font-bold text-slate-900 mb-2 text-center">Inloggen vereist</h2>
          <p class="text-slate-600 mb-6 text-center">
            Log in of registreer om producten aan je winkelwagen toe te voegen en bestellingen te plaatsen.
          </p>
          
          <div class="flex flex-col gap-3">
            <a href="<?php echo e(route('login')); ?>"
               class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-gradient-to-r from-slate-900 to-slate-800 text-white font-semibold hover:from-slate-800 hover:to-slate-700 transition-all shadow-md hover:shadow-lg">
              Inloggen
            </a>
            <a href="<?php echo e(route('register')); ?>"
               class="inline-flex items-center justify-center px-5 py-3 rounded-lg border-2 border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition-all">
              Registreren
            </a>
            <button
              type="button"
              wire:click="$set('showLoginModal', false)"
              class="inline-flex items-center justify-center px-5 py-2 text-slate-500 hover:text-slate-700 transition-colors"
            >
              Sluiten
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/livewire/add-to-cart-button.blade.php ENDPATH**/ ?>