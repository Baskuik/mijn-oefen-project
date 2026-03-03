<x-guest-layout>
    <div class="mb-4 text-center">
        <div class="mb-6">
            <svg class="mx-auto h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            {{ __('Email Verified Successfully!') }}
        </h2>
        
        <p class="text-gray-600 mb-8">
            {{ __('You have successfully been verified. You may return to the website.') }}
        </p>

        <div class="flex flex-col space-y-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Go to Dashboard') }}
            </a>
            
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Return to Homepage') }}
            </a>
        </div>
    </div>
</x-guest-layout>