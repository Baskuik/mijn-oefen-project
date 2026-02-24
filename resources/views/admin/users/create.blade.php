<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nieuwe Gebruiker Toevoegen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Naam</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-lg focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-lg focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Wachtwoord</label>
                        <input type="password" name="password" class="w-full border-gray-300 rounded-lg focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Wachtwoord Bevestigen</label>
                        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg focus:ring-blue-500" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Rol</label>
                        <select name="is_admin" class="w-full border-gray-300 rounded-lg">
                            <option value="0">Normale Gebruiker</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>

                    <div class="flex items-center">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                            Gebruiker Opslaan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600 hover:underline">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>