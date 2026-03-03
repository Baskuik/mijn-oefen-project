<div class="inline-block w-full">
  <button
    type="button"
    wire:click="addToCart"
    class="group/btn w-full relative inline-flex items-center justify-center gap-3 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500 text-white font-bold text-lg hover:from-orange-600 hover:via-amber-600 hover:to-yellow-600 focus:outline-none focus:ring-4 focus:ring-orange-500/50 transition-all duration-300 shadow-lg hover:shadow-2xl hover:shadow-orange-500/50 transform hover:-translate-y-1 overflow-hidden"
  >
    <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></span>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <span class="relative z-10">In Winkelwagen</span>
  </button>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showLoginModal): ?>
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 animate-fade-in">
      <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/60 to-black/70 backdrop-blur-md" wire:click="$set('showLoginModal', false)"></div>
      <div class="relative mx-auto w-full max-w-md rounded-3xl bg-white shadow-2xl transform transition-all animate-scale-in">
        <div class="p-10">
          <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-orange-100 to-amber-100 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          
          <h2 class="text-3xl font-extrabold text-slate-900 mb-3 text-center">Inloggen Vereist</h2>
          <p class="text-slate-600 mb-8 text-center leading-relaxed">
            Om producten aan je winkelwagen toe te voegen en bestellingen te plaatsen, moet je eerst inloggen of een account aanmaken.
          </p>
          
          <div class="flex flex-col gap-4">
            <a href="<?php echo e(route('login')); ?>"
               class="group inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-gradient-to-r from-slate-900 to-slate-800 text-white font-bold text-lg hover:from-slate-800 hover:to-slate-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
              </svg>
              Inloggen
            </a>
            <a href="<?php echo e(route('register')); ?>"
               class="group inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl border-2 border-slate-300 text-slate-700 font-bold text-lg hover:bg-slate-50 hover:border-slate-400 transition-all transform hover:-translate-y-0.5">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
              </svg>
              Account Aanmaken
            </a>
            <button
              type="button"
              wire:click="$set('showLoginModal', false)"
              class="inline-flex items-center justify-center px-6 py-3 text-slate-500 hover:text-slate-700 font-semibold transition-colors"
            >
              Sluiten
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<style>
  @keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  @keyframes scale-in {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }
  .animate-fade-in {
    animation: fade-in 0.2s ease-out;
  }
  .animate-scale-in {
    animation: scale-in 0.3s ease-out;
  }
</style><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/livewire/add-to-cart-button.blade.php ENDPATH**/ ?>