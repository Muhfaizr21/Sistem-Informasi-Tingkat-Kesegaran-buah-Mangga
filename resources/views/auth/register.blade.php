<x-guest-layout>
    <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--leaf-dark); margin-bottom: 8px;">Buat Akun Baru</h2>
    <p class="text-[0.9rem] mb-8" style="color: var(--text-light);">Bergabunglah dengan komunitas petani mangga modern.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Role Selection -->
        <div class="mb-5">
            <label class="block text-[0.72rem] font-bold uppercase tracking-[0.12em] mb-2" style="color: var(--text-mid);">Mendaftar Sebagai</label>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative cursor-pointer group">
                    <input type="radio" name="role" value="pembeli" class="peer absolute opacity-0" checked>
                    <div class="flex flex-col items-center p-4 rounded-xl border-2 border-transparent peer-checked:border-[#D4A017] transition-all group-hover:bg-white/60"
                        style="background: white;">
                        <svg class="w-8 h-8 mb-2 text-gray-400 peer-checked:text-[#D4A017] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest" style="color: var(--text-light);">Pembeli</span>
                    </div>
                </label>
                <label class="relative cursor-pointer group">
                    <input type="radio" name="role" value="petani" class="peer absolute opacity-0">
                    <div class="flex flex-col items-center p-4 rounded-xl border-2 border-transparent peer-checked:border-[#4A7C3F] transition-all group-hover:bg-white/60"
                        style="background: white;">
                        <svg class="w-8 h-8 mb-2 text-gray-400 peer-checked:text-[#4A7C3F] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest" style="color: var(--text-light);">Petani</span>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
        </div>

        <!-- Nama -->
        <div class="mb-5">
            <label for="nama" class="block text-[0.72rem] font-bold uppercase tracking-[0.12em] mb-2" style="color: var(--text-mid);">Nama Lengkap</label>
            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus autocomplete="name"
                placeholder="Masukkan nama lengkap Anda"
                class="w-full py-3.5 px-4 rounded-lg text-[0.9rem] outline-none transition-all duration-200"
                style="border: 1.5px solid rgba(212,160,23,0.3); background: white; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark);"
                onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(212,160,23,0.12)';"
                onblur="this.style.borderColor='rgba(212,160,23,0.3)'; this.style.boxShadow='none';">
            <x-input-error :messages="$errors->get('nama')" class="mt-1" />
        </div>

        <!-- Email -->
        <div class="mb-5">
            <label for="email" class="block text-[0.72rem] font-bold uppercase tracking-[0.12em] mb-2" style="color: var(--text-mid);">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
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
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="w-full py-3.5 px-4 rounded-lg text-[0.9rem] outline-none transition-all duration-200"
                style="border: 1.5px solid rgba(212,160,23,0.3); background: white; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark);"
                onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(212,160,23,0.12)';"
                onblur="this.style.borderColor='rgba(212,160,23,0.3)'; this.style.boxShadow='none';">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-5">
            <label for="password_confirmation" class="block text-[0.72rem] font-bold uppercase tracking-[0.12em] mb-2" style="color: var(--text-mid);">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi password"
                class="w-full py-3.5 px-4 rounded-lg text-[0.9rem] outline-none transition-all duration-200"
                style="border: 1.5px solid rgba(212,160,23,0.3); background: white; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark);"
                onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(212,160,23,0.12)';"
                onblur="this.style.borderColor='rgba(212,160,23,0.3)'; this.style.boxShadow='none';">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full py-4 rounded-lg font-bold text-base text-white cursor-pointer transition-all duration-300 hover:-translate-y-0.5"
            style="background: var(--leaf-dark); font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: 0.02em; border: none;"
            onmouseover="this.style.background='var(--mango-green)'; this.style.boxShadow='0 8px 24px rgba(74,124,63,0.3)';"
            onmouseout="this.style.background='var(--leaf-dark)'; this.style.boxShadow='none';">
            Daftar Sekarang
        </button>

        <!-- Divider -->
        <div class="relative text-center my-6">
            <span class="relative z-10 px-4 text-[0.75rem]" style="color: var(--text-light); background: var(--cream);">atau</span>
            <div class="absolute top-1/2 left-0 right-0 h-px" style="background: rgba(212,160,23,0.2);"></div>
        </div>

        <!-- Login link -->
        <div class="text-center text-[0.85rem]" style="color: var(--text-light);">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-bold no-underline transition-colors hover:text-[#E8821A]" style="color: var(--gold);">Masuk di sini</a>
        </div>
    </form>
</x-guest-layout>
