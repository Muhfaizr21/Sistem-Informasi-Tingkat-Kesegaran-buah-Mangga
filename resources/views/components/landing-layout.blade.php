<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistem Informasi Tingkat Kesegaran Buah Mangga Indramayu (SI-Mangga). Monitor kualitas dan beli mangga Indramayu terbaik langsung dari kebun.">
    <meta name="keywords" content="mangga indramayu, kesegaran buah, ai scanner mangga, petani mangga, indramayu">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="SI-Mangga - Sistem Informasi Kesegaran Mangga Indramayu">
    <meta property="og:description" content="Monitor kualitas dan beli mangga Indramayu terbaik langsung dari kebun.">
    <meta property="og:image" content="{{ asset('storage/logo/logo si-mangga.png') }}">

        <title>{{ config('app.name', 'SI-Mangga') }} — Sistem Informasi Kesegaran Mangga Indramayu</title>

        <!-- Localized Fonts -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fonts.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --gold: #D4A017;
                --gold-light: #F5C842;
                --gold-pale: #FFF8E1;
                --mango-orange: #E8821A;
                --mango-green: #4A7C3F;
                --mango-green-light: #6BAF5E;
                --leaf-dark: #1E3A1A;
                --earth: #7B4F2E;
                --cream: #FAF5E4;
                --white: #FFFFFF;
                --text-dark: #1A1A0F;
                --text-mid: #3D3520;
                --text-light: #7A6E52;
            }

            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: var(--cream);
                color: var(--text-dark);
                overflow-x: hidden;
            }

            /* Batik pattern */
            .batik-bg {
                background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23D4A017' stroke-width='0.5' opacity='0.18'%3E%3Cellipse cx='40' cy='40' rx='30' ry='18'/%3E%3Cellipse cx='40' cy='40' rx='20' ry='10'/%3E%3Ccircle cx='40' cy='40' r='4'/%3E%3Cline x1='10' y1='40' x2='70' y2='40'/%3E%3Cline x1='40' y1='10' x2='40' y2='70'/%3E%3Ccircle cx='10' cy='10' r='3'/%3E%3Ccircle cx='70' cy='10' r='3'/%3E%3Ccircle cx='10' cy='70' r='3'/%3E%3Ccircle cx='70' cy='70' r='3'/%3E%3C/g%3E%3C/svg%3E");
            }

            /* Scroll reveal */
            .reveal {
                opacity: 0;
                transform: translateY(28px);
                transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
            }
            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }

            /* Fade in animation */
            .fade-in {
                opacity: 0; transform: translateY(28px);
                animation: fadeIn 0.7s ease forwards;
            }
            @keyframes fadeIn {
                to { opacity: 1; transform: translateY(0); }
            }
            .delay-1 { animation-delay: 0.1s; }
            .delay-2 { animation-delay: 0.2s; }
            .delay-3 { animation-delay: 0.3s; }
            .delay-4 { animation-delay: 0.4s; }
            .delay-5 { animation-delay: 0.55s; }

            /* Floating card animation */
            @keyframes floatCard {
                0%,100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }

            /* Marquee */
            @keyframes marquee {
                from { transform: translateX(0); }
                to { transform: translateX(-50%); }
            }

            /* Gold scrollbar */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: var(--cream); }
            ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }

            /* Page separator */
            .page-separator {
                height: 6px;
                background: repeating-linear-gradient(90deg,
                    var(--gold) 0, var(--gold) 16px,
                    var(--mango-green) 16px, var(--mango-green) 32px);
            }
        </style>
    </head>
    <body>
        <div class="min-h-screen">
            <x-navbar />

            <main>
                {{ $slot }}
            </main>

            <x-footer />
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const reveals = document.querySelectorAll(".reveal");
                const revealObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("active");
                            observer.unobserve(entry.target);
                        }
                    });
                }, { root: null, threshold: 0.1, rootMargin: "0px" });
                reveals.forEach(function(reveal) { revealObserver.observe(reveal); });
            });
        </script>
    </body>
</html>
