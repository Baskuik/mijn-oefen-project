<div class="p-6 text-gray-900">
    {{ __("Je bent ingelogd!") }}

    @if(auth()->user()->is_admin)
        <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
            <h3 class="font-bold text-lg text-blue-800">Admin Paneel</h3>
            <p class="text-sm text-blue-600 mb-4">Beheer de gebruikers van je Pokémon store.</p>
            
            <a href="{{ route('admin.users.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Naar Gebruikersbeheer
            </a>
        </div>
    @endif
</div>