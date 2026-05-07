<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>500 - Kesalahan Server</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
            <div class="max-w-md w-full">
                <div class="mb-8 flex justify-center text-orange-500">
                    <div class="relative">
                        <x-application-logo class="h-24 w-auto grayscale opacity-30" />
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-6xl font-black text-[#1b1b18] dark:text-[#EDEDEC] tracking-tighter">500</span>
                        </div>
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold mb-4 dark:text-[#EDEDEC]">Server Sedang Sakit.</h1>
                <p class="text-gray-500 dark:text-[#A1A09A] mb-10">
                    Terjadi kesalahan internal pada sistem kami. Tim kami sedang berusaha memperbaikinya secepat mungkin.
                </p>

                <div class="flex flex-col gap-3">
                    <a href="/" class="inline-flex items-center justify-center px-6 py-3 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] font-semibold rounded-xl hover:bg-black transition-all shadow-sm">
                        Kembali ke Beranda
                    </a>
                    <button onclick="location.reload()" class="inline-flex items-center justify-center px-6 py-3 border border-[#19140035] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                        Muat Ulang Halaman
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
