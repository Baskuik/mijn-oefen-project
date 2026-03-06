<x-filament-panels::page>
    <div class="space-y-8">

        {{-- ============================================================
             FORMULIER
        ============================================================ --}}
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6 flex items-center gap-4">
                <x-filament::button
                    type="submit"
                    size="lg"
                    icon="heroicon-o-check"
                >
                    💾 Wijzigingen Opslaan
                </x-filament::button>

                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Open homepage
                </a>
            </div>
        </form>

        {{-- ============================================================
             LIVE PREVIEW (iframe)
             De pagina wordt als mini-scherm getoond.
             Na opslaan: refresh de preview via de knop.
        ============================================================ --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg">

            {{-- Header balk van de "nep-browser" --}}
            <div class="flex items-center gap-3 px-4 py-3 bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex gap-1.5">
                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                </div>
                <div class="flex-1 bg-white dark:bg-gray-700 rounded-md px-3 py-1 text-xs text-gray-500 dark:text-gray-400 font-mono">
                    {{ route('home') }}
                </div>
                <button
                    type="button"
                    onclick="document.getElementById('site-preview-iframe').src = document.getElementById('site-preview-iframe').src"
                    class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1"
                    title="Preview vernieuwen"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Vernieuwen
                </button>
            </div>

            {{-- iframe preview --}}
            <div class="relative bg-white" style="height: 600px;">
                <iframe
                    id="site-preview-iframe"
                    src="{{ route('home') }}"
                    class="w-full h-full border-0"
                    style="pointer-events: none; transform-origin: top left;"
                    title="Homepage voorbeeld"
                ></iframe>

                {{-- Overlay zodat admin niet per ongeluk in de iframe klikt --}}
                <div class="absolute inset-0 bg-transparent cursor-default"></div>
            </div>

            <div class="px-4 py-2 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    💡 Sla je wijzigingen op en klik op <strong>Vernieuwen</strong> om de preview te updaten.
                </p>
            </div>
        </div>

    </div>
</x-filament-panels::page>