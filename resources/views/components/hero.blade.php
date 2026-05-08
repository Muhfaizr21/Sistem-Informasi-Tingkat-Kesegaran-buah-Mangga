<section class="relative min-h-screen overflow-hidden" style="padding-top: 72px;">
    <!-- Background: solid cream on mobile, diagonal on desktop -->
    <div class="absolute inset-0 z-0" style="background: var(--cream);"></div>
    <div class="absolute inset-0 z-0 hidden lg:block" style="background: linear-gradient(135deg, var(--cream) 55%, var(--mango-green) 55%);"></div>

    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 items-center min-h-[calc(100vh-72px)]">

    <!-- Left Content -->
    <div class="relative z-10 px-6 sm:px-[5%] lg:px-[8%] py-10 sm:py-16 lg:py-20 fade-in">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[0.72rem] font-semibold uppercase tracking-[0.1em] mb-7 border"
            style="background: var(--gold-pale); border-color: var(--gold); color: var(--earth);">
            🥭 Kota Mangga Indramayu
        </div>

        <!-- Title -->
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.4rem, 4.5vw, 3.8rem); line-height: 1.08; color: var(--leaf-dark); margin-bottom: 8px;">
            Sistem Informasi
            <span class="block" style="color: var(--gold);">Kesegaran Mangga</span>
        </h1>

        <!-- Subtitle -->
        <p style="font-family: 'Lora', serif; font-style: italic; color: var(--earth); font-size: 1rem; margin-bottom: 18px; letter-spacing: 0.02em;">
            — Gedong Gincu, Harum Manis, Cengkir, Manalagi —
        </p>

        <!-- Description -->
        <p class="text-base leading-relaxed max-w-[440px] mb-10" style="color: var(--text-mid);">
            Optimalkan hasil panen mangga Indramayu dengan teknologi Computer Vision dan Big Data. Penilaian kualitas otomatis dalam genggaman tangan petani.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-10 sm:mb-12">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-md text-white font-bold text-[0.95rem] no-underline transition-all duration-300 hover:-translate-y-0.5"
                style="background: var(--mango-green); box-shadow: 0 6px 24px rgba(74,124,63,0.35);">
                🚀 Mulai Sekarang
            </a>
            <a href="#fitur" class="inline-flex items-center px-8 py-[14px] rounded-md font-semibold text-[0.95rem] no-underline transition-all duration-300 hover:-translate-y-0.5"
                style="background: transparent; color: var(--leaf-dark); border: 2px solid var(--leaf-dark);">
                Pelajari Fitur
            </a>
        </div>

        <!-- Stats -->
        <div class="flex items-center gap-4 sm:gap-6 lg:gap-9">
            <div class="flex flex-col">
                <span style="font-family: 'Playfair Display', serif; font-size: clamp(1.4rem, 3vw, 1.8rem); font-weight: 900; color: var(--mango-green); line-height: 1;">97%</span>
                <span class="text-[0.65rem] sm:text-[0.72rem] font-medium uppercase tracking-[0.06em] mt-1" style="color: var(--text-light);">Akurasi AI</span>
            </div>
            <div class="w-px self-stretch opacity-40" style="background: var(--gold);"></div>
            <div class="flex flex-col">
                <span style="font-family: 'Playfair Display', serif; font-size: clamp(1.4rem, 3vw, 1.8rem); font-weight: 900; color: var(--mango-green); line-height: 1;">12K+</span>
                <span class="text-[0.65rem] sm:text-[0.72rem] font-medium uppercase tracking-[0.06em] mt-1" style="color: var(--text-light);">Petani Aktif</span>
            </div>
            <div class="w-px self-stretch opacity-40" style="background: var(--gold);"></div>
            <div class="flex flex-col">
                <span style="font-family: 'Playfair Display', serif; font-size: clamp(1.4rem, 3vw, 1.8rem); font-weight: 900; color: var(--mango-green); line-height: 1;">4 Var</span>
                <span class="text-[0.65rem] sm:text-[0.72rem] font-medium uppercase tracking-[0.06em] mt-1" style="color: var(--text-light);">Varietas Mangga</span>
            </div>
        </div>
    </div>

    <!-- Right Visual -->
    <div class="relative z-10 h-full hidden lg:flex items-center justify-center px-[5%] py-20 fade-in delay-3">
        <div class="relative w-full max-w-[480px]">
            <!-- Gold circle accents -->
            <div class="absolute -top-10 -right-10 w-[180px] h-[180px] border-2 rounded-full opacity-25" style="border-color: var(--gold);"></div>
            <div class="absolute bottom-[10%] -left-5 w-[100px] h-[100px] border-[6px] rounded-full opacity-30" style="border-color: var(--gold-light);"></div>

            <!-- Mango Grove SVG Illustration -->
            <div class="w-full rounded-[200px_200px_24px_24px] overflow-hidden relative"
                style="aspect-ratio: 4/5; background: linear-gradient(160deg, #6BAF5E 0%, #4A7C3F 40%, #1E3A1A 100%); box-shadow: 0 30px 80px rgba(30,58,26,0.35);">
                <svg class="w-full h-full" viewBox="0 0 400 500" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <radialGradient id="sunGrad" cx="70%" cy="20%">
                            <stop offset="0%" stop-color="#F5C842" stop-opacity="0.6"/>
                            <stop offset="100%" stop-color="transparent"/>
                        </radialGradient>
                        <linearGradient id="groundGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#4A7C3F"/>
                            <stop offset="100%" stop-color="#2D5A1E"/>
                        </linearGradient>
                    </defs>
                    <rect width="400" height="500" fill="url(#groundGrad)"/>
                    <circle cx="300" cy="80" r="60" fill="url(#sunGrad)"/>
                    <ellipse cx="80" cy="420" rx="160" ry="90" fill="#1E3A1A" opacity="0.5"/>
                    <ellipse cx="340" cy="440" rx="140" ry="80" fill="#1E3A1A" opacity="0.4"/>
                    <rect x="170" y="260" width="20" height="120" fill="#5C3A1A" rx="4"/>
                    <rect x="70" y="290" width="14" height="100" fill="#5C3A1A" rx="3"/>
                    <rect x="290" y="280" width="16" height="110" fill="#5C3A1A" rx="3"/>
                    <ellipse cx="180" cy="230" rx="80" ry="60" fill="#2D6E22"/>
                    <ellipse cx="150" cy="210" rx="55" ry="45" fill="#3D8A2C"/>
                    <ellipse cx="210" cy="215" rx="55" ry="48" fill="#4A7C3F"/>
                    <ellipse cx="180" cy="190" rx="65" ry="50" fill="#56A83A"/>
                    <ellipse cx="80" cy="265" rx="55" ry="42" fill="#2D6E22"/>
                    <ellipse cx="60" cy="250" rx="40" ry="35" fill="#3D8A2C"/>
                    <ellipse cx="100" cy="248" rx="42" ry="36" fill="#4A7C3F"/>
                    <ellipse cx="300" cy="255" rx="58" ry="44" fill="#2D6E22"/>
                    <ellipse cx="278" cy="240" rx="42" ry="36" fill="#3D8A2C"/>
                    <ellipse cx="320" cy="242" rx="44" ry="37" fill="#4A7C3F"/>
                    <ellipse cx="160" cy="225" rx="14" ry="18" fill="#E8821A"/>
                    <ellipse cx="200" cy="235" rx="13" ry="17" fill="#D4A017"/>
                    <ellipse cx="175" cy="250" rx="12" ry="16" fill="#F5C842"/>
                    <ellipse cx="145" cy="240" rx="11" ry="15" fill="#E8821A" opacity="0.8"/>
                    <ellipse cx="215" cy="215" rx="13" ry="17" fill="#C8960E"/>
                    <ellipse cx="185" cy="200" rx="12" ry="16" fill="#5BAE3A"/>
                    <ellipse cx="165" cy="210" rx="11" ry="14" fill="#4A9F2F"/>
                    <ellipse cx="70" cy="262" rx="12" ry="16" fill="#E8821A"/>
                    <ellipse cx="88" cy="255" rx="11" ry="15" fill="#F5C842"/>
                    <ellipse cx="58" cy="252" rx="10" ry="14" fill="#D4A017"/>
                    <ellipse cx="292" cy="258" rx="12" ry="16" fill="#E8821A"/>
                    <ellipse cx="314" cy="248" rx="11" ry="15" fill="#F5C842"/>
                    <ellipse cx="278" cy="248" rx="10" ry="14" fill="#5BAE3A"/>
                    <rect x="0" y="380" width="400" height="120" fill="#2D5A1E"/>
                    <ellipse cx="200" cy="380" rx="250" ry="20" fill="#3D7A29"/>
                    <rect x="100" y="355" width="50" height="30" rx="6" fill="#8B6914"/>
                    <rect x="96" y="352" width="58" height="8" rx="4" fill="#A07820"/>
                    <circle cx="114" cy="350" r="8" fill="#E8821A"/>
                    <circle cx="128" cy="348" r="8" fill="#F5C842"/>
                    <circle cx="138" cy="351" r="7" fill="#D4A017"/>
                    <rect x="245" y="360" width="45" height="28" rx="5" fill="#8B6914"/>
                    <rect x="241" y="357" width="53" height="7" rx="3.5" fill="#A07820"/>
                    <circle cx="258" cy="356" r="7" fill="#5BAE3A"/>
                    <circle cx="270" cy="354" r="7" fill="#E8821A"/>
                    <circle cx="280" cy="357" r="6" fill="#F5C842"/>
                    <line x1="300" y1="80" x2="340" y2="40" stroke="#F5C842" stroke-width="1.5" opacity="0.3"/>
                    <line x1="300" y1="80" x2="355" y2="65" stroke="#F5C842" stroke-width="1.5" opacity="0.2"/>
                    <line x1="300" y1="80" x2="350" y2="100" stroke="#F5C842" stroke-width="1.5" opacity="0.2"/>
                    <path d="M60 120 Q65 115 70 120 Q75 115 80 120" stroke="#F5C842" stroke-width="1.5" fill="none" opacity="0.7"/>
                    <path d="M320 100 Q324 95 328 100 Q332 95 336 100" stroke="#F5C842" stroke-width="1.2" fill="none" opacity="0.5"/>
                    <text x="200" y="476" text-anchor="middle" font-family="Georgia, serif" font-size="11" fill="rgba(245,200,66,0.6)" letter-spacing="3">INDRAMAYU • KOTA MANGGA</text>
                </svg>
            </div>

            <!-- Floating Cards -->
            <div class="absolute top-[18%] -left-14 bg-white rounded-[14px] px-4 py-3 shadow-[0_8px_32px_rgba(0,0,0,0.12)] border-l-4 border-[#D4A017]"
                style="animation: floatCard 4s ease-in-out infinite;">
                <div class="text-[0.68rem] uppercase tracking-[0.08em]" style="color: var(--text-light);">Kualitas Terdeteksi</div>
                <div style="font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--text-dark); margin-top: 2px;">Grade A+</div>
                <div class="text-[0.72rem] font-semibold" style="color: var(--mango-green);">✅ Segar & Layak Jual</div>
            </div>
            <div class="absolute bottom-[22%] -right-12 bg-white rounded-[14px] px-4 py-3 shadow-[0_8px_32px_rgba(0,0,0,0.12)] border-l-4 border-[#4A7C3F]"
                style="animation: floatCard 4s ease-in-out infinite 2s;">
                <div class="text-[0.68rem] uppercase tracking-[0.08em]" style="color: var(--text-light);">Analisis Real-time</div>
                <div style="font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--text-dark); margin-top: 2px;">0.3 detik</div>
                <div class="text-[0.72rem] font-semibold" style="color: var(--mango-green);">🤖 AI Computer Vision</div>
            </div>
        </div>
    </div>

    <!-- Mobile image fallback -->
    <div class="lg:hidden relative z-10 px-6 pb-10">
        <img src="{{ asset('images/many_mangoes.png') }}" class="w-full h-52 sm:h-64 object-cover rounded-2xl shadow-xl" alt="Mangga Indramayu">
    </div>
    </div>
</section>
