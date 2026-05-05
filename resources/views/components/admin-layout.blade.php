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
                        "primary-container": "#001f3f",
                        "surface-dim": "#d8dadc",
                        "surface": "#f7f9fb",
                        "primary-fixed-dim": "#afc8f0",
                        "tertiary": "#000801",
                        "error": "#ba1a1a",
                        "surface-bright": "#f7f9fb",
                        "surface-container-high": "#e6e8ea",
                        "inverse-primary": "#afc8f0",
                        "surface-tint": "#476083",
                        "surface-container-highest": "#e0e3e5",
                        "on-primary": "#ffffff",
                        "outline": "#74777f",
                        "secondary-container": "#a9dbfe",
                        "on-primary-container": "#6f88ad",
                        "inverse-surface": "#2d3133",
                        "background": "#f7f9fb",
                        "tertiary-container": "#002505",
                        "on-secondary-fixed-variant": "#104c69",
                        "error-container": "#ffdad6",
                        "secondary-fixed": "#c7e7ff",
                        "on-surface": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#001c3a",
                        "primary-fixed": "#d4e3ff",
                        "on-tertiary-fixed": "#002204",
                        "on-secondary-container": "#2c617f",
                        "on-surface-variant": "#43474e",
                        "on-tertiary-fixed-variant": "#005313",
                        "primary": "#000613",
                        "surface-variant": "#e0e3e5",
                        "surface-container-low": "#f2f4f6",
                        "on-error": "#ffffff",
                        "outline-variant": "#c4c6cf",
                        "on-tertiary-container": "#35993d",
                        "on-secondary-fixed": "#001e2e",
                        "tertiary-fixed-dim": "#78dc77",
                        "surface-container": "#eceef0",
                        "on-secondary": "#ffffff",
                        "secondary": "#2f6482",
                        "on-tertiary": "#ffffff",
                        "on-error-container": "#93000a",
                        "tertiary-fixed": "#94f990",
                        "secondary-fixed-dim": "#9bcdef",
                        "on-primary-fixed-variant": "#2f486a",
                        "on-background": "#191c1e"
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
</body>
</html>
