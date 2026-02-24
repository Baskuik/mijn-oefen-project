<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gebruiker Aanpassen: {{ $user->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Naam</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Rol</label>
                        <select name="is_admin" class="w-full border-gray-300 rounded-lg">
                            <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>Gebruiker</option>
                            <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Opslaan</button>
                    <a href="{{ route('admin.users.index') }}" class="ml-2 text-gray-600">Annuleren</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>