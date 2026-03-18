<x-filament-panels::page>
    <div class="max-w-xl mx-auto py-8">
        <x-filament::section>
            <x-slot name="heading">
                Frontend Editing
            </x-slot>
            <x-slot name="description">
                Open de echte website in bewerkmodus. Je ziet bovenin een toolbar en je kunt teksten direct op de pagina aanpassen.
            </x-slot>

            <x-filament::button
                tag="a"
                href="{{ route('home', ['preview' => 'true']) }}"
                icon="heroicon-o-pencil-square"
                color="primary"
                class="w-full justify-center"
            >
                Website openen in bewerkmodus
            </x-filament::button>
        </x-filament::section>
    </div>
</x-filament-panels::page>