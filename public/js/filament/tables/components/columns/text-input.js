@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-400 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm transition-colors duration-200']) }}>