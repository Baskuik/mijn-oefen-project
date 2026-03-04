<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Account - MijnShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .password-blur {
            filter: blur(4px);
            user-select: none;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    @include('components.site-navbar')

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Page header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Mijn Account</h1>
            <p class="text-slate-500 mt-1">Beheer je e-mailadres en wachtwoord.</p>
        </div>

        {{-- Success banner --}}
        @if(session('status') === 'email-updated')
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm font-medium">E-mailadres bijgewerkt. Vergeet niet je nieuwe e-mailadres te verifiëren.</p>
            </div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm font-medium">Wachtwoord succesvol bijgewerkt.</p>
            </div>
        @endif

        {{-- ── Email Section ── --}}
        <div x-data="{
                showConfirm: false,
                showEmailForm: false,
                newEmail: ''
             }"
             class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-slate-900">E-mailadres</h2>
            </div>

            <div class="px-6 py-5">
                {{-- Current email --}}
                <div class="mb-4">
                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium mb-1">Huidig e-mailadres</p>
                    <p class="text-slate-800 font-medium text-base">{{ $user->email }}</p>
                </div>

                {{-- Verification status --}}
                <div class="mb-5">
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            E-mail geverifieerd
                        </span>
                    @else
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 text-amber-700 text-sm font-medium rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                E-mail niet geverifieerd
                            </span>
                            {{-- Resend verification --}}
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-800 underline underline-offset-2 transition-colors">
                                    Stuur verificatie e-mail opnieuw
                                </button>
                            </form>
                        </div>
                        @if(session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm text-emerald-600 font-medium">Verificatie e-mail verstuurd!</p>
                        @endif
                    @endif
                </div>

                {{-- Change email button --}}
                <button
                    @click="showConfirm = true"
                    x-show="!showEmailForm"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-700 transition-colors duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    E-mail wijzigen
                </button>

                {{-- Inline email change form (shown after confirm) --}}
                <div x-show="showEmailForm" x-transition>
                    <form method="POST" action="{{ route('account.email.update') }}" class="mt-2 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Nieuw e-mailadres
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autofocus
                                autocomplete="email"
                                x-model="newEmail"
                                placeholder="{{ $user->email }}"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all duration-200 text-sm"
                            >
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-700 transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Opslaan
                            </button>
                            <button
                                type="button"
                                @click="showEmailForm = false; newEmail = ''"
                                class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors"
                            >
                                Annuleren
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── Confirmation modal ── --}}
            <div
                x-show="showConfirm"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
                style="display: none;"
            >
                <div
                    x-show="showConfirm"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="showConfirm = false"
                    class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8"
                >
                    <div class="flex items-center justify-center w-14 h-14 bg-amber-50 rounded-full mx-auto mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 text-center mb-3">E-mailadres wijzigen?</h3>
                    <p class="text-slate-500 text-center text-sm leading-relaxed mb-8">
                        Weet je zeker dat je je e-mailadres wilt wijzigen?<br>
                        Je moet je nieuwe e-mailadres opnieuw verifiëren.
                    </p>
                    <div class="flex gap-3">
                        <button
                            @click="showConfirm = false"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors duration-200"
                        >
                            Annuleren
                        </button>
                        <button
                            @click="showConfirm = false; showEmailForm = true"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors duration-200"
                        >
                            Ja, wijzigen
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Password Section ── --}}
        <div x-data="{ showPasswordForm: false }"
             class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-slate-900">Wachtwoord</h2>
            </div>

            <div class="px-6 py-5">

                {{-- Blurred password display --}}
                <div class="mb-5" x-show="!showPasswordForm">
                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium mb-2">Huidig wachtwoord</p>
                    <div class="flex items-center gap-3">
                        <input
                            type="text"
                            value="••••••••••••"
                            readonly
                            class="password-blur px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm w-48 select-none"
                            tabindex="-1"
                            aria-hidden="true"
                        >
                        <span class="text-xs text-slate-400 italic">Verborgen om veiligheidsredenen</span>
                    </div>
                </div>

                {{-- Toggle button --}}
                <button
                    x-show="!showPasswordForm"
                    @click="showPasswordForm = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-700 transition-colors duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Wachtwoord wijzigen
                </button>

                {{-- Change password form --}}
                <div x-show="showPasswordForm" x-transition>
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Huidig wachtwoord
                            </label>
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all duration-200 text-sm"
                            >
                            @error('current_password', 'updatePassword')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Nieuw wachtwoord
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all duration-200 text-sm"
                            >
                            @error('password', 'updatePassword')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Bevestig nieuw wachtwoord
                            </label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-all duration-200 text-sm"
                            >
                        </div>

                        <div class="flex items-center gap-3 pt-1">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-700 transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Opslaan
                            </button>
                            <button
                                type="button"
                                @click="showPasswordForm = false"
                                class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors"
                            >
                                Annuleren
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Back link --}}
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                ← Terug naar de shop
            </a>
        </div>

    </div>

    @livewireScripts
</body>
</html>