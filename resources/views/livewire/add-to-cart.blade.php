<div x-data="{ open: $wire.entangle('showVerificationModal') }">
    @if (session()->has('success'))
        <div class="text-green-600 dark:text-green-400 text-xs font-bold mb-2 animate-pulse">
            {{ session('success') }}!
        </div>
    @endif

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

    @teleport('body')
    {{-- Email verification modal – teleported to <body> to escape card's overflow-hidden + transform --}}
    <div
        x-data="{ open: $wire.entangle('showVerificationModal') }"
        x-init="$watch('open', v => document.body.classList.toggle('overflow-hidden', v))"
        x-show="open"
        x-on:keydown.escape.window="open = false; $wire.closeModal()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] flex items-center justify-center px-4 sm:px-6"
        style="display:none;"
    >
        {{-- Backdrop --}}
        <div
            class="absolute inset-0 bg-black/70 backdrop-blur-lg"
            @click="open = false; $wire.closeModal()"
        ></div>

        {{-- Modal panel --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative z-[10000] bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
            role="dialog"
            aria-modal="true"
            aria-labelledby="cart-modal-title"
        >
            {{-- Amber accent bar --}}
            <div class="h-1.5 w-full bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500"></div>

            {{-- Modal header --}}
            <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 id="cart-modal-title" class="text-base font-bold text-slate-900 dark:text-white">
                        E-mailadres niet geverifieerd
                    </h3>
                </div>
                {{-- X close button --}}
                <button
                    type="button"
                    @click="open = false; $wire.closeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 dark:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-700 dark:hover:text-slate-200 transition-colors"
                    aria-label="Sluiten"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="px-6 py-5 space-y-4">
                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    Je e‑mailadres is nog niet geverifieerd. Verifieer je adres om artikelen toe te voegen aan je winkelwagen.
                </p>

                {{-- Consequence list --}}
                <ul class="space-y-2">
                    <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/>
                        </svg>
                        Controleer je inbox voor de verificatie-e‑mail.
                    </li>
                    <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/>
                        </svg>
                        Stuur de e‑mail opnieuw als je hem niet hebt ontvangen.
                    </li>
                    <li class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01"/>
                        </svg>
                        Na verificatie kun je direct artikelen toevoegen.
                    </li>
                </ul>
            </div>

            {{-- Modal footer --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-700">
                {{-- Cancel --}}
                <button
                    type="button"
                    @click="open = false; $wire.closeModal()"
                    class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-xl transition-colors shadow-sm"
                >
                    Sluiten
                </button>

                {{-- Resend verification email --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 rounded-xl transition-all shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Verificatie-e-mail versturen
                    </button>
                </form>
            </div>

        </div>
    </div>
    {{-- /Email verification modal --}}
    @endteleport
</div> 