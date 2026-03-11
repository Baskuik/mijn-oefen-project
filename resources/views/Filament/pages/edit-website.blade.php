<x-filament-panels::page>
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
        }"
        class="grid grid-cols-12 gap-6"
    >
        <!-- LEFT: Form / controls -->
        <div class="col-span-12 lg:col-span-5 space-y-4">
            <!-- Toolbar above the form -->
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/50 px-4 py-3">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <label for="page" class="text-sm text-gray-700 dark:text-gray-300">Voorbeeldpagina</label>
                            <select id="page" x-model="page" class="fi-input rounded-md border-gray-300 bg-white py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900">
                                <option value="home">🏠 Home</option>
                                <option value="cart">🛒 Winkelwagen</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="device" class="text-sm text-gray-700 dark:text-gray-300">Device</label>
                            <select id="device" x-model="device" class="fi-input rounded-md border-gray-300 bg-white py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900">
                                <option value="desktop">🖥️ Desktop</option>
                                <option value="tablet">📱 Tablet</option>
                                <option value="mobile">📱 Mobile</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" x-model="allowClicks" class="rounded border-gray-300 dark:border-gray-700">
                            Klikken toestaan
                        </label>

                        <x-filament::button color="gray" size="sm" icon="heroicon-o-arrow-path" x-on:click="reloadPreview()">
                            Vernieuwen
                        </x-filament::button>

                        <x-filament::button color="gray" size="sm" icon="heroicon-o-arrow-top-right-on-square"
                           x-bind:href="pages[page]" target="_blank" tag="a">
                            Open pagina
                        </x-filament::button>
                    </div>
                </div>
            </div>

            <!-- Your Filament form -->
            <form wire:submit="save" class="space-y-4">
                {{ $this->form }}

                <div class="flex items-center gap-3">
                    <x-filament::button type="submit" size="lg" icon="heroicon-o-check">
                        Wijzigingen Opslaan
                    </x-filament::button>

                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Tip: klik “Vernieuwen” in het previewpaneel om direct de wijzigingen te zien.
                    </span>
                </div>
            </form>
        </div>

        <!-- RIGHT: Sticky live preview -->
        <div class="col-span-12 lg:col-span-7">
            <div class="lg:sticky lg:top-20 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-900">
                <!-- Preview header -->
                <div class="flex items-center justify-between px-4 py-2 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span class="text-xs text-gray-600 dark:text-gray-300" x-text="pages[page]"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Preview</span>
                        <button type="button" title="Vernieuwen"
                                class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline"
                                x-on:click="reloadPreview()">
                            Vernieuwen
                        </button>
                    </div>
                </div>

                <!-- Preview stage -->
                <div class="bg-gray-50 dark:bg-gray-900 px-4 py-4">
                    <div class="mx-auto bg-white dark:bg-gray-950 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 rounded-lg overflow-hidden"
                         :style="'width:' + deviceWidth() + ';'">
                        <iframe
                            id="site-preview-iframe"
                            :src="pages[page]"
                            class="w-full h-[720px] border-0"
                            :style="allowClicks ? '' : 'pointer-events: none;'"
                            title="Webshop voorbeeld">
                        </iframe>
                    </div>

                    <!-- Device hints -->
                    <div class="mt-2 flex items-center justify-between text-[11px] text-gray-500 dark:text-gray-400">
                        <div x-show="device === 'desktop'">Desktop breedte (volledig)</div>
                        <div x-show="device === 'tablet'">Tablet breedte ≈ 768px</div>
                        <div x-show="device === 'mobile'">Mobiele breedte ≈ 390px</div>
                        <div class="hidden sm:block">Klikken: <span x-text="allowClicks ? 'aan' : 'uit'"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh preview after Livewire save()
        window.addEventListener('site-settings-saved', () => {
            const f = document.getElementById('site-preview-iframe');
            if (f) f.src = f.src;
        });
    </script>
</x-filament-panels::page>