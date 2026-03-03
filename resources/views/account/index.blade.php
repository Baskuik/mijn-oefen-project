<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Email Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Email Address') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('View and manage your email address.') }}
                            </p>
                        </header>

                        <div class="mt-6 space-y-6">
                            <!-- Current Email Display -->
                            <div>
                                <x-input-label for="current_email" :value="__('Current Email')" />
                                <div class="mt-1 flex items-center gap-3">
                                    <x-text-input id="current_email" type="text" class="block w-full bg-gray-50" :value="$user->email" disabled />
                                    
                                    @if ($user->hasVerifiedEmail())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('Verified') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('Not Verified') }}
                                        </span>
                                        @endif
                                </div>

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">
                                            {{ __('Your email address is unverified.') }}
                                        </p>
                                        <form method="post" action="{{ route('verification.send') }}" class="mt-2">
                                            @csrf
                                            <x-primary-button type="submit">
                                                {{ __('Resend Verification Email') }}
                                            </x-primary-button>
                                        </form>
                                        
                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Change Email Button -->
                            <div x-data="{ showModal: false, newEmail: '', confirmationEmail: '' }">
                                <x-secondary-button @click="showModal = true">
                                    {{ __('Change Email Address') }}
                                </x-secondary-button>

                                <!-- Email Change Modal -->
                                <div x-show="showModal" 
                                     x-cloak
                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                     aria-labelledby="modal-title" 
                                     role="dialog" 
                                     aria-modal="true"
                                     @keydown.escape.window="showModal = false">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                             @click="showModal = false"></div>

                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <form method="post" action="{{ route('account.email.update') }}">
                                                @csrf
                                                @method('patch')
                                                
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                                {{ __('Change Email Address') }}
                                                            </h3>
                                                            <div class="mt-4 space-y-4">
                                                                <p class="text-sm text-gray-500">
                                                                    {{ __('Are you sure you want to change your email? This means you will have to verify your email again.') }}
                                                                </p>
                                                                
                                                                <div>
                                                                    <x-input-label for="email" :value="__('New Email Address')" />
                                                                    <x-text-input 
                                                                        id="email" 
                                                                        name="email" 
                                                                        type="email" 
                                                                        class="mt-1 block w-full" 
                                                                        x-model="newEmail"
                                                                        required 
                                                                    />
                                                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                                                </div>

                                                                <div>
                                                                    <x-input-label for="email_confirmation" :value="__('Confirm New Email')" />
                                                                    <x-text-input 
                                                                        id="email_confirmation" 
                                                                        name="email_confirmation" 
                                                                        type="email" 
                                                                        class="mt-1 block w-full"
                                                                        x-model="confirmationEmail"
                                                                        required 
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <x-primary-button type="submit" class="w-full sm:w-auto sm:ml-3">
                                                        {{ __('Change Email') }}
                                                    </x-primary-button>
                                                    <x-secondary-button 
                                                        type="button" 
                                                        @click="showModal = false; newEmail = ''; confirmationEmail = ''" 
                                                        class="mt-3 w-full sm:mt-0 sm:w-auto">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (session('status') === 'email-updated')
                                <p class="text-sm font-medium text-green-600">
                                    {{ __('Email updated successfully. Please check your new email for verification link.') }}
                                </p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            <!-- Password Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Password') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Manage your account password.') }}
                            </p>
                        </header>

                        <div class="mt-6 space-y-6">
                            <!-- Masked Password Display -->
                            <div>
                                <x-input-label for="password_display" :value="__('Current Password')" />
                                <x-text-input 
                                    id="password_display" 
                                    type="password" 
                                    class="mt-1 block w-full bg-gray-50" 
                                    value="••••••••••••" 
                                    disabled 
                                />
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ __('For security reasons, your password is hidden.') }}
                                </p>
                            </div>

                            <!-- Change Password Button -->
                            <div>
                                <form method="post" action="{{ route('account.password.email') }}">
                                    @csrf
                                    <x-primary-button type="submit">
                                        {{ __('Change Password') }}
                                    </x-primary-button>
                                </form>
                                <p class="mt-2 text-sm text-gray-600">
                                    {{ __('Click the button above to receive an email with instructions to change your password.') }}
                                </p>

                                @if (session('status') === 'password-reset-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('We have emailed you a password reset link!') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    [x-cloak] { display: none !important; }
</style>