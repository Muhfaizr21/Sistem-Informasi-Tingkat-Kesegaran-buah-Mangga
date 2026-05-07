<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-[#1b1b18] dark:bg-[#eeeeec] border border-transparent rounded-lg font-semibold text-sm text-white dark:text-[#1C1C1A] hover:bg-black dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-[#FFB800] focus:ring-offset-2 dark:focus:ring-offset-[#0a0a0a] transition ease-in-out duration-150 shadow-sm']) }}>
    {{ $slot }}
</button>
