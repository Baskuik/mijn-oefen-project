<div
    x-data="{
        page: 'home',
        device: 'desktop',
        allowClicks: false,
        pages: {
            home: '{{ url('/') }}',
            cart: '{{ url('/cart') }}',
        },
        deviceWidth() {
            if (this.device === 'mobile') return '390px';
            if (this.device === 'tablet') return '768px';
            return '100%';
        },
        reloadPreview() {
            const f = document.getElementById('site-preview-iframe');
            if (f) { const src = f.src; f.src = ''; f.src = src; }
        },
        init() {
            window.addEventListener('site-settings-saved', () => {
                this.reloadPreview();
            });
        },
    }"
    x-init="init()"
>

    {{-- ────────────────────────────────────────────
         STICKY SAVE BAR
    ──────────────────────────────────────────── --}}
    <div class="sticky top-0 z-20 mb-6 flex items-center justify-between gap-4
                rounded-xl border border-gray-200 bg-white/95 px-5 py-3
                shadow-md backdrop-blur-sm">

        <div class="flex items-center gap-2">
            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
            <span class="text-sm font-semibold text-gray-800">Website bewerken</span>
            <span class="hidden sm:inline-flex items-center rounded-full
                         bg-indigo-50 px-2 py-0.5 text-[11px] font-medium text-indigo-600">
                Beheerdermodus
            </span>
        </div>

        <div class="flex items-center gap-2">
            <a
                x-bind:href="pages[page]"
                target="_blank"
                class="inline-flex items-center gap-1 rounded-lg border border-gray-200
                       bg-white px-3 py-1.5 text-xs font-medium text-gray-600
                       shadow-sm hover:bg-gray-50"
            >
                Open pagina ↗
            </a>
            <button
                type="submit"
                form="edit-website-form"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600
                       px-4 py-1.5 text-xs font-semibold text-white shadow-sm
                       hover:bg-indigo-700 disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save">✓ Opslaan</span>
                <span wire:loading wire:target="save">Bezig…</span>
            </button>
        </div>
    </div>

    {{-- ────────────────────────────────────────────
         TWEE KOLOMMEN
    ──────────────────────────────────────────── --}}
    <div class="grid grid-cols-12 gap-6">

        {{-- ── LINKS: toolbar + formulier ── --}}
        <div class="col-span-12 lg:col-span-6 flex flex-col gap-5">

            {{-- Toolbar kaart --}}
            <div class="rounded-xl border border-gray-200 bg-white px-5 py-4 shadow-sm">
                <p class="mb-3 text-[11px] font-semibold uppercase tracking-widest text-gray-400">
                    Preview instellingen
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-gray-600">Pagina</label>
                        <select
                            x-model="page"
                            class="w-full rounded-lg border border-gray-300 bg-white
                                   px-3 py-2 text-sm shadow-sm
                                   focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        >
                            <option value="home">🏠 Homepagina</option>
                            <option value="cart">🛒 Winkelwagen</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-medium text-gray-600">Scherm</label>
                        <select
                            x-model="device"
                            class="w-full rounded-lg border border-gray-300 bg-white
                                   px-3 py-2 text-sm shadow-sm
                                   focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        >
                            <option value="desktop">🖥 Desktop</option>
                            <option value="tablet">📱 Tablet (768 px)</option>
                            <option value="mobile">📲 Mobiel (390 px)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between
                            border-t border-dashed border-gray-100 pt-3">
                    <label class="inline-flex cursor-pointer items-center gap-2 text-xs text-gray-600">
                        <input
                            type="checkbox"
                            x-model="allowClicks"
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        Klikken in preview toestaan
                    </label>
                    <button
                        type="button"
                        x-on:click="reloadPreview()"
                        class="inline-flex items-center gap-1 rounded-md px-2.5 py-1
                               text-xs font-medium text-indigo-600
                               hover:bg-indigo-50 hover:text-indigo-800"
                    >
                        ↺ Vernieuwen
                    </button>
                </div>
            </div>

            {{-- Formulier kaart --}}
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <form id="edit-website-form" wire:submit="save">

                    <div class="px-5 py-5">
                        {{ $this->form }}
                    </div>

                    <div class="flex items-center gap-3
                                border-t border-dashed border-gray-100 px-5 py-4">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="save"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600
                                   px-5 py-2 text-sm font-semibold text-white shadow-sm
                                   hover:bg-indigo-700 disabled:opacity-60"
                        >
                            <span wire:loading.remove wire:target="save">✓ Wijzigingen opslaan</span>
                            <span wire:loading wire:target="save">Opslaan…</span>
                        </button>
                        <span class="text-xs text-gray-400">
                            Na het opslaan vernieuwt de preview automatisch.
                        </span>
                    </div>

                </form>
            </div>

        </div>{{-- end links --}}

        {{-- ── RECHTS: sticky live preview ── --}}
        <div class="col-span-12 lg:col-span-6">
            <div class="lg:sticky lg:top-20 overflow-hidden rounded-xl
                        border border-gray-200 bg-white shadow-sm">

                {{-- Browser chrome --}}
                <div class="flex items-center gap-3 border-b border-gray-100
                            bg-gray-50 px-4 py-2.5">

                    {{-- Traffic lights --}}
                    <div class="flex shrink-0 items-center gap-1.5">
                        <span class="h-3 w-3 rounded-full bg-red-400"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                    </div>

                    {{-- Nep adresbalk --}}
                    <div class="flex flex-1 items-center gap-1.5 rounded-md border
                                border-gray-200 bg-white px-3 py-1
                                text-[11px] text-gray-500">
                        <span class="text-gray-400">🔒</span>
                        <span class="truncate" x-text="pages[page]"></span>
                    </div>

                    {{-- Vernieuw knop --}}
                    <button
                        type="button"
                        x-on:click="reloadPreview()"
                        title="Vernieuwen"
                        class="shrink-0 rounded-md p-1 text-gray-500
                               hover:bg-gray-100 hover:text-indigo-600"
                    >
                        ↺
                    </button>
                </div>

                {{-- Iframe stage --}}
                <div class="flex justify-center bg-gray-100 p-4">
                    <div
                        class="overflow-hidden rounded-lg bg-white shadow-md
                               ring-1 ring-gray-200 transition-all duration-300"
                        :style="'width: ' + deviceWidth()"
                    >
                        <iframe
                            id="site-preview-iframe"
                            :src="pages[page]"
                            class="w-full border-0"
                            style="height: 660px;"
                            :style="allowClicks ? '' : 'pointer-events: none;'"
                            title="Webshop voorbeeld"
                        ></iframe>
                    </div>
                </div>

                {{-- Status balk --}}
                <div class="flex items-center justify-between
                            border-t border-gray-100 bg-gray-50
                            px-4 py-2 text-[11px] text-gray-500">
                    <span>
                        <span x-show="device === 'desktop'">🖥 Desktop — volledige breedte</span>
                        <span x-show="device === 'tablet'">📱 Tablet — 768 px</span>
                        <span x-show="device === 'mobile'">📲 Mobiel — 390 px</span>
                    </span>
                    <span>
                        Klikken:
                        <span class="font-semibold" x-text="allowClicks ? 'aan ✓' : 'uit ✗'"></span>
                    </span>
                </div>

            </div>
        </div>{{-- end rechts --}}

    </div>{{-- end grid --}}
</div>{{-- end x-data --}}