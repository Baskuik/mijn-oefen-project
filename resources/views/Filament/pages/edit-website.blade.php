<div
    data-pages=@json($this->previewPages)
    x-data={
        page: $wire.entangle("page").live,
        device: "desktop",
        allowClicks: false,
        scale: 1,
        iframeHeight: 900,
        pages: {},

        nativeWidth() {
            if (this.device === "mobile") return 390
            if (this.device === "tablet") return 768
            return 1280
        },
        computeScale() {
            const el = document.getElementById("preview-stage")
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
                const el = document.getElementById("preview-stage")
                if (el) {
                    const obs = new ResizeObserver(() => this.computeScale())
                    obs.observe(el)
                }
            })

            this.$watch("page", () => this.reloadPreview())

            window.addEventListener("site-settings-saved", () => this.reloadPreview())
            window.addEventListener("preview-pages-refreshed", (e) => {
                const incoming = e?.detail?.pages || {}
                const keep = this.page
                this.pages = incoming
                const ks = Object.keys(this.pages || {})
                this.page = (keep && this.pages[keep]) ? keep : (ks[0] || "")
                this.reloadPreview()
            })
        },
    }
    x-init="init()"
    class="block"
>
    <div class="sticky top-0 z-20 border-b border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 shadow-sm fi-header">
        <div class="flex items-center justify-between gap-3 px-4 py-3">
            <div class="flex items-center gap-2 text-sm font-semibold text-gray-950 dark:text-white">
                <x-filament::icon icon="heroicon-o-pencil-square" class="h-5 w-5" />
                <span>Website bewerken</span>
            </div>

            <div class="flex items-center gap-2">
                <x-filament::button color="gray" icon="heroicon-o-arrow-path" x-on:click="reloadPreview()">
                    Vernieuwen
                </x-filament::button>

                <x-filament::button color="gray" tag="a" target="_blank" icon="heroicon-o-arrow-top-right-on-square" x-bind:href="pages[page] || #">
                    Openen
                </x-filament::button>

                <x-filament::button type="submit" form="edit-website-form" color="primary" icon="heroicon-o-check" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">Opslaan</span>
                    <span wire:loading wire:target="save">Opslaan…</span>
                </x-filament::button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 px-4 py-4">
        <div class="col-span-12 xl:col-span-5">
            <x-filament::section>
                <form id="edit-website-form" wire:submit="save">
                    <div class="fi-section-content">
                        {{ $this->form }}
                    </div>

                    <div class="fi-section-footer">
                        <x-filament::button type="submit" color="primary" icon="heroicon-o-check" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.remove wire:target="save">Wijzigingen opslaan</span>
                            <span wire:loading wire:target="save">Opslaan…</span>
                        </x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>

        <div class="col-span-12 xl:col-span-7">
            <x-filament::section>
                <div class="fi-section-header flex flex-wrap items-center gap-3">
                    <div class="min-w-[14rem]">
                        <x-filament::input.wrapper for="page-select" inline>
                            <x-slot name="label">
                                <span class="text-xs text-gray-700 dark:text-gray-300">Pagina</span>
                            </x-slot>

                            <x-filament::input.select id="page-select" x-model="page" wire:model.live="page" class="w-full">
                                <template x-for="(url, label) in pages" :key="label">
                                    <option x-bind:value="label" x-text="label"></option>
                                </template>
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                    </div>

                    <div class="ml-auto flex items-center gap-1">
                        <x-filament::icon-button
                            icon="heroicon-o-computer-desktop"
                            label="Desktop"
                            size="sm"
                            color="gray"
                            x-on:click="device = desktop"
                            x-bind:class="device === desktop ? text-primary-600 bg-primary-50 ring-1 ring-primary-600/20 dark:bg-primary-500/10 : "
                        />
                        <x-filament::icon-button
                            icon="heroicon-o-device-tablet"
                            label="Tablet"
                            size="sm"
                            color="gray"
                            x-on:click="device = tablet"
                            x-bind:class="device === tablet ? text-primary-600 bg-primary-50 ring-1 ring-primary-600/20 dark:bg-primary-500/10 : "
                        />
                        <x-filament::icon-button
                            icon="heroicon-o-device-phone-mobile"
                            label="Mobiel"
                            size="sm"
                            color="gray"
                            x-on:click="device = mobile"
                            x-bind:class="device === mobile ? text-primary-600 bg-primary-50 ring-1 ring-primary-600/20 dark:bg-primary-500/10 : "
                        />

                        <x-filament::icon-button icon="heroicon-o-arrow-path" label="Vernieuwen" size="sm" color="gray" x-on:click="reloadPreview()" />
                    </div>
                </div>

                <div class="mt-3 overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">
                    <div class="flex items-center gap-3 border-b border-gray-200 bg-gray-50 px-3 py-2 dark:border-white/10 dark:bg-white/5">
                        <div class="flex shrink-0 items-center gap-1.5">
                            <span class="h-3 w-3 rounded-full bg-red-400"></span>
                            <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                            <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                        </div>

                        <div class="flex-1 truncate text-[11px] text-gray-600 dark:text-gray-400" x-text="pages[page] || "></div>
                    </div>

                    <div id="preview-stage" class="bg-gray-100 p-4 dark:bg-gray-900">
                        <div x-bind:style="height:  + (iframeHeight * scale) + px;">
                            <iframe
                                id="site-preview-iframe"
                                x-bind:src="pages[page] || "
                                x-bind:style="width:  + nativeWidth() + px; height:  + iframeHeight + px; transform: scale( + scale + ); transform-origin: top left; border: 0;"
                                x-bind:class="allowClicks ?  : pointer-events-none"
                                title="Webshop live preview"
                            ></iframe>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-3 py-1.5 text-[11px] text-gray-600 dark:border-white/10 dark:bg-white/5 dark:text-gray-400">
                        <span class="flex items-center gap-2">
                            <span x-show="device === desktop">🖥 Desktop — 1280 px</span>
                            <span x-show="device === tablet">📱 Tablet — 768 px</span>
                            <span x-show="device === mobile">📲 Mobiel — 390 px</span>
                            <span class="text-gray-300 dark:text-gray-600">·</span>
                            <span>schaal <span x-text="Math.round(scale * 100)"></span>%</span>
                        </span>

                        <label class="inline-flex cursor-pointer items-center gap-1.5">
                            <input type="checkbox" x-model="allowClicks" class="h-3.5 w-3.5 rounded border-gray-300 text-primary-600 focus:ring-0 dark:border-white/10">
                            <span>Klikken toestaan</span>
                        </label>
                    </div>
                </div>
            </x-filament::section>
        </div>
    </div>
</div>