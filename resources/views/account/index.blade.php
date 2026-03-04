<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Account - MijnShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .card-animate { opacity: 0; animation: fadeInUp 0.5s ease forwards; }
        .card-animate:nth-child(1) { animation-delay: 0.05s; }
        .card-animate:nth-child(2) { animation-delay: 0.15s; }

        .password-dots {
            letter-spacing: 0.2em;
            font-size: 1.4rem;
            color: #94a3b8;
            line-height: 1;
            user-select: none;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen">

    @include('components.site-navbar')

    {{-- Hero header --}}
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 pt-12 pb-24">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/10 border-2 border-white/20 text-white text-3xl font-bold mb-4 shadow-xl backdrop-blur-sm select-none">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <h1 class="text-3xl font-extrabold text-white mb-1">{{ Auth::user()->name }}</h1>
            <p class="text-slate-300 text-sm">{{ $user->email }}</p>
            <div class="mt-4 flex items-center justify-center gap-4 text-sm">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-1.5 text-indigo-300 hover:text-white transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Mijn Bestellingen
                </a>
                <span class="text-white/20">|</span>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-slate-300 hover:text-white transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Terug naar shop
                </a>
            </div>
        </div>
    </div>

    {{-- Content (overlaps hero) --}}
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 pb-16">

        {{-- Flash banners --}}
        @if(session('status') === 'email-updated')
            <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm font-medium">E-mailadres bijgewerkt. Vergeet niet je nieuwe e-mailadres te verifiëren.</p>
            </div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm font-medium">Wachtwoord succesvol bijgewerkt.</p>
            </div>
        @endif

        {{-- Email card --}}
        <div
            x-data="{
                showConfirm: false,
                showEmailForm: false,
                newEmail: '',
                isVerified: {{ $user->email_verified_at ? 'true' : 'false' }}
            }"
            class="card-animate bg-white rounded-2xl shadow-md border border-slate-200 mb-5 overflow-hidden"
        >
            <div class="flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-indigo-50 to-slate-50 border-b border-slate-100">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">E-mailadres</h2>
                    <p class="text-xs text-slate-400">Beheer je inlogadres</p>
                </div>
            </div>

            <div class="px-6 py-6">
                {{-- Email + verification row --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-0.5">Huidig e-mailadres</p>
                        <p class="text-slate-800 font-semibold">{{ $user->email }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Geverifieerd
                            </span>
                        @else
                            <div class="flex flex-col gap-2 items-start sm:items-end">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 border border-amber-200 text-amber-700 text-xs font-bold rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Niet geverifieerd
                                </span>
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium underline underline-offset-2 transition-colors">
                                        Verificatie opnieuw sturen →
                                    </button>
                                </form>
                                @if(session('status') === 'verification-link-sent')
                                    <p class="text-xs text-emerald-600 font-medium">Verstuurd!</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Button: verified -> showConfirm, else -> form --}}
                <button
                    @click="isVerified ? showConfirm = true : showEmailForm = true"
                    x-show="!showEmailForm"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-200 shadow-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    E-mail wijzigen
                </button>

                {{-- Inline form --}}
                <div
                    x-show="showEmailForm"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <form method="POST" action="{{ route('account.email.update') }}" class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100 space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Nieuw e-mailadres</label>
                            <input id="email" name="email" type="email" required autofocus autocomplete="email"
                                   x-model="newEmail"
                                   placeholder="{{ $user->email }}"
                                   class="w-full px-4 py-2.5 bg-white border border-indigo-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm shadow-sm transition-all duration-200">
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Opslaan
                            </button>
                            <button type="button" @click="showEmailForm = false; newEmail = ''" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
                                Annuleren
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- GROTE bevestigingspopup (alleen bij geverifieerde e‑mail en klik op "E‑mail wijzigen") --}}
            <div
                x-show="showConfirm"
                x-on:keydown.escape.window="showConfirm = false"
                x-init="$watch('showConfirm', v => document.body.classList.toggle('overflow-hidden', v))"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[60] flex items-center justify-center px-6 md:px-10"
                style="display: none;"
            >
                <!-- Donkere overlay met sterke blur -->
                <div class="absolute inset-0 bg-black/70 backdrop-blur-lg" @click="showConfirm = false"></div>

                <!-- Extra grote modal -->
                <div
                    x-show="showConfirm"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                    class="relative z-[61] bg-white rounded-3xl shadow-2xl w-full max-w-3xl md:max-w-4xl xl:max-w-5xl p-8 md:p-12"
                    role="dialog" aria-modal="true"
                >
                    <div class="flex items-start gap-5 md:gap-8">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-amber-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-10 md:w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-2xl md:text-3xl xl:text-4xl font-extrabold text-slate-900 mb-3">E-mailadres wijzigen?</h3>
                            <p class="text-slate-600 text-base md:text-lg leading-relaxed">
                                Weet je het zeker? Je e‑mail is momenteel geverifieerd.
                                Na het wijzigen moet je je nieuwe e‑mailadres opnieuw verifiëren.
                            </p>

                            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                                <button
                                    @click="showConfirm = false"
                                    class="sm:flex-1 px-5 py-3 md:py-4 text-base md:text-lg font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors"
                                >
                                    Annuleren
                                </button>
                                <button
                                    @click="showConfirm = false; showEmailForm = true"
                                    class="sm:flex-1 px-5 py-3 md:py-4 text-base md:text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors"
                                >
                                    Ja, wijzigen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- /GROTE bevestigingspopup --}}
        </div>

        {{-- Password card --}}
        <div x-data="{ showPasswordForm: false, showCurrent: false, showNew: false, showConfirmPw: false }"
             class="card-animate bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

            <div class="flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-100">
                <div class="w-10 h-10 bg-slate-700 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Wachtwoord</h2>
                    <p class="text-xs text-slate-400">Bescherm je account</p>
                </div>
            </div>

            <div class="px-6 py-6">
                <div class="mb-6" x-show="!showPasswordForm">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">Wachtwoord</p>
                            <span class="password-dots">● ● ● ● ● ● ● ●</span>
                        </div>
                        <span class="ml-auto text-xs text-slate-400 bg-slate-200 px-2 py-1 rounded-md font-medium">Verborgen</span>
                    </div>
                </div>

                <button
                    x-show="!showPasswordForm"
                    @click="showPasswordForm = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-xl hover:bg-slate-700 active:scale-95 transition-all duration-200 shadow-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Wachtwoord wijzigen
                </button>

                <div
                    x-show="showPasswordForm"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <form method="POST" action="{{ route('password.update') }}" class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Huidig wachtwoord</label>
                            <div class="relative">
                                <input id="current_password" name="current_password" :type="showCurrent ? 'text' : 'password'" required autocomplete="current-password"
                                       class="w-full px-4 py-2.5 pr-11 bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent text-sm shadow-sm transition-all duration-200">
                                <button type="button" @click="showCurrent = !showCurrent" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!showCurrent" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showCurrent" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password', 'updatePassword')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Nieuw wachtwoord</label>
                            <div class="relative">
                                <input id="password" name="password" :type="showNew ? 'text' : 'password'" required autocomplete="new-password"
                                       class="w-full px-4 py-2.5 pr-11 bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent text-sm shadow-sm transition-all duration-200">
                                <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!showNew" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showNew" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Bevestig nieuw wachtwoord</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" :type="showConfirmPw ? 'text' : 'password'" required autocomplete="new-password"
                                       class="w-full px-4 py-2.5 pr-11 bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent text-sm shadow-sm transition-all duration-200">
                                <button type="button" @click="showConfirmPw = !showConfirmPw" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!showConfirmPw" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showConfirmPw" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268-2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-1">
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 text-white text-sm font-semibold rounded-xl hover:bg-slate-700 active:scale-95 transition-all duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Opslaan
                            </button>
                            <button type="button" @click="showPasswordForm = false" class="px-4 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
                                Annuleren
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @livewireScripts
</body>
</html>