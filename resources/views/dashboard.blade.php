<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <div>
                        {{ __("Hello Everyone!") }}
                    </div>
                    <!-- Display user's profile photo -->
                    @if (Auth::user()->profile_photo)
                        <div class="flex justify-center" >
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="rounded-full  object-cover mt-4" width ="150" height="300" > 
                        </div>
                    @endif
                    <div class="mt-4 text-lg text-red-600">
                        {{ __("Welcome to Laravel") }}
                    </div>
                    <div class="mt-4 text-sm text-gray-900">
                        {{ __("You are logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
