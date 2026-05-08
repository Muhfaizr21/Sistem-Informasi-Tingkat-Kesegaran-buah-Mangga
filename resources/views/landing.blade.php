<x-landing-layout>
    <!-- Hero Section -->
    <div class="reveal">
        <x-hero />
    </div>

    <!-- Divider between Hero and Features -->
    <div class="w-full overflow-hidden bg-white dark:bg-gray-900 leading-none">
        <svg class="block w-full h-12 md:h-20 lg:h-24 text-gray-50 dark:text-gray-800/50" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="currentColor" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <!-- Features Section -->
    <div class="reveal">
        <x-features />
    </div>

    <!-- Divider between Features and About -->
    <div class="w-full overflow-hidden bg-gray-50 dark:bg-gray-800/50 leading-none">
        <svg class="block w-full h-12 md:h-20 lg:h-24 text-white dark:text-gray-900" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="currentColor" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,218.7C672,235,768,245,864,229.3C960,213,1056,171,1152,160C1248,149,1344,171,1392,181.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <!-- About / Statistics Section -->
    <section id="about" class="reveal py-20 bg-white dark:bg-gray-900 overflow-hidden">
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
    <section class="reveal py-16 bg-yellow-500">
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
