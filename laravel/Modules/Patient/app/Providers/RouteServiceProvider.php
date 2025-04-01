<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    protected string $moduleNamespace = 'Modules\Patient\Http\Controllers';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    public string $name = 'Patient';
    public string $nameLower = 'patient';
    
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        parent::boot();

        $this->map();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Patient', 'routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Patient', 'routes/api.php'));
    }
}
