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
                if (this.device === 'mobile') return '390px';   // iPhone-ish
                if (this.device === 'tablet') return '768px';   // iPad-ish
                return '100%';                                  // desktop
            },
            reloadPreview() {
                const f = document.getElementById('site-preview-iframe');
                if (f) f.src = f.src;
            },
            init() {
                window.addEventListener('site-settings-saved', () => {
                    this.reloadPreview();
                });
            },
        }"
        x-init="init()"
        class="grid grid-cols-12 gap-6"
    >
        <!-- LEFT: Meta-informatie + formulier -->
        <div class="col-span-12 lg:col-span-5 space-y-4">
            <!-- Pagina header / uitleg -->
            <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm space-y-1">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <h2 class="text-base font-semibold tracking-tight text-gray-900">
                            Website bewerken
                        </h2>
                        <p class="mt-0.5 text-xs text-gray-500">
                            Stap 1: pas de inhoud aan · Stap 2: controleer de preview · Stap 3: sla op.
                        </p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-medium text-indigo-700">
                        Beheerdermodus
                    </span>
                </div>
            </div>

            <!-- Toolbar boven het formulier -->
            <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm space-y-3">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div class="flex flex-col gap-1">
                            <label for="page" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                Voorbeeldpagina
                            </label>
                            <select
                                id="page"
                                x-model="page"
                                class="fi-input rounded-md border-gray-300 bg-white px-2 py-1.5 text-sm leading-5
                                       focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                            >
                                <option value="home">Homepagina</option>
                                <option value="cart">Winkelwagen</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="device" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                Schermformaat
                            </label>
                            <select
                                id="device"
                                x-model="device"
                                class="fi-input rounded-md border-gray-300 bg-white px-2 py-1.5 text-sm leading-5
                                       focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                            >
                                <option value="desktop">Desktop</option>
                                <option value="tablet">Tablet</option>
                                <option value="mobile">Mobiel</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-2 border-t border-dashed border-gray-200 pt-2">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input
                                type="checkbox"
                                x-model="allowClicks"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 shadow-sm
                                       focus:ring-indigo-500"
                            >
                            <span>Klikken in preview toestaan</span>
                        </label>

                        <div class="flex items-center gap-2">
                            <x-filament::button
                                color="gray"
                                size="sm"
                                x-on:click="reloadPreview()"
                            >
                                Vernieuwen
                            </x-filament::button>

                            <x-filament::button
                                color="gray"
                                size="sm"
                                x-bind:href="pages[page]"
                                target="_blank"
                                tag="a"
                            >
                                Open pagina
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filament formulier -->
            <div class="rounded-lg border border-gray-200 bg-white px-4 py-4 shadow-sm">
                <form wire:submit="save" class="space-y-4">
                    {{ $this->form }}

                    <div class="flex flex-wrap items-center gap-3 pt-2 border-t border-dashed border-gray-200 dark:border-gray-700">
                        <x-filament::button type="submit" size="lg">
                            Wijzigingen opslaan
                        </x-filament::button>

                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Tip: na het opslaan kun je het previewvenster rechts vernieuwen om de wijzigingen te zien.
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT: Sticky live preview -->
        <div class="col-span-12 lg:col-span-7">
            <div class="lg:sticky lg:top-20 rounded-lg border border-gray-200 overflow-hidden bg-white shadow-sm">
                <!-- Preview header -->
                <div class="flex items-center justify-between px-4 py-2 bg-gray-50/90 dark:bg-gray-800/70 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                            Live voorbeeld
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="hidden sm:inline-flex items-center text-[11px] text-gray-500">
                            URL:
                            <span class="ml-1 truncate max-w-[220px] text-gray-600" x-text="pages[page]"></span>
                        </span>
                        <button
                            type="button"
                            title="Vernieuw voorbeeld"
                            class="text-xs font-medium text-indigo-600 hover:text-indigo-700"
                            x-on:click="reloadPreview()"
                        >
                            Vernieuwen
                        </button>
                    </div>
                </div>

                <!-- Preview stage -->
                <div class="bg-gray-50 px-4 py-4">
                    <div
                        class="mx-auto bg-white shadow-sm ring-1 ring-gray-200 rounded-lg overflow-hidden"
                        :style="'width:' + deviceWidth() + ';'"
                    >
                        <iframe
                            id="site-preview-iframe"
                            :src="pages[page]"
                            class="w-full h-[720px] border-0"
                            :style="allowClicks ? '' : 'pointer-events: none;'"
                            title="Webshop voorbeeld"
                        ></iframe>
                    </div>

                    <!-- Device hints -->
                    <div class="mt-2 flex flex-wrap items-center justify-between gap-2 text-[11px] text-gray-500">
                        <div x-show="device === 'desktop'">Desktopbreedte (volledige pagina)</div>
                        <div x-show="device === 'tablet'">Tabletbreedte ≈ 768px</div>
                        <div x-show="device === 'mobile'">Mobiele breedte ≈ 390px</div>
                        <div class="hidden sm:block">
                            Klikken in preview:
                            <span class="font-medium" x-text="allowClicks ? 'aan' : 'uit'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>