<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Konfirmasi Keamanan</h2>
        <p class="text-sm text-gray-500 dark:text-[#A1A09A] mt-1">
            Ini adalah area aman. Silakan konfirmasi password Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Konfirmasi Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
