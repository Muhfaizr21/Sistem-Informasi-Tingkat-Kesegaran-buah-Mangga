<x-guest-layout>
    <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--leaf-dark); margin-bottom: 8px;">Selamat Datang Kembali</h2>
    <p class="text-[0.9rem] mb-9" style="color: var(--text-light);">Silakan masuk ke akun SI-Mangga Anda.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-5">
            <label for="email" class="block text-[0.72rem] font-bold uppercase tracking-[0.12em] mb-2" style="color: var(--text-mid);">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="nama@email.com"
                class="w-full py-3.5 px-4 rounded-lg text-[0.9rem] outline-none transition-all duration-200"
                style="border: 1.5px solid rgba(212,160,23,0.3); background: white; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark);"
                onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(212,160,23,0.12)';"
                onblur="this.style.borderColor='rgba(212,160,23,0.3)'; this.style.boxShadow='none';">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-[0.72rem] font-bold uppercase tracking-[0.12em] mb-2" style="color: var(--text-mid);">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••"
                class="w-full py-3.5 px-4 rounded-lg text-[0.9rem] outline-none transition-all duration-200"
                style="border: 1.5px solid rgba(212,160,23,0.3); background: white; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark);"
                onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(212,160,23,0.12)';"
                onblur="this.style.borderColor='rgba(212,160,23,0.3)'; this.style.boxShadow='none';">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-between mb-5">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded" style="accent-color: var(--mango-green);">
                <span class="text-[0.82rem]" style="color: var(--text-light);">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-[0.82rem] font-semibold no-underline transition-colors hover:text-[#E8821A]" style="color: var(--gold);">Lupa password?</a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full py-4 rounded-lg font-bold text-base text-white cursor-pointer transition-all duration-300 hover:-translate-y-0.5"
            style="background: var(--leaf-dark); font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: 0.02em; border: none;"
            onmouseover="this.style.background='var(--mango-green)'; this.style.boxShadow='0 8px 24px rgba(74,124,63,0.3)';"
            onmouseout="this.style.background='var(--leaf-dark)'; this.style.boxShadow='none';">
            Masuk Sekarang
        </button>

        <!-- Divider -->
        <div class="relative text-center my-6">
            <span class="relative z-10 px-4 text-[0.75rem]" style="color: var(--text-light); background: var(--cream);">atau</span>
            <div class="absolute top-1/2 left-0 right-0 h-px" style="background: rgba(212,160,23,0.2);"></div>
        </div>

        <!-- Register link -->
        @if (Route::has('register'))
            <div class="text-center text-[0.85rem]" style="color: var(--text-light);">
                Belum punya akun? <a href="{{ route('register') }}" class="font-bold no-underline transition-colors hover:text-[#E8821A]" style="color: var(--gold);">Daftar di sini</a>
            </div>
        @endif
    </form>
</x-guest-layout>
