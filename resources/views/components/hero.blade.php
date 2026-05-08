<div class="relative bg-white dark:bg-gray-900 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white dark:text-gray-900 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>

            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        <span class="block xl:inline tracking-tighter">Sistem Informasi</span>
                        <span class="block text-yellow-500 xl:inline">Kesegaran Mangga</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Optimalkan hasil panen mangga Indramayu Anda dengan teknologi Computer Vision dan Big Data. Penilaian kualitas otomatis dalam genggaman tangan.
                    </p>
                    <div class="mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-white bg-yellow-500 hover:bg-yellow-600 md:py-4 md:text-lg md:px-10 shadow-lg shadow-yellow-500/30 transition-all transform hover:-translate-y-1">
                                Mulai Sekarang
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#features" class="w-full flex items-center justify-center px-8 py-3 border border-gray-200 dark:border-gray-700 text-base font-semibold rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 md:py-4 md:text-lg md:px-10 transition-all">
                                Pelajari Fitur
                            </a>
                        </div>
                    </div>
                    
                    <!-- Stats / Social Proof -->
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 sm:gap-6 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                            Computer Vision AI
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                            Indramayu Case Study
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-64 w-full object-cover sm:h-80 md:h-96 lg:w-full lg:h-full grayscale-0 lg:grayscale hover:grayscale-0 transition-all duration-1000" src="{{ asset('images/many_mangoes.png') }}" alt="Mangga Indramayu">
    </div>
</div>
