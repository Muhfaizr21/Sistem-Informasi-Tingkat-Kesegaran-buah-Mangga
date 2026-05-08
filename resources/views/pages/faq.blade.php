<x-landing-layout>
    <div class="pt-28 pb-20 min-h-screen" style="background: var(--cream);">
        <div class="max-w-4xl mx-auto px-6 sm:px-8">
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2.5 text-[0.72rem] font-bold uppercase tracking-[0.18em] mb-4" style="color: var(--mango-green);">
                    <span class="block w-8 h-[2px]" style="background: var(--gold);"></span>
                    Pertanyaan Umum
                </div>
                <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 2.8rem); color: var(--leaf-dark); line-height: 1.15;">
                    FAQ <span style="color: var(--gold);">(Tanya Jawab)</span>
                </h1>
                <p class="mt-4 text-base" style="color: var(--text-light);">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl border border-[#D4A017]/20 overflow-hidden">
                    <button @click="active === 1 ? active = null : active = 1" class="w-full px-8 py-6 text-left flex justify-between items-center transition-colors hover:bg-[#FFF8E1]">
                        <span style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark);">Apakah aplikasi SI-Mangga berbayar?</span>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" x-collapse>
                        <div class="px-8 pb-6 text-sm leading-relaxed" style="color: var(--text-light);">
                            Saat ini SI-Mangga dapat digunakan secara gratis untuk fitur dasar pendaftaran dan scan kesegaran. Kami menyediakan paket premium untuk analisis data yang lebih mendalam bagi petani skala besar.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl border border-[#D4A017]/20 overflow-hidden">
                    <button @click="active === 2 ? active = null : active = 2" class="w-full px-8 py-6 text-left flex justify-between items-center transition-colors hover:bg-[#FFF8E1]">
                        <span style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark);">Bagaimana cara kerja AI Scanner SI-Mangga?</span>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" x-collapse>
                        <div class="px-8 pb-6 text-sm leading-relaxed" style="color: var(--text-light);">
                            AI Scanner kami menggunakan teknologi Computer Vision yang telah dilatih dengan ribuan dataset mangga Indramayu. Sistem menganalisis tekstur kulit, warna, dan pola permukaan untuk menentukan tingkat kesegaran dan grade buah.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl border border-[#D4A017]/20 overflow-hidden">
                    <button @click="active === 3 ? active = null : active = 3" class="w-full px-8 py-6 text-left flex justify-between items-center transition-colors hover:bg-[#FFF8E1]">
                        <span style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark);">Varietas mangga apa saja yang didukung?</span>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" x-collapse>
                        <div class="px-8 pb-6 text-sm leading-relaxed" style="color: var(--text-light);">
                            Kami mendukung 4 varietas utama khas Indramayu: Gedong Gincu, Harum Manis, Cengkir (Dermayu), dan Manalagi. Setiap varietas memiliki standar penilaian unik yang disesuaikan dengan karakteristiknya.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl border border-[#D4A017]/20 overflow-hidden">
                    <button @click="active === 4 ? active = null : active = 4" class="w-full px-8 py-6 text-left flex justify-between items-center transition-colors hover:bg-[#FFF8E1]">
                        <span style="font-family: 'Lora', serif; font-size: 1.1rem; font-weight: 600; color: var(--leaf-dark);">Apakah saya bisa membeli mangga langsung dari aplikasi?</span>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="active === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 4" x-collapse>
                        <div class="px-8 pb-6 text-sm leading-relaxed" style="color: var(--text-light);">
                            Ya! Melalui fitur Marketplace, pembeli dapat langsung memesan mangga dari petani terdaftar. Kami memastikan kualitas mangga yang dijual telah melalui proses grading digital.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
