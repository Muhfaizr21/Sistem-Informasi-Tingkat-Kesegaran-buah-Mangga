<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - {{ config('app.name', 'Mangga Indramayu') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Tailwind Config for the provided UI -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                        "mango": {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        "primary-container": "#001f3f",
                        "surface": "#ffffff",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#43474e",
                        "outline-variant": "#c4c6cf",
                        "background": "#f7f9fb",
                        "on-background": "#191c1e",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-high": "#e6e8ea",
                        "surface-container-highest": "#e0e3e5",
                        "error": "#ba1a1a",
                        "secondary": "#2f6482"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "stack-md": "16px",
                        "container-padding": "32px",
                        "stack-lg": "24px",
                        "unit": "4px",
                        "stack-sm": "8px",
                        "sidebar-width": "260px"
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-background text-on-background font-inter antialiased min-h-screen" x-data="{ sidebarOpen: false }">
    <!-- Mobile Header -->
    <header class="md:hidden bg-primary-container text-on-primary h-16 fixed top-0 left-0 right-0 z-[60] flex items-center justify-between px-4 shadow-md">
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-white/10 rounded-lg">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <span class="font-bold tracking-tight">Admin Portal</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs">
            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
        </div>
    </header>

    <!-- Sidebar Wrapper with Mobile Overlay -->
    <div 
        class="fixed inset-0 bg-black/50 z-[55] md:hidden transition-opacity duration-300" 
        x-show="sidebarOpen" 
        x-transition:enter="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="opacity-100" 
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false">
    </div>

    <div 
        class="fixed top-0 left-0 bottom-0 z-[56] transition-transform duration-300 md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <x-admin.sidebar />
    </div>
    
    <x-admin.navbar />

    <!-- Main Content Canvas -->
    <main class="md:ml-[260px] pt-16 md:pt-[64px] min-h-screen p-4 md:p-container-padding flex flex-col gap-stack-lg md:gap-gutter">
        {{ $slot }}
    </main>

    <!-- Alpine.js (for mobile toggle) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
