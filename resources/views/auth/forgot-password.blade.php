<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Lupa Password?</h2>
        <p class="text-sm text-gray-500 dark:text-[#A1A09A] mt-1">
            Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Kirim Tautan Reset') }}
            </x-primary-button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-[#FFB800] hover:underline">
                Kembali ke halaman Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
