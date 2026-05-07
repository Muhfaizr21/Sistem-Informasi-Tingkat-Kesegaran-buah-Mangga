@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:border-[#FFB800] dark:focus:border-[#FFB800] focus:ring-[#FFB800] dark:focus:ring-[#FFB800] rounded-xl shadow-sm transition-all duration-200']) }}>
