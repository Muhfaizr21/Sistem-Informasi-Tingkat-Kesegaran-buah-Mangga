<x-landing-layout>
    <div class="pt-28 pb-20 min-h-screen" style="background: var(--cream);">
        <div class="max-w-4xl mx-auto px-6 sm:px-8">
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2.5 text-[0.72rem] font-bold uppercase tracking-[0.18em] mb-4" style="color: var(--mango-green);">
                    <span class="block w-8 h-[2px]" style="background: var(--gold);"></span>
                    Panduan
                </div>
                <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 2.8rem); color: var(--leaf-dark); line-height: 1.15;">
                    Panduan <span style="color: var(--gold);">Pengguna</span>
                </h1>
                <p class="mt-4 text-base" style="color: var(--text-light);">Pelajari cara menggunakan SI-Mangga dengan mudah</p>
            </div>

            <div class="space-y-6">
                <!-- Step 1 -->
                <div class="bg-white rounded-2xl p-8 border border-[#D4A017]/20 flex gap-6 items-start">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; color: var(--leaf-dark);">1</div>
                    <div>
                        <h3 style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark); margin-bottom: 8px;">Daftar Akun</h3>
                        <p class="text-sm leading-relaxed" style="color: var(--text-light);">Kunjungi halaman <a href="{{ route('register') }}" class="font-semibold no-underline" style="color: var(--gold);">Daftar</a> dan buat akun sebagai Petani atau Pembeli. Isi data diri Anda dengan lengkap.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white rounded-2xl p-8 border border-[#D4A017]/20 flex gap-6 items-start">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; color: var(--leaf-dark);">2</div>
                    <div>
                        <h3 style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark); margin-bottom: 8px;">Masuk ke Dashboard</h3>
                        <p class="text-sm leading-relaxed" style="color: var(--text-light);">Setelah mendaftar, masuk ke akun Anda melalui halaman <a href="{{ route('login') }}" class="font-semibold no-underline" style="color: var(--gold);">Login</a>. Anda akan diarahkan ke dashboard sesuai peran Anda.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-2xl p-8 border border-[#D4A017]/20 flex gap-6 items-start">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; color: var(--leaf-dark);">3</div>
                    <div>
                        <h3 style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark); margin-bottom: 8px;">Gunakan Fitur AI Scanner</h3>
                        <p class="text-sm leading-relaxed" style="color: var(--text-light);">Ambil foto mangga Anda menggunakan kamera smartphone. Sistem AI kami akan menganalisis kesegaran, warna, tekstur, dan memberikan grade kualitas secara otomatis dalam hitungan detik.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-white rounded-2xl p-8 border border-[#D4A017]/20 flex gap-6 items-start">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; color: var(--leaf-dark);">4</div>
                    <div>
                        <h3 style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark); margin-bottom: 8px;">Jual atau Beli di Marketplace</h3>
                        <p class="text-sm leading-relaxed" style="color: var(--text-light);">Petani dapat langsung menjual hasil panen yang sudah di-grading melalui marketplace terintegrasi. Pembeli dapat menelusuri katalog, melihat profil petani, dan melakukan pemesanan dengan aman.</p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="bg-white rounded-2xl p-8 border border-[#D4A017]/20 flex gap-6 items-start">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0" style="background: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; color: var(--leaf-dark);">5</div>
                    <div>
                        <h3 style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark); margin-bottom: 8px;">Pantau Analitik</h3>
                        <p class="text-sm leading-relaxed" style="color: var(--text-light);">Gunakan dashboard analitik untuk memantau tren panen, kualitas rata-rata, dan statistik penjualan. Data historis membantu Anda membuat keputusan yang lebih baik untuk musim panen berikutnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
