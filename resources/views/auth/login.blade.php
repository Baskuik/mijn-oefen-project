<x-guest-layout>
    <!-- Heading -->
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Welkom terug</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Log in op je account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-mailadres')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" :value="__('Wachtwoord')" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors"
                       href="{{ route('password.request') }}">
                        {{ __('Wachtwoord vergeten?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox"
                   class="rounded border-slate-300 dark:border-slate-600 text-slate-800 dark:bg-slate-700 shadow-sm focus:ring-slate-500"
                   name="remember">
            <label for="remember_me" class="ms-2 text-sm text-slate-600 dark:text-slate-400">
                {{ __('Onthoud mij') }}
            </label>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-slate-800 dark:bg-slate-600 hover:bg-slate-700 dark:hover:bg-slate-500 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
            {{ __('Inloggen') }}
        </button>
    </form>

    <!-- Register link -->
    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Nog geen account?
        <a href="{{ route('register') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:underline transition-colors">
            Registreer je hier
        </a>
    </p>
</x-guest-layout>