<footer id="kontak" class="pt-[70px] pb-8 px-[5%] lg:px-[8%]" style="background: var(--text-dark, #1A1A0F);">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-14">
        <!-- Brand -->
        <div class="sm:col-span-2 lg:col-span-1">
            <div class="w-11 h-11 bg-[#4A7C3F] rounded-full flex items-center justify-center shadow-[0_3px_10px_rgba(74,124,63,0.3)] mb-4 overflow-hidden">
                <img src="/storage/logo/logo.png" class="h-8 w-8 object-contain" alt="Logo" />
            </div>
            <div class="mb-3" style="font-family: 'Playfair Display', serif; font-size: 1.3rem; color: white;">
                SI-<span style="color: #D4A017;">Mangga</span>
            </div>
            <p class="text-[0.82rem] leading-relaxed max-w-[240px]" style="color: rgba(255,255,255,0.4);">
                Sistem Informasi Kesegaran Mangga berbasis AI untuk mendukung petani Indramayu menuju pertanian modern.
            </p>
        </div>

        <!-- Produk -->
        <div>
            <h4 class="text-[0.72rem] font-bold uppercase tracking-[0.15em] mb-4" style="color: #D4A017;">Produk</h4>
            <ul class="space-y-2.5 list-none m-0 p-0">
                <li><a href="{{ route('fitur.deteksi-kualitas') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Deteksi Kualitas</a></li>
                <li><a href="{{ route('fitur.analitik-panen') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Analitik Panen</a></li>
                <li><a href="{{ route('fitur.marketplace') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Marketplace</a></li>
            </ul>
        </div>

        <!-- Dukungan -->
        <div>
            <h4 class="text-[0.72rem] font-bold uppercase tracking-[0.15em] mb-4" style="color: #D4A017;">Dukungan</h4>
            <ul class="space-y-2.5 list-none m-0 p-0">
                <li><a href="{{ route('panduan') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Panduan Pengguna</a></li>
                <li><a href="{{ route('faq') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">FAQ</a></li>
                <li><a href="{{ route('kontak') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Kontak Kami</a></li>
            </ul>
        </div>

        <!-- Tentang -->
        <div>
            <h4 class="text-[0.72rem] font-bold uppercase tracking-[0.15em] mb-4" style="color: #D4A017;">Tentang</h4>
            <ul class="space-y-2.5 list-none m-0 p-0">
                <li><a href="{{ route('tentang-kami') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Tentang Kami</a></li>
                <li><a href="{{ route('privasi') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Kebijakan Privasi</a></li>
                <li><a href="{{ route('syarat') }}" class="text-[0.82rem] no-underline transition-colors hover:text-[#D4A017]" style="color: rgba(255,255,255,0.45);">Syarat & Ketentuan</a></li>
            </ul>
        </div>
    </div>

    <!-- Bottom -->
    <div class="border-t pt-7 flex flex-col sm:flex-row justify-between items-center gap-4" style="border-color: rgba(255,255,255,0.08);">
        <span class="text-[0.78rem]" style="color: rgba(255,255,255,0.3);">© {{ date('Y') }} SI-Mangga · Indramayu, Jawa Barat · All rights reserved.</span>
        <div class="flex gap-3">
            <span class="px-3.5 py-1 rounded-full text-[0.68rem] font-semibold uppercase tracking-[0.1em] border" style="border-color: rgba(212,160,23,0.3); color: rgba(212,160,23,0.6);">Computer Vision</span>
            <span class="px-3.5 py-1 rounded-full text-[0.68rem] font-semibold uppercase tracking-[0.1em] border" style="border-color: rgba(212,160,23,0.3); color: rgba(212,160,23,0.6);">Big Data</span>
            <span class="px-3.5 py-1 rounded-full text-[0.68rem] font-semibold uppercase tracking-[0.1em] border" style="border-color: rgba(212,160,23,0.3); color: rgba(212,160,23,0.6);">Indramayu 🥭</span>
        </div>
    </div>
</footer>
