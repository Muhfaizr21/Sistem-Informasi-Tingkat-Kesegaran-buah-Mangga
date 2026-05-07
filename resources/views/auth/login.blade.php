<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 dark:text-[#A1A09A] mt-1">Silakan masuk ke akun SI-Mangga Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5 ml-1">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-[#FFB800] hover:underline" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] text-[#FFB800] shadow-sm focus:ring-[#FFB800] transition-all cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Masuk Sekarang') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-semibold text-[#FFB800] hover:underline">
                        Daftar di sini
                    </a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
