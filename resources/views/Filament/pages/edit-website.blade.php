<x-filament-panels::page>
    <div class="space-y-8">
        <form wire:submit="save" class="space-y-4">
            {{ \->form }}

            <div class="flex items-center gap-3">
                <x-filament::button type="submit" size="lg" icon="heroicon-o-check">
                    Wijzigingen Opslaan
                </x-filament::button>

                <x-filament::button tag="a" href="{{ route('home') }}" target="_blank" color="gray" icon="heroicon-o-arrow-top-right-on-square">
                    Open homepage
                </x-filament::button>
            </div>
        </form>

        <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-2 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                <span class="text-xs text-gray-600 dark:text-gray-300">{{ route('home') }}</span>
                <button
                    type="button"
                    onclick="const f=document.getElementById('site-preview-iframe'); f.src=f.src;"
                    class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline"
                    title="Preview vernieuwen"
                >
                    Vernieuwen
                </button>
            </div>

            <div class="bg-white dark:bg-gray-900" style="height: 600px;">
                <iframe
                    id="site-preview-iframe"
                    src="{{ route('home') }}"
                    class="w-full h-full border-0"
                    style="pointer-events: none;"
                    title="Homepage voorbeeld"
                ></iframe>
            </div>
        </div>
    </div>
</x-filament-panels::page>