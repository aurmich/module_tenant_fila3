<?php

namespace Themes\One\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\FilamentAsset;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Registra il tema
        FilamentAsset::register([
            'name' => 'one',
            'path' => 'themes/one',
        ]);

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'one');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }

    public function register()
    {
        //
    }
}
