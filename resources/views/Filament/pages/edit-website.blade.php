<x-filament-panels::page>
    <div class="max-w-2xl mx-auto py-8">
        <x-filament::section>
            <x-slot name="heading">
                <span class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-pencil-square" class="h-5 w-5 text-primary-500" />
                    Frontend bewerken
                </span>
            </x-slot>
            <x-slot name="description">
                Klik op de knop hieronder. Je komt op de echte website met de bewerkbalk bovenin.
            </x-slot>

            <x-filament::button
                tag="a"
                href="{{ route('home', ['preview' => 'true']) }}"
                icon="heroicon-o-arrow-top-right-on-square"
                size="lg"
                color="primary"
                class="w-full justify-center"
            >
                Open website in bewerkmodus
            </x-filament::button>
        </x-filament::section>
    </div>
</x-filament-panels::page>