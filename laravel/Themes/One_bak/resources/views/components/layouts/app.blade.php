<x-layouts.main>
<<<<<<< HEAD
<<<<<<< HEAD
    <x-ui.marketing.header />
    
<<<<<<< HEAD
    <!-- Page Heading -->
    @if (isset($header))
        <header class="mb-6 bg-white shadow-sm border-b border-gray-100 dark:border-gray-800 dark:bg-gray-900/40">
=======
    
    <x-ui.app.header />

=======
    <x-ui.marketing.header />
>>>>>>> f25a0df8 (.)
    <!-- Page Heading -->
    @if (isset($header))
        <header class="mb-5 bg-white border-b border-gray-200/80 dark:border-gray-200/10 dark:bg-gray-900/40">
>>>>>>> 5079a23a (.)
=======
    <!-- Page Heading -->
    @if (isset($header))
        <header class="mb-6 bg-white shadow-sm border-b border-gray-100 dark:border-gray-800 dark:bg-gray-900/40">
>>>>>>> f6e6ce99 (.)
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif
    
<<<<<<< HEAD
<<<<<<< HEAD
    <!-- Contenuto principale -->
    <div class="mx-auto py-6 max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
    
    <!-- Breadcrumb opzionale -->
    @if (isset($breadcrumb))
        <div class="bg-gray-50 dark:bg-gray-800/30 py-3 border-t border-gray-100 dark:border-gray-800">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <nav class="flex text-sm text-gray-500 dark:text-gray-400">
                    {{ $breadcrumb }}
                </nav>
            </div>
        </div>
    @endif
=======
    <div class="mx-auto mt-5 max-w-7xl">
        <div class="sm:px-6 lg:px-8">
=======
    <!-- Contenuto principale -->
    <div class="mx-auto py-6 max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
>>>>>>> f6e6ce99 (.)
            {{ $slot }}
        </div>
    </div>
<<<<<<< HEAD

>>>>>>> 5079a23a (.)
=======
    
<<<<<<< HEAD
>>>>>>> f25a0df8 (.)
=======
    <!-- Breadcrumb opzionale -->
    @if (isset($breadcrumb))
        <div class="bg-gray-50 dark:bg-gray-800/30 py-3 border-t border-gray-100 dark:border-gray-800">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <nav class="flex text-sm text-gray-500 dark:text-gray-400">
                    {{ $breadcrumb }}
                </nav>
            </div>
        </div>
    @endif
>>>>>>> f6e6ce99 (.)
</x-layouts.main>