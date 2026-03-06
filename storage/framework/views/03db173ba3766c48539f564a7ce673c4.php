<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Dark mode: apply before CSS renders to avoid flash -->
        <script>
            (function () {
                var t = localStorage.getItem('theme');
                if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    </head>
    <body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 transition-colors duration-300">

        <!-- Minimal top bar -->
        <div class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="<?php echo e(route('home')); ?>" wire:navigate class="text-2xl font-bold text-slate-900 dark:text-white hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
                    MijnShop
                </a>
                <button onclick="toggleTheme()"
                        class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        title="Wissel thema">
                    <!-- Sun icon — shown in dark mode -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden dark:block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m8.66-9h-1M4.34 12h-1m15.07-6.07-.71.71M6.34 17.66l-.71.71m12.73 0-.71-.71M6.34 6.34l-.71-.71M12 5a7 7 0 100 14A7 7 0 0012 5z"/>
                    </svg>
                    <!-- Moon icon — shown in light mode -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="block dark:hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="min-h-[calc(100vh-4rem)] flex flex-col sm:justify-center items-center py-12 px-4">
            <div class="w-full sm:max-w-md bg-white dark:bg-slate-800 shadow-xl rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
                <div class="px-8 py-8">
                    <?php echo e($slot); ?>

                </div>
            </div>
        </div>

        <script>
            function toggleTheme() {
                var html = document.documentElement;
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        </script>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    </body>
</html><?php /**PATH C:\Users\bas15\mijn-oefen-project\resources\views/layouts/guest.blade.php ENDPATH**/ ?>