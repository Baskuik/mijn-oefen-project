<div
    data-pages='@json($this->previewPages)'
    x-data='{
        page: $wire.entangle("page").live,
        device: "desktop",
        allowClicks: false,
        scale: 1,
        iframeHeight: 900,
        pages: {},
        unsaved: false,
        loading: false,

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
            this.loading = true
            const f = document.getElementById("site-preview-iframe")
            if (f) {
                f.onload = () => { this.loading = false }
                const s = f.src; f.src = ""; f.src = s
            }
        },
        setDevice(d) {
            this.device = d
            this.$nextTick(() => {
                this.computeScale()
                this.reloadPreview()
            })
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

            window.addEventListener("site-settings-changed", () => {
                this.unsaved = true
            })
            window.addEventListener("site-settings-saved", () => {
                this.unsaved = false
                this.reloadPreview()
            })
            window.addEventListener("preview-pages-refreshed", (e) => {
                const incoming = e?.detail?.pages || {}
                const keep = this.page
                this.pages = incoming
                const ks = Object.keys(this.pages || {})
                this.page = (keep && this.pages[keep]) ? keep : (ks[0] || "")
                this.reloadPreview()
            })
        },
    }'
    x-init="init()"
    class="block"
>
    {{-- ── Sticky header ─────────────────────────────────────────────── --}}
    <div class="sticky top-0 z-20 border-b border-gray-200 dark:border-white/10 bg-white/95 dark:bg-gray-900/95 backdrop-blur shadow-sm fi-header">
        <div class="flex items-center justify-between gap-3 px-6 py-3">

            {{-- Titel + unsaved badge --}}
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-primary-500/10 text-primary-600 dark:bg-primary-400/10 dark:text-primary-400">
                    <x-filament::icon icon="heroicon-o-pencil-square" class="h-5 w-5" />
                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-950 dark:text-white leading-tight">Website Control Center</div>
                    <div
                        class="flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400"
                        x-show="unsaved"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        Niet-opgeslagen wijzigingen
                    </div>
                    <div
                        class="text-xs text-gray-400 dark:text-gray-500"
                        x-show="!unsaved"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                    >
                        Beheer en publiceer de inhoud van je webshop
                    </div>
                </div>
            </div>

            {{-- Header actions --}}
            <div class="flex items-center gap-2">
                <x-filament::button
                    color="gray"
                    size="sm"
                    icon="heroicon-o-arrow-path"
                    x-on:click="reloadPreview()"
                >
                    Vernieuwen
                </x-filament::button>

                <x-filament::button
                    color="gray"
                    size="sm"
                    tag="a"
                    target="_blank"
                    icon="heroicon-o-arrow-top-right-on-square"
                    x-bind:href="pages[page] || '#'"
                >
                    Openen
                </x-filament::button>

                <x-filament::button
                    type="submit"
                    form="edit-website-form"
                    color="primary"
                    size="sm"
                    icon="heroicon-o-cloud-arrow-up"
                    wire:loading.attr="disabled"
                    wire:target="save"
                >
                    <span wire:loading.remove wire:target="save">Publiceren</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Opslaan…
                    </span>
                </x-filament::button>
            </div>
        </div>
    </div>

    {{-- ── Hoofd twee-kolommen layout ────────────────────────────────── --}}
    <div class="grid grid-cols-12 gap-6 px-6 py-5">

        {{-- LINKS: Formulier --}}
        <div class="col-span-12 xl:col-span-5">
            <x-filament::section>
                <x-slot name="heading">
                    <span class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-document-text" class="h-4 w-4 text-gray-400" />
                        <span x-text="page || 'Inhoud'"></span>
                    </span>
                </x-slot>

                <form id="edit-website-form" wire:submit="save">
                    <div class="fi-section-content">
                        {{ $this->form }}
                    </div>

                    <div class="mt-4 border-t border-gray-200 dark:border-white/10 pt-4 flex items-center justify-between gap-3">
                        {{-- Status indicator --}}
                        <span
                            class="flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400"
                            x-show="unsaved"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                        >
                            <x-filament::icon icon="heroicon-o-exclamation-triangle" class="h-3.5 w-3.5" />
                            Niet-opgeslagen wijzigingen
                        </span>
                        <span
                            class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400"
                            x-show="!unsaved"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                        >
                            <x-filament::icon icon="heroicon-o-check-circle" class="h-3.5 w-3.5" />
                            Alles gepubliceerd
                        </span>

                        <x-filament::button
                            type="submit"
                            color="primary"
                            icon="heroicon-o-cloud-arrow-up"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >
                            <span wire:loading.remove wire:target="save">Wijzigingen publiceren</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                </svg>
                                Opslaan…
                            </span>
                        </x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>

        {{-- RECHTS: Live preview --}}
        <div class="col-span-12 xl:col-span-7">
            <div class="sticky top-16">
                <x-filament::section>

                    {{-- Preview toolbar --}}
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <div class="min-w-[12rem] flex-1">
                            <x-filament::input.wrapper>
                                <x-filament::input.select x-model="page" wire:model.live="page" class="w-full">
                                    <template x-for="(url, label) in pages" :key="label">
                                        <option x-bind:value="label" x-text="label"></option>
                                    </template>
                                </x-filament::input.select>
                            </x-filament::input.wrapper>
                        </div>

                        {{-- Device + refresh pill --}}
                        <div class="ml-auto flex items-center gap-1 rounded-lg border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 p-1">
                            <x-filament::icon-button
                                icon="heroicon-o-computer-desktop"
                                label="Desktop"
                                size="sm"
                                color="gray"
                                x-on:click="setDevice('desktop')"
                                x-bind:class="device === 'desktop' ? 'bg-white dark:bg-white/10 shadow-sm text-primary-600 dark:text-primary-400 ring-1 ring-gray-200 dark:ring-white/10' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                            />
                            <x-filament::icon-button
                                icon="heroicon-o-device-tablet"
                                label="Tablet"
                                size="sm"
                                color="gray"
                                x-on:click="setDevice('tablet')"
                                x-bind:class="device === 'tablet' ? 'bg-white dark:bg-white/10 shadow-sm text-primary-600 dark:text-primary-400 ring-1 ring-gray-200 dark:ring-white/10' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                            />
                            <x-filament::icon-button
                                icon="heroicon-o-device-phone-mobile"
                                label="Mobiel"
                                size="sm"
                                color="gray"
                                x-on:click="setDevice('mobile')"
                                x-bind:class="device === 'mobile' ? 'bg-white dark:bg-white/10 shadow-sm text-primary-600 dark:text-primary-400 ring-1 ring-gray-200 dark:ring-white/10' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                            />
                            <div class="mx-1 h-4 w-px bg-gray-200 dark:bg-white/10"></div>
                            <x-filament::icon-button
                                icon="heroicon-o-arrow-path"
                                label="Vernieuwen"
                                size="sm"
                                color="gray"
                                x-on:click="reloadPreview()"
                            />
                        </div>
                    </div>

                    {{-- Browser chrome --}}
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 shadow-sm">

                        {{-- Title bar --}}
                        <div class="flex items-center gap-3 border-b border-gray-200 bg-gray-50 px-4 py-2.5 dark:border-white/10 dark:bg-white/5">
                            <div class="flex shrink-0 items-center gap-1.5">
                                <span class="h-3 w-3 rounded-full bg-red-400 transition-opacity hover:opacity-75"></span>
                                <span class="h-3 w-3 rounded-full bg-amber-400 transition-opacity hover:opacity-75"></span>
                                <span class="h-3 w-3 rounded-full bg-emerald-400 transition-opacity hover:opacity-75"></span>
                            </div>

                            <div class="flex flex-1 items-center gap-2 rounded-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 px-2.5 py-1">
                                <x-filament::icon icon="heroicon-o-lock-closed" class="h-3 w-3 shrink-0 text-emerald-500" />
                                <span
                                    class="flex-1 truncate font-mono text-[11px] text-gray-500 dark:text-gray-400"
                                    x-text="pages[page] || ''"
                                ></span>
                            </div>

                            <x-filament::icon-button
                                icon="heroicon-o-arrow-top-right-on-square"
                                label="Openen in nieuw tabblad"
                                size="sm"
                                color="gray"
                                tag="a"
                                target="_blank"
                                x-bind:href="pages[page] || '#'"
                            />
                        </div>

                        {{-- Preview stage --}}
                        <div id="preview-stage" class="relative bg-gray-100 dark:bg-gray-950 p-4">

                            {{-- Loading overlay --}}
                            <div
                                x-show="loading"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="absolute inset-0 z-10 flex items-center justify-center bg-gray-100/80 dark:bg-gray-950/80 backdrop-blur-sm"
                                style="display:none"
                            >
                                <div class="flex items-center gap-2 rounded-full bg-white dark:bg-gray-800 px-4 py-2 shadow-md text-xs text-gray-600 dark:text-gray-300 font-medium">
                                    <svg class="h-3.5 w-3.5 animate-spin text-primary-500" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                    </svg>
                                    Laden…
                                </div>
                            </div>

                            {{-- Unsaved overlay --}}
                            <div
                                x-show="unsaved"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="absolute inset-0 z-10 flex items-center justify-center bg-gray-900/40 backdrop-blur-[2px]"
                                style="display:none"
                            >
                                <div class="flex flex-col items-center gap-3 rounded-2xl bg-white dark:bg-gray-800 px-6 py-5 shadow-xl text-center max-w-xs">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-500/10">
                                        <x-filament::icon icon="heroicon-o-pencil-square" class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Niet-opgeslagen wijzigingen</p>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Publiceer om de preview bij te werken.</p>
                                    </div>
                                </div>
                            </div>

                            <div x-bind:style="'height: ' + (iframeHeight * scale) + 'px;'" class="transition-all duration-300">
                                <iframe
                                    id="site-preview-iframe"
                                    x-bind:src="pages[page] || ''"
                                    x-bind:style="'width: ' + nativeWidth() + 'px; height: ' + iframeHeight + 'px; transform: scale(' + scale + '); transform-origin: top left; border: 0;'"
                                    x-bind:class="allowClicks ? '' : 'pointer-events-none'"
                                    x-on:load="loading = false"
                                    title="Webshop live preview"
                                    class="transition-all duration-300"
                                ></iframe>
                            </div>
                        </div>

                        {{-- Status bar --}}
                        <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-2 dark:border-white/10 dark:bg-white/5">
                            <div class="flex items-center gap-2 text-[11px] text-gray-500 dark:text-gray-400">
                                <span class="flex items-center gap-1.5" x-show="device === 'desktop'" x-transition>
                                    <x-filament::icon icon="heroicon-o-computer-desktop" class="h-3.5 w-3.5" />
                                    Desktop — 1280 px
                                </span>
                                <span class="flex items-center gap-1.5" x-show="device === 'tablet'" x-transition>
                                    <x-filament::icon icon="heroicon-o-device-tablet" class="h-3.5 w-3.5" />
                                    Tablet — 768 px
                                </span>
                                <span class="flex items-center gap-1.5" x-show="device === 'mobile'" x-transition>
                                    <x-filament::icon icon="heroicon-o-device-phone-mobile" class="h-3.5 w-3.5" />
                                    Mobiel — 390 px
                                </span>
                                <span class="text-gray-300 dark:text-gray-600">·</span>
                                <span>Schaal <span x-text="Math.round(scale * 100)"></span>%</span>
                            </div>

                            {{-- Toggle click-through --}}
                            <label class="inline-flex cursor-pointer select-none items-center gap-2 text-[11px] text-gray-500 dark:text-gray-400">
                                <span>Klikken toestaan</span>
                                <button
                                    type="button"
                                    role="switch"
                                    x-on:click="allowClicks = !allowClicks"
                                    x-bind:aria-checked="allowClicks"
                                    x-bind:class="allowClicks ? 'bg-primary-500' : 'bg-gray-200 dark:bg-white/10'"
                                    class="relative inline-flex h-4 w-7 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-1"
                                >
                                    <span
                                        x-bind:class="allowClicks ? 'translate-x-3' : 'translate-x-0'"
                                        class="pointer-events-none inline-block h-3 w-3 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                    ></span>
                                </button>
                            </label>
                        </div>
                    </div>

                </x-filament::section>
            </div>
        </div>
    </div>

    {{-- ── Versiegeschiedenis ─────────────────────────────────────────── --}}
    <div class="px-6 pb-8">
        <x-filament::section>
            <x-slot name="heading">
                <span class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-clock" class="h-4 w-4 text-gray-400" />
                    Versiegeschiedenis
                </span>
            </x-slot>
            <x-slot name="description">
                De laatste 5 opgeslagen versies. Klik op "Herstel" om een versie terug te zetten.
            </x-slot>

            @if(empty($this->histories))
                <div class="flex flex-col items-center justify-center gap-3 py-10 text-center text-sm text-gray-400 dark:text-gray-500">
                    <x-filament::icon icon="heroicon-o-archive-box" class="h-8 w-8 opacity-40" />
                    <span>Nog geen versies opgeslagen. Wijzigingen worden hier bijgehouden nadat je voor het eerst publiceert.</span>
                </div>
            @else
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tijdstip</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pagina</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Opgeslagen door</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Instellingen</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5 bg-white dark:bg-gray-900">
                            @foreach($this->histories as $index => $history)
                                <tr class="{{ $index === 0 ? 'bg-primary-50/40 dark:bg-primary-500/5' : '' }} transition-colors hover:bg-gray-50/60 dark:hover:bg-white/[0.03]">

                                    {{-- Tijdstip --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            @if($index === 0)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-primary-100 dark:bg-primary-500/20 px-2 py-0.5 text-[10px] font-semibold text-primary-700 dark:text-primary-300">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-primary-500 animate-pulse inline-block"></span>
                                                    Huidig
                                                </span>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ \Carbon\Carbon::parse($history['created_at'])->format('d-m-Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($history['created_at'])->format('H:i:s') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Pagina --}}
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1.5 rounded-md bg-gray-100 dark:bg-white/10 px-2 py-1 text-xs font-medium text-gray-700 dark:text-gray-300">
                                            <x-filament::icon icon="heroicon-o-document-text" class="h-3 w-3 opacity-60" />
                                            {{ $history['page_label'] ?: '—' }}
                                        </span>
                                    </td>

                                    {{-- Opgeslagen door --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 dark:bg-white/10 text-gray-500 dark:text-gray-400">
                                                <x-filament::icon icon="heroicon-o-user" class="h-3.5 w-3.5" />
                                            </div>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                {{ $history['editor']['name'] ?? 'Onbekend' }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Aantal instellingen --}}
                                    <td class="px-4 py-3">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ count($history['snapshot']) }} sleutels
                                        </span>
                                    </td>

                                    {{-- Herstel knop --}}
                                    <td class="px-4 py-3 text-right">
                                        @if($index === 0)
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500">
                                                <x-filament::icon icon="heroicon-o-check" class="h-3.5 w-3.5 text-emerald-500" />
                                                Actieve versie
                                            </span>
                                        @else
                                            <x-filament::button
                                                color="gray"
                                                size="sm"
                                                icon="heroicon-o-arrow-uturn-left"
                                                wire:click="rollback({{ $history['id'] }})"
                                                wire:loading.attr="disabled"
                                                wire:target="rollback({{ $history['id'] }})"
                                                wire:confirm="Weet je zeker dat je wilt terugzetten naar {{ \Carbon\Carbon::parse($history['created_at'])->format('d-m-Y H:i') }}? De huidige staat wordt eerst opgeslagen als back-up."
                                            >
                                                Herstel
                                            </x-filament::button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>
    </div>
</div>