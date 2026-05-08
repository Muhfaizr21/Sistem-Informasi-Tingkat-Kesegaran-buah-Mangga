<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SI-Mangga') }} - Sistem Informasi Kesegaran Mangga</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white dark:bg-gray-900">
        <div class="min-h-screen">
            <x-navbar />

            <main>
                {{ $slot }}
            </main>

            <x-footer />
        </div>

        <style>
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 1s cubic-bezier(0.5, 0, 0, 1);
            }
            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }
        </style>

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
                }, {
                    root: null,
                    threshold: 0.15,
                    rootMargin: "0px"
                });

                reveals.forEach(function(reveal) {
                    revealObserver.observe(reveal);
                });
            });
        </script>
    </body>
</html>
