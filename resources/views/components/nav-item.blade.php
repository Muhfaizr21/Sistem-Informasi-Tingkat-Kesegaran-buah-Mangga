@props(['route', 'icon', 'label'])

<a href="{{ route($route) }}" 
   class="flex items-center gap-4 px-6 py-4 rounded-3xl transition-all duration-300 group
   {{ request()->routeIs($route) ? 'nav-active' : 'text-slate-500 hover:bg-primary-50 hover:text-primary-600' }}">
    <span class="material-symbols-outlined transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs($route) ? 'fill-1' : '' }}">
        {{ $icon }}
    </span>
    <span class="text-sm font-bold tracking-tight">{{ $label }}</span>
</a>
