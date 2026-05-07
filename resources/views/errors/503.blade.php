<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SI-Mangga - Pemeliharaan Sistem</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
            <div class="max-w-md w-full">
                <div class="mb-8 flex justify-center text-yellow-500">
                    <div class="relative">
                        <x-application-logo class="h-24 w-auto grayscale opacity-30" />
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-6xl font-black text-[#1b1b18] dark:text-[#EDEDEC] tracking-tighter">503</span>
                        </div>
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold mb-4 dark:text-[#EDEDEC]">Kebun Sedang Dirawat.</h1>
                <p class="text-gray-500 dark:text-[#A1A09A] mb-10">
                    Sistem kami sedang dalam pemeliharaan rutin untuk meningkatkan kualitas layanan. Kami akan segera kembali!
                </p>

                <div class="p-6 bg-white dark:bg-[#161615] rounded-2xl shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                    <div class="flex items-center justify-center gap-4 text-sm font-medium text-gray-600 dark:text-[#EDEDEC]">
                        <span class="flex h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                        Status: Pemeliharaan Terjadwal
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
