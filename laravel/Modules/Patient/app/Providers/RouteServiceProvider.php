<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
<<<<<<< HEAD
<<<<<<< HEAD
    protected string $moduleNamespace = 'Modules\Patient\Http\Controllers';
=======
    /**
     * Nome del modulo - OBBLIGATORIO per XotBaseServiceProvider
     * Deve corrispondere esattamente al nome della cartella del modulo
     */
    public string $name = 'Patient';
    
    protected $moduleNamespace = 'Modules\Patient\Http\Controllers';
>>>>>>> 059ca8d4 (.)
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    public string $name = 'Patient';
   
    
   
=======
    protected string $moduleNamespace = 'Modules\Patient\Http\Controllers';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    public string $name = 'Patient';
   
    
<<<<<<< HEAD
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
>>>>>>> 2004ea4c (.)
=======
   
>>>>>>> b47e8d10 (.)
}
