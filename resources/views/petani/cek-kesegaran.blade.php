<x-petani-layout>
    <x-slot name="title">Cek Kesegaran Mangga</x-slot>

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('petani.dashboard') }}" class="p-2 bg-white rounded-xl border border-gray-100 text-gray-500 hover:text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">AI Scanner Kesegaran</h1>
    </div>

    <div class="max-w-md mx-auto space-y-6">
        <!-- Camera Preview Placeholder -->
        <div class="aspect-[3/4] bg-gray-900 rounded-[2.5rem] relative overflow-hidden shadow-2xl border-4 border-white dark:border-gray-800">
            <!-- Simulated Camera Feed -->
            <img src="https://images.unsplash.com/photo-1553279768-865429fa0078?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover opacity-50" alt="Camera Feed">
            
            <!-- Scanning Animation -->
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <div class="w-64 h-64 border-2 border-primary/50 rounded-3xl relative">
                    <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-primary rounded-tl-xl"></div>
                    <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-primary rounded-tr-xl"></div>
                    <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-primary rounded-bl-xl"></div>
                    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-primary rounded-br-xl"></div>
                    
                    <!-- Scanning Line -->
                    <div class="absolute left-0 right-0 h-1 bg-primary/50 shadow-[0_0_15px_rgba(16,185,129,0.8)] animate-scan"></div>
                </div>
                <p class="text-white text-xs font-bold mt-8 bg-black/50 px-4 py-2 rounded-full backdrop-blur-md">Posisikan mangga di dalam kotak</p>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex justify-center gap-6">
            <button class="w-16 h-16 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center text-gray-500 shadow-lg active:scale-90 transition-transform">
                <span class="material-symbols-outlined text-3xl">image</span>
            </button>
            <button class="w-20 h-20 rounded-full bg-primary flex items-center justify-center text-white shadow-xl shadow-primary/30 ring-4 ring-white dark:ring-gray-900 active:scale-90 transition-transform">
                <span class="material-symbols-outlined text-4xl">photo_camera</span>
            </button>
            <button class="w-16 h-16 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center text-gray-500 shadow-lg active:scale-90 transition-transform">
                <span class="material-symbols-outlined text-3xl">flash_on</span>
            </button>
        </div>

        <!-- Tips Card -->
        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-2xl border border-blue-100 dark:border-blue-800 flex gap-3">
            <span class="material-symbols-outlined text-blue-500">info</span>
            <div>
                <p class="text-xs font-bold text-blue-800 dark:text-blue-300">Tips Hasil Akurat</p>
                <p class="text-[10px] text-blue-700/80 dark:text-blue-400">Pastikan pencahayaan terang dan lensa kamera bersih untuk akurasi hingga 98%.</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }
        .animate-scan {
            position: absolute;
            animation: scan 2s linear infinite;
        }
    </style>
</x-petani-layout>
