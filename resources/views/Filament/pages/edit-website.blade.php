<div
    x-data="{
        page: 'home',
        device: 'desktop',
        allowClicks: false,
        scale: 1,
        iframeHeight: 900,
        pages: {
            home: '{{ url('/') }}',
            cart: '{{ url('/cart') }}',
        },
        nativeWidth() {
            if (this.device === 'mobile')  return 390;
            if (this.device === 'tablet')  return 768;
            return 1280;
        },
        computeScale() {
            const el = document.getElementById('preview-stage');
            if (!el) return;
            this.scale = Math.min(1, el.offsetWidth / this.nativeWidth());
        },
        reloadPreview() {
            const f = document.getElementById('site-preview-iframe');
            if (f) { const s = f.src; f.src = ''; f.src = s; }
        },
        init() {
            this.$nextTick(() => {
                this.computeScale();
                const obs = new ResizeObserver(() => this.computeScale());
                const el  = document.getElementById('preview-stage');
                if (el) obs.observe(el);
            });
            this.$watch('device', () => this.computeScale());
            window.addEventListener('site-settings-saved', () => this.reloadPreview());
        },
    }"
    x-init="init()"
    class="flex flex-col"
>

    {{-- ╔══════════════════════════════════════════════════════╗
         ║  STICKY TOPBAR                                       ║
         ╚══════════════════════════════════════════════════════╝ --}}
    <div class="sticky top-0 z-30 mb-5 flex items-center justify-between
                border-b border-gray-200/80 bg-white/90 px-1 py-3
                backdrop-blur-md">

        <div class="flex items-center gap-2.5">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-600 text-white text-sm">✎</span>
            <span class="text-sm font-semibold text-gray-800">Website bewerken</span>
            <span class="rounded-full bg-indigo-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-indigo-600">
                Live preview
            </span>
        </div>

        <div class="flex items-center gap-2">
            <a
                x-bind:href="pages[page]"
                target="_blank"
                class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white
                       px-3 py-1.5 text-xs font-medium text-gray-500 shadow-sm hover:text-indigo-600"
            >
                Openen ↗
            </a>
            <button
                type="submit"
                form="edit-website-form"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600
                       px-4 py-1.5 text-xs font-semibold text-white shadow-sm
                       hover:bg-indigo-700 active:scale-95 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="save">✓ Opslaan</span>
                <span wire:loading wire:target="save" class="flex items-center gap-1">
                    <svg class="h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"></path>
                    </svg>
                    Bezig…
                </span>
            </button>
        </div>
    </div>

    {{-- ╔══════════════════════════════════════════════════════╗
         ║  TWEE KOLOMMEN (5 form  /  7 preview)               ║
         ╚══════════════════════════════════════════════════════╝ --}}
    <div class="grid grid-cols-12 gap-5 items-start">

        {{-- ══ LINKS: formulier (5 kolommen) ══ --}}
        <div class="col-span-12 xl:col-span-5 flex flex-col gap-4">

            <form id="edit-website-form" wire:submit="save">

                {{-- Filament form --}}
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="px-4 py-4">
                        {{ $this->form }}
                    </div>

                    {{-- Opslaan rij --}}
                    <div class="flex items-center gap-3 border-t border-gray-100 bg-gray-50/60 px-4 py-3">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="save"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600
                                   px-4 py-2 text-sm font-semibold text-white shadow-sm
                                   hover:bg-indigo-700 active:scale-95 disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="save">✓ Wijzigingen opslaan</span>
                            <span wire:loading wire:target="save">Opslaan…</span>
                        </button>
                        <p class="text-[11px] text-gray-400 leading-tight">
                            Preview vernieuwt automatisch<br>na het opslaan.
                        </p>
                    </div>

                </div>

            </form>
        </div>

        {{-- ══ RECHTS: live preview (7 kolommen) ══ --}}
        <div class="col-span-12 xl:col-span-7">
            <div class="xl:sticky xl:top-16 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">

                {{-- Browser chrome balk --}}
                <div class="flex items-center gap-2 border-b border-gray-100 bg-gray-50 px-3 py-2">

                    {{-- Traffic lights --}}
                    <div class="flex shrink-0 gap-1.5 mr-1">
                        <span class="h-3 w-3 rounded-full bg-red-400"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                    </div>

                    {{-- Pagina selector (pill-stijl) --}}
                    <div class="flex shrink-0 items-center gap-1 rounded-md bg-gray-200/70 p-0.5">
                        <button type="button" x-on:click="page = 'home'"
                            :class="page === 'home' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'"
                            class="rounded px-2.5 py-0.5 text-[11px] font-medium transition">
                            🏠 Home
                        </button>
                        <button type="button" x-on:click="page = 'cart'"
                            :class="page === 'cart' ? 'bg-white shadow text-gray-800' : 'text-gray-500 hover:text-gray-700'"
                            class="rounded px-2.5 py-0.5 text-[11px] font-medium transition">
                            🛒 Cart
                        </button>
                    </div>

                    {{-- Nep adresbalk --}}
                    <div class="flex flex-1 items-center gap-1 rounded-md border border-gray-200
                                bg-white px-2.5 py-1 text-[11px] text-gray-400">
                        <svg class="h-3 w-3 shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="truncate" x-text="pages[page]"></span>
                    </div>

                    {{-- Device knoppen --}}
                    <div class="flex shrink-0 items-center gap-0.5 rounded-md bg-gray-200/70 p-0.5">
                        <button type="button" title="Desktop" x-on:click="device = 'desktop'"
                            :class="device === 'desktop' ? 'bg-white shadow text-indigo-600' : 'text-gray-400 hover:text-gray-600'"
                            class="rounded p-1 transition">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                            </svg>
                        </button>
                        <button type="button" title="Tablet" x-on:click="device = 'tablet'"
                            :class="device === 'tablet' ? 'bg-white shadow text-indigo-600' : 'text-gray-400 hover:text-gray-600'"
                            class="rounded p-1 transition">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <rect x="4" y="2" width="16" height="20" rx="2"/><circle cx="12" cy="18" r="1"/>
                            </svg>
                        </button>
                        <button type="button" title="Mobiel" x-on:click="device = 'mobile'"
                            :class="device === 'mobile' ? 'bg-white shadow text-indigo-600' : 'text-gray-400 hover:text-gray-600'"
                            class="rounded p-1 transition">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="18" r="1"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Vernieuw knop --}}
                    <button type="button" x-on:click="reloadPreview()"
                        title="Vernieuwen"
                        class="shrink-0 rounded-md p-1 text-gray-400 hover:bg-gray-100 hover:text-indigo-600 transition">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M4 9a8.001 8.001 0 0113.9-2.7L20 9M4 15l2.1 2.7A8 8 0 0020 15"/>
                        </svg>
                    </button>
                </div>

                {{-- ── iframe preview ── --}}
                <div id="preview-stage" class="relative w-full overflow-hidden bg-gray-100">

                    {{-- Schaal-wrapper --}}
                    <div
                        :style="'height: ' + (iframeHeight * scale) + 'px;'"
                        class="relative overflow-hidden"
                    >
                        <iframe
                            id="site-preview-iframe"
                            :src="pages[page]"
                            :style="'width: ' + nativeWidth() + 'px; height: ' + iframeHeight + 'px; transform: scale(' + scale + '); transform-origin: top left; border: 0;'"
                            :class="allowClicks ? '' : 'pointer-events-none'"
                            title="Webshop live preview"
                        ></iframe>
                    </div>

                    {{-- Klik-blokkeer overlay label --}}
                    <div
                        x-show="!allowClicks"
                        class="absolute bottom-3 right-3 flex items-center gap-1.5 rounded-full
                               bg-black/40 px-2.5 py-1 text-[10px] font-medium text-white backdrop-blur-sm"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Alleen bekijken
                    </div>
                </div>

                {{-- ── Statusbalk ── --}}
                <div class="flex items-center justify-between border-t border-gray-100
                            bg-gray-50 px-4 py-1.5 text-[11px] text-gray-400">
                    <span>
                        <span x-show="device === 'desktop'">🖥 Desktop — 1280 px</span>
                        <span x-show="device === 'tablet'">📱 Tablet — 768 px</span>
                        <span x-show="device === 'mobile'">📲 Mobiel — 390 px</span>
                        <span class="ml-2 text-gray-300">·</span>
                        <span class="ml-2">schaal <span x-text="Math.round(scale * 100)"></span>%</span>
                    </span>
                    <label class="inline-flex cursor-pointer items-center gap-1.5">
                        <input type="checkbox" x-model="allowClicks"
                            class="h-3.5 w-3.5 rounded border-gray-300 text-indigo-600 focus:ring-0">
                        <span>Klikken toestaan</span>
                    </label>
                </div>

            </div>{{-- end preview kaart --}}
        </div>{{-- end rechts --}}

    </div>{{-- end grid --}}
</div>{{-- end x-data --}}