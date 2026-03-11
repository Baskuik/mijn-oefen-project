<x-filament-panels::page>
    <div
        x-data="{
            page: 'home',
            allowClicks: false,
            pages: {
                home: '{{ url('/') }}',
                cart: '{{ url('/cart') }}'
            },
            reloadPreview() {
                const f = document.getElementById('site-preview-iframe');
                if (f) f.src = f.src;
            }
        }"
        class="grid grid-cols-12 gap-6"
    >
        <!-- Linkerkolom: Formulier -->
        <div class="col-span-12 lg:col-span-5 space-y-4">
            <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/50 px-4 py-3">
                <div class="flex items-center gap-2">
                    <label for="page" class="text-sm text-gray-600 dark:text-gray-300">Voorbeeldpagina</label>
                    <select id="page" x-model="page" class="fi-input block rounded-md border-gray-300 bg-white py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900">
                        <option value="home">🏠 Home</option>
                        <option value="cart">🛒 Winkelwagen</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-1 text-sm text-gray-600 dark:text-gray-300">
                        <input type="checkbox" x-model="allowClicks" class="rounded border-gray-300 dark:border-gray-700">
                        Klikken toestaan
                    </label>

                    <x-filament::button color="gray" size="sm" icon="heroicon-o-arrow-path" @click="reloadPreview()">
                        Vernieuwen
                    </x-filament::button>

                    <x-filament::button color="gray" size="sm" icon="heroicon-o-arrow-top-right-on-square"
                        x-bind:href="pages[page]" target="_blank" tag="a">
                        Open pagina
                    </x-filament::button>
                </div>
            </div>

            <form wire:submit="save" class="space-y-4">
                {{ $this->form }}

                <div class="flex items-center gap-3">
                    <x-filament::button type="submit" size="lg" icon="heroicon-o-check">
                        Wijzigingen Opslaan
                    </x-filament::button>
                </div>
            </form>
        </div>

        <!-- Rechterkolom: Sticky preview -->
        <div class="col-span-12 lg:col-span-7">
            <div class="lg:sticky lg:top-20 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-900">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                    <div class="text-xs text-gray-600 dark:text-gray-300">
                        <span x-text="pages[page]"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Preview</span>
                        <button type="button" title="Vernieuwen"
                                class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline"
                                @click="reloadPreview()">
                            Vernieuwen
                        </button>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900" style="height: 720px;">
                    <iframe
                        id="site-preview-iframe"
                        :src="pages[page]"
                        class="w-full h-full border-0 transition-opacity"
                        :style="allowClicks ? '' : 'pointer-events: none;'"
                        title="Webshop voorbeeld"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh de preview na opslaan in Livewire
        document.addEventListener('livewire:init', () => {
            window.addEventListener('site-settings-saved', () => {
                const f = document.getElementById('site-preview-iframe');
                if (f) f.src = f.src;
            });
        });
    </script>
</x-filament-panels::page>