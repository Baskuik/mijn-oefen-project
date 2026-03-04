<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <!-- Email Section -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="p-6 sm:p-8">
                        <!-- Section Header with Icon -->
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Email Address</h3>
                                <p class="text-sm text-gray-500">Manage your email and verification status</p>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <!-- Current Email Display -->
                            <div>
                                <x-input-label for="current_email" :value="__('Current Email')" class="text-base font-medium" />
                                <div class="mt-2 flex items-center gap-3">
                                    <x-text-input 
                                        id="current_email" 
                                        type="text" 
                                        class="block w-full bg-gray-50 border-gray-300 text-gray-700 font-medium" 
                                        :value="$user->email" 
                                        disabled 
                                    />
                                    
                                    @if ($user->hasVerifiedEmail())
                                        <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            Not Verified
                                        </span>
                                    @endif
                                </div>

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <p class="text-sm font-medium text-yellow-800 mb-3">
                                            Your email address is not verified yet.
                                        </p>
                                        <form method="post" action="{{ route('verification.send') }}">
                                            @csrf
                                            <x-primary-button type="submit" class="bg-yellow-600 hover:bg-yellow-700">
                                                Resend Verification Email
                                            </x-primary-button>
                                        </form>
                                        
                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-3 text-sm font-medium text-green-700 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                A new verification link has been sent!
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Change Email Button -->
                            <div x-data="{ showModal: false, newEmail: '', confirmationEmail: '' }" class="pt-2">
                                <x-secondary-button @click="showModal = true" class="font-semibold">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Change Email Address
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

                                        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <form method="post" action="{{ route('account.email.update') }}">
                                                @csrf
                                                @method('patch')
                                                
                                                <div class="bg-white px-6 pt-6 pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                                                Change Email Address
                                                            </h3>
                                                            <div class="mt-4 space-y-4">
                                                                <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                                                    <p class="text-sm text-yellow-800">
                                                                        ⚠️ You will need to verify your new email address after changing it.
                                                                    </p>
                                                                </div>
                                                                
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
                                                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                                                    <x-primary-button type="submit" class="w-full sm:w-auto">
                                                        Change Email
                                                    </x-primary-button>
                                                    <x-secondary-button 
                                                        type="button" 
                                                        @click="showModal = false; newEmail = ''; confirmationEmail = ''" 
                                                        class="mt-3 w-full sm:mt-0 sm:w-auto">
                                                        Cancel
                                                    </x-secondary-button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (session('status') === 'email-updated')
                                <div class="p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-sm font-medium text-green-800">
                                        Email updated successfully! Please check your new email for the verification link.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="p-6 sm:p-8">
                        <!-- Section Header with Icon -->
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Password</h3>
                                <p class="text-sm text-gray-500">Update your password to keep your account secure</p>
                            </div>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                            @csrf
                            @method('put')

                            <!-- Current Password -->
                            <div>
                                <x-input-label for="current_password" :value="__('Current Password')" class="text-base font-medium" />
                                <x-text-input 
                                    id="current_password" 
                                    name="current_password"
                                    type="password" 
                                    class="mt-2 block w-full" 
                                    autocomplete="current-password"
                                    required 
                                />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <!-- New Password -->
                            <div>
                                <x-input-label for="password" :value="__('New Password')" class="text-base font-medium" />
                                <x-text-input 
                                    id="password" 
                                    name="password"
                                    type="password" 
                                    class="mt-2 block w-full" 
                                    autocomplete="new-password"
                                    required 
                                />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="text-base font-medium" />
                                <x-text-input 
                                    id="password_confirmation" 
                                    name="password_confirmation"
                                    type="password" 
                                    class="mt-2 block w-full" 
                                    autocomplete="new-password"
                                    required 
                                />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Security Note -->
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex gap-3">
                                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-medium mb-1">Password Requirements:</p>
                                        <ul class="list-disc list-inside space-y-1 text-xs">
                                            <li>Minimum 8 characters long</li>
                                            <li>Use a mix of letters, numbers, and symbols</li>
                                            <li>Don't reuse passwords from other accounts</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 pt-2">
                                <x-primary-button class="font-semibold">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Password
                                </x-primary-button>

                                @if (session('status') === 'password-updated')
                                    <p class="text-sm font-medium text-green-600 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Password updated successfully!
                                    </p>
                                @endif    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    [x-cloak] { display: none !important; }
</style>
