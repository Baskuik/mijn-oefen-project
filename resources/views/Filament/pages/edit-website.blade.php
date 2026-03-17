<div
    data-pages='@json($this->previewPages)'
    x-data='{
        page: "",
        device: "desktop",
        allowClicks: false,
        scale: 1,
        iframeHeight: 850,
        pages: {},

        nativeWidth() {
            if (this.device === "mobile") return 390
            if (this.device === "tablet") return 768
            return 1280
        },
        computeScale() {
            const el = document.getElementById("preview-container")
            if (!el) return
            this.scale = Math.min(1, el.offsetWidth / this.nativeWidth())
        },
        reloadPreview() {
            const f = document.getElementById("site-preview-iframe")
            if (f) { const s = f.src; f.src = ""; f.src = s }
        },
        init() {
            this.pages = JSON.parse($el.dataset.pages || "{}")
            const keys = Object.keys(this.pages || {})
            if (keys.length && !this.page) this.page = keys[0]

            this.$nextTick(() => {
                this.computeScale()
                window.addEventListener("resize", () => this.computeScale())
            })

            window.addEventListener("site-settings-saved", () => this.reloadPreview())
            window.addEventListener("preview-pages-refreshed", (e) => {
                this.pages = e?.detail?.pages || {}
                this.reloadPreview()
            })
        },
    }'
    x-init="init()"
    class="fi-resource-edit-record-page"
>
    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-5 flex flex-col gap-6">
            <x-filament::section compact>
                <x-slot name="heading">Website Instellingen</x-slot>
                
                <form id="edit-website-form" wire:submit="save" class="space-y-6">
                    {{ $this->form }}

                    <div class="pt-4 border-t border-gray-100 dark:border-white/5 flex items-center gap-3">
                        <x-filament::button
                            type="submit"
                            icon="heroicon-m-check"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >
                            <span wire:loading.remove wire:target="save">Wijzigingen Opslaan</span>
                            <span wire:loading wire:target="save">Bezig met opslaan...</span>
                        </x-filament::button>
                        
                        <x-filament::icon-button 
                            icon="heroicon-m-arrow-path" 
                            color="gray"
                            wire:click="refreshPages"
                            tooltip="Pagina's scannen"
                        />
                    </div>
                </form>
            </x-filament::section>
        </div>

        <div class="col-span-12 lg:col-span-7">
            <div class="sticky top-24 space-y-4">
                
                <div class="flex flex-wrap items-center justify-between gap-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-white/10 rounded-xl p-2 shadow-sm">
                    <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                        <x-filament::input.wrapper class="w-full">
                            <x-filament::input.select x-model="page" class="border-none shadow-none focus:ring-0">
                                <template x-for="(url, label) in pages" :key="label">
                                    <option x-bind:value="label" x-text="label"></option>
                                </template>
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                        
                        <x-filament::icon-button 
                            icon="heroicon-m-arrow-top-right-on-square" 
                            color="gray" 
                            tag="a" 
                            x-bind:href="pages[page]" 
                            target="_blank" 
                        />
                    </div>

                    <div class="flex items-center gap-1 bg-gray-100 dark:bg-white/5 rounded-lg p-1">
                        <x-filament::icon-button 
                            icon="heroicon-m-computer-desktop" 
                            size="sm"
                            x-on:click="device = 'desktop'"
                            :color="device === 'desktop' ? 'primary' : 'gray'"
                            class="transition"
                        />
                        <x-filament::icon-button 
                            icon="heroicon-m-device-tablet" 
                            size="sm"
                            x-on:click="device = 'tablet'"
                            :color="device === 'tablet' ? 'primary' : 'gray'"
                        />
                        <x-filament::icon-button 
                            icon="heroicon-m-device-phone-mobile" 
                            size="sm"
                            x-on:click="device = 'mobile'"
                            :color="device === 'mobile' ? 'primary' : 'gray'"
                        />
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 shadow-lg bg-white dark:bg-gray-900">
                    <div class="flex items-center gap-3 border-b border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 px-4 py-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-400/80"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400/80"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400/80"></div>
                        </div>
                        <div class="flex-1 px-3 py-1 bg-white dark:bg-gray-800 rounded text-[10px] text-gray-400 truncate border border-gray-200 dark:border-white/5" x-text="pages[page]"></div>
                    </div>

                    <div id="preview-container" class="relative bg-gray-200 dark:bg-black/20 overflow-hidden flex justify-start">
                        <div :style="'height: ' + (iframeHeight * scale) + 'px; transition: all 0.3s ease-in-out;'" class="w-full origin-top-left">
                            <iframe
                                id="site-preview-iframe"
                                :src="pages[page] || ''"
                                :style="'width: ' + nativeWidth() + 'px; height: ' + iframeHeight + 'px; transform: scale(' + scale + '); transform-origin: top left; border: 0;'"
                                :class="allowClicks ? 'pointer-events-auto' : 'pointer-events-none'"
                                class="bg-white shadow-2xl"
                            ></iframe>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-4 py-2 bg-gray-50 dark:bg-white/5 border-t border-gray-200 dark:border-white/10 text-[10px] font-medium text-gray-500">
                        <div class="flex items-center gap-4">
                            <span x-text="device.toUpperCase() + ' — ' + nativeWidth() + 'px'"></span>
                            <span x-text="'Zoom: ' + Math.round(scale * 100) + '%'"></span>
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer hover:text-primary-600 transition">
                            <input type="checkbox" x-model="allowClicks" class="w-3 h-3 rounded border-gray-300 text-primary-600 focus:ring-0">
                            <span>Interactie aan</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>