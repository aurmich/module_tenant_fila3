<?php

return [
    'path' => env('FILAMENT_PATH', 'admin'),
    'home_url' => '/',
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
        'pages' => [
            'login' => \Filament\Pages\Auth\Login::class,
            'logout' => \Filament\Pages\Auth\Logout::class,
        ],
    ],
    'pages' => [
        'namespace' => 'App\\Filament\\Pages',
        'path' => app_path('Filament/Pages'),
        'register' => [],
    ],
    'resources' => [
        'namespace' => 'App\\Filament\\Resources',
        'path' => app_path('Filament/Resources'),
        'register' => [],
    ],
    'widgets' => [
        'namespace' => 'App\\Filament\\Widgets',
        'path' => app_path('Filament/Widgets'),
        'register' => [],
    ],
    'livewire' => [
        'namespace' => 'App\\Filament',
        'path' => app_path('Filament'),
    ],
    'middleware' => [
        'base' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'auth' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
        ],
    ],
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
        'pages' => [
            'login' => \Filament\Pages\Auth\Login::class,
            'logout' => \Filament\Pages\Auth\Logout::class,
        ],
    ],
    'brand' => [
        'name' => 'SaluteOra',
        'logo' => null,
    ],
    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
    ],
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'layout' => [
        'actions' => [
            'modal' => [
                'actions' => [
                    'alignment' => 'left',
                    'are_sticky' => false,
                ],
            ],
        ],
        'forms' => [
            'actions' => [
                'alignment' => 'left',
                'are_sticky' => false,
            ],
            'have_inline_labels' => false,
        ],
    ],
    'notifications' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
        ],
    ],
    'plugins' => [],
    'vite' => [
        'config' => base_path('vite.config.js'),
        'dev_server' => [
            'enabled' => env('FILAMENT_VITE_DEV_SERVER', false),
            'url' => env('FILAMENT_VITE_DEV_SERVER_URL', 'http://localhost:5173'),
        ],
    ],
]; 