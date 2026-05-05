<x-landing-layout>
    <!-- Hero Section -->
    <x-hero />

    <!-- Features Section -->
    <x-features />

    <!-- About / Statistics Section -->
    <section id="about" class="py-20 bg-white dark:bg-gray-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <div class="relative lg:flex lg:items-center lg:gap-12">
                    <div class="lg:w-1/2">
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                            Mendukung Ekosistem Mangga <span class="text-yellow-500">Indramayu</span>
                        </h2>
                        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                            Indramayu dikenal sebagai lumbung mangga nasional. Proyek ini hadir untuk memperkuat posisi tersebut dengan menghadirkan standar kualitas digital yang dapat dipercaya oleh pasar global.
                        </p>
                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div class="p-6 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">95%</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Akurasi AI</p>
                            </div>
                            <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400">100+</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Petani Terdaftar</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 lg:mt-0 lg:w-1/2 relative">
                        <div class="absolute -inset-4 bg-yellow-500/10 rounded-full blur-3xl"></div>
                        <img class="relative rounded-2xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500" src="https://images.unsplash.com/photo-1591073113125-e46713c829ed?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Lahan Mangga">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-yellow-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                Siap untuk mendigitalisasi hasil kebun Anda?
            </h2>
            <p class="mt-4 text-xl text-yellow-100">
                Daftar sekarang dan nikmati kemudahan memantau kesegaran mangga secara real-time.
            </p>
            <div class="mt-8 flex justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-yellow-600 bg-white hover:bg-yellow-50 md:py-4 md:text-lg md:px-10 shadow-xl transition-all transform hover:scale-105">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </section>
</x-landing-layout>
