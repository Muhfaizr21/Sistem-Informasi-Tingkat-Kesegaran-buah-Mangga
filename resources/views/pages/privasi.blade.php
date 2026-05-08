<x-landing-layout>
    <div class="pt-28 pb-20 min-h-screen" style="background: var(--cream);">
        <div class="max-w-4xl mx-auto px-6 sm:px-8">
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2.5 text-[0.72rem] font-bold uppercase tracking-[0.18em] mb-4" style="color: var(--mango-green);">
                    <span class="block w-8 h-[2px]" style="background: var(--gold);"></span>
                    Kebijakan Keamanan
                </div>
                <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 2.8rem); color: var(--leaf-dark); line-height: 1.15;">
                    Kebijakan <span style="color: var(--gold);">Privasi</span>
                </h1>
                <p class="mt-4 text-base" style="color: var(--text-light);">Terakhir diperbarui: {{ date('d F Y') }}</p>
            </div>

            <div class="bg-white rounded-2xl p-8 sm:p-12 border border-[#D4A017]/20 space-y-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <div class="prose prose-sm max-w-none" style="color: var(--text-light);">
                    <p class="leading-relaxed">
                        Privasi Anda sangat penting bagi SI-Mangga. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat Anda menggunakan layanan kami, baik sebagai pembeli maupun petani.
                    </p>

                    <h3 style="font-family: 'Lora', serif; font-size: 1.2rem; font-weight: 600; color: var(--leaf-dark); margin-top: 2rem; margin-bottom: 1rem;">1. Informasi yang Kami Kumpulkan</h3>
                    <p class="leading-relaxed">
                        Kami mengumpulkan informasi yang Anda berikan secara langsung kepada kami saat Anda mendaftar akun, seperti nama, alamat email, nomor telepon, dan alamat pengiriman. Kami juga mengumpulkan data gambar saat Anda menggunakan fitur Scan AI untuk meningkatkan akurasi model kami.
                    </p>

                    <h3 style="font-family: 'Lora', serif; font-size: 1.2rem; font-weight: 600; color: var(--leaf-dark); margin-top: 2rem; margin-bottom: 1rem;">2. Bagaimana Kami Menggunakan Informasi Anda</h3>
                    <p class="leading-relaxed">
                        Kami menggunakan informasi yang kami kumpulkan untuk:
                    </p>
                    <ul class="list-disc ml-5 space-y-2 mt-2">
                        <li>Memproses pesanan dan pembayaran Anda melalui gateway Midtrans.</li>
                        <li>Meningkatkan akurasi model AI kami (menggunakan gambar yang diunggah secara anonim).</li>
                        <li>Mengirimkan pemberitahuan terkait status pesanan dan aktivitas akun.</li>
                        <li>Memberikan dukungan pelanggan yang dipersonalisasi.</li>
                    </ul>

                    <h3 style="font-family: 'Lora', serif; font-size: 1.2rem; font-weight: 600; color: var(--leaf-dark); margin-top: 2rem; margin-bottom: 1rem;">3. Keamanan Data</h3>
                    <p class="leading-relaxed">
                        Kami menerapkan standar keamanan enkripsi SSL untuk melindungi informasi pribadi Anda dari akses yang tidak sah. Transaksi pembayaran diamankan sepenuhnya melalui gateway pembayaran pihak ketiga yang terverifikasi (Midtrans).
                    </p>

                    <h3 style="font-family: 'Lora', serif; font-size: 1.2rem; font-weight: 600; color: var(--leaf-dark); margin-top: 2rem; margin-bottom: 1rem;">4. Hak Pengguna</h3>
                    <p class="leading-relaxed">
                        Anda memiliki hak untuk mengakses, memperbarui, atau menghapus informasi pribadi Anda di pengaturan profil. Kami tidak akan pernah menjual data pribadi Anda kepada pihak ketiga manapun untuk tujuan pemasaran.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
