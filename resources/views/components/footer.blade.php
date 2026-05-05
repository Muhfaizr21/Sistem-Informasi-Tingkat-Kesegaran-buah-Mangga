<footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-8 w-auto fill-current text-yellow-500" />
                    <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Mango<span class="text-yellow-500">Fresh</span></span>
                </a>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm max-w-xs">
                    Sistem informasi cerdas untuk mendukung digitalisasi pertanian mangga di wilayah Indramayu dan sekitarnya.
                </p>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Navigasi</h3>
                <ul class="mt-4 space-y-4">
                    <li><a href="#" class="text-base text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="#features" class="text-base text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Fitur</a></li>
                    <li><a href="#about" class="text-base text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Hukum</h3>
                <ul class="mt-4 space-y-4">
                    <li><a href="#" class="text-base text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Privasi</a></li>
                    <li><a href="#" class="text-base text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-100 dark:border-gray-800 pt-8 flex items-center justify-between">
            <p class="text-base text-gray-400 xl:text-center">
                &copy; {{ date('Y') }} MangoFresh Indramayu. All rights reserved.
            </p>
            <div class="flex space-x-6">
                <!-- Social Icons would go here -->
            </div>
        </div>
    </div>
</footer>
