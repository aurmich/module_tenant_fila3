<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SaluteOra') }}</title>
    <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'],'themes/One')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="font-inter antialiased bg-base-100 text-base-content">
    <div class="min-h-screen flex flex-col">
        <div class="bg-primary text-primary-content py-2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm font-medium">
                    🎉 Benvenuti su SaluteOra - La piattaforma dedicata alla salute orale delle gestanti
                </div>
            </div>
        </div>

        <header class="sticky top-0 z-50 bg-base-100 shadow-sm">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex-shrink-0">
                            <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
                        </a>
                        <div class="hidden lg:ml-10 lg:flex lg:items-center lg:space-x-8">
                            <a href="{{ url('/') }}" class="text-base font-medium hover:text-primary transition-colors">Home</a>
                            <a href="{{ url('about') }}" class="text-base font-medium hover:text-primary transition-colors">Chi Siamo</a>
                            <a href="{{ url('power-ups') }}" class="text-base font-medium hover:text-primary transition-colors">Servizi</a>
                            <a href="#" class="text-base font-medium hover:text-primary transition-colors">Contatti</a>
                        </div>
                    </div>

                    <div class="hidden lg:flex lg:items-center lg:space-x-6">
                        <a href="{{ url('login') }}" class="text-base font-medium hover:text-primary transition-colors">Accedi</a>
                        <a href="{{ url('register') }}" class="btn btn-primary">Registrati</a>
                    </div>

                    <div class="lg:hidden">
                        <button type="button" class="btn btn-ghost btn-circle" aria-label="Menu">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Mobile menu -->
            <div class="lg:hidden hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1 px-4">
                    <a href="{{ url('/') }}" class="block px-3 py-2 text-base font-medium hover:text-primary transition-colors">Home</a>
                    <a href="{{ url('about') }}" class="block px-3 py-2 text-base font-medium hover:text-primary transition-colors">Chi Siamo</a>
                    <a href="{{ url('power-ups') }}" class="block px-3 py-2 text-base font-medium hover:text-primary transition-colors">Servizi</a>
                    <a href="#" class="block px-3 py-2 text-base font-medium hover:text-primary transition-colors">Contatti</a>
                </div>
                <div class="pt-4 pb-3 border-t border-base-200">
                    <div class="space-y-1 px-4">
                        <a href="{{ url('login') }}" class="block px-3 py-2 text-base font-medium hover:text-primary transition-colors">Accedi</a>
                        <a href="{{ url('register') }}" class="block px-3 py-2 text-base font-medium text-primary">Registrati</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="bg-neutral text-neutral-content">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                    <div>
                        <img src="{{ asset('images/logo-white.svg') }}" alt="{{ config('app.name') }}" class="h-8 w-auto mb-6">
                        <p class="text-sm opacity-90">
                            Promuoviamo la salute orale delle gestanti attraverso prevenzione e assistenza specialistica.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Link Utili</h3>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-sm hover:text-primary-content transition-colors">Chi Siamo</a></li>
                            <li><a href="#" class="text-sm hover:text-primary-content transition-colors">Servizi</a></li>
                            <li><a href="#" class="text-sm hover:text-primary-content transition-colors">Contatti</a></li>
                            <li><a href="#" class="text-sm hover:text-primary-content transition-colors">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Contatti</h3>
                        <ul class="space-y-4">
                            <li class="text-sm">
                                <span class="opacity-90">Email:</span><br>
                                info@saluteora.it
                            </li>
                            <li class="text-sm">
                                <span class="opacity-90">Telefono:</span><br>
                                +39 XXX XXX XXXX
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Newsletter</h3>
                        <p class="text-sm opacity-90 mb-4">
                            Iscriviti per ricevere aggiornamenti e consigli sulla salute orale.
                        </p>
                        <form class="space-y-4">
                            <input type="email" placeholder="La tua email" class="input input-bordered w-full bg-neutral-focus text-neutral-content" />
                            <button type="submit" class="btn btn-primary w-full">Iscriviti</button>
                        </form>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-neutral-focus text-center text-sm opacity-90">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.querySelector('.lg\\:hidden button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    @filamentScripts
</body>
</html>
