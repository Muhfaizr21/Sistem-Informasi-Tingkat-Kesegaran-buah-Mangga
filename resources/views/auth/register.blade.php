<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 dark:text-[#A1A09A] mt-1">Bergabunglah dengan komunitas petani mangga modern.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Role Selection -->
        <div class="space-y-3 mb-4">
            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 ml-1">Mendaftar Sebagai</label>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative cursor-pointer group">
                    <input type="radio" name="role" value="pembeli" class="peer absolute opacity-0" checked>
                    <div class="flex flex-col items-center p-4 bg-gray-50 dark:bg-[#1b1b18] border-2 border-transparent rounded-2xl peer-checked:border-[#FFB800] peer-checked:bg-orange-50 dark:peer-checked:bg-orange-950/20 transition-all group-hover:bg-gray-100 dark:group-hover:bg-black/40">
                        <svg class="w-8 h-8 mb-2 text-gray-400 peer-checked:text-[#FFB800] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 peer-checked:text-[#FFB800]">Pembeli</span>
                    </div>
                </label>
                <label class="relative cursor-pointer group">
                    <input type="radio" name="role" value="petani" class="peer absolute opacity-0">
                    <div class="flex flex-col items-center p-4 bg-gray-50 dark:bg-[#1b1b18] border-2 border-transparent rounded-2xl peer-checked:border-[#10B981] peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-950/20 transition-all group-hover:bg-gray-100 dark:group-hover:bg-black/40">
                        <svg class="w-8 h-8 mb-2 text-gray-400 peer-checked:text-[#10B981] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 peer-checked:text-[#10B981]">Petani</span>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-1 ml-1" />
        </div>

        <!-- Nama -->
        <div>
            <x-input-label for="nama" :value="__('Nama Lengkap')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
            <x-text-input id="nama" class="block w-full" type="text" name="nama" :value="old('nama')" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('nama')" class="mt-1 ml-1" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5 ml-1" />
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 ml-1" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-semibold text-[#FFB800] hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
