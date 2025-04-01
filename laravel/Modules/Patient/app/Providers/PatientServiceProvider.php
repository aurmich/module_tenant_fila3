<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

use Filament\Resources\Resource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Document;
use Modules\Patient\Models\Anamnesis;
use Modules\Patient\Filament\Resources\PatientResource;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
    public string $nameLower = 'patient';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        parent::boot();
        
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        $this->loadTranslationsFrom(module_path($this->name, 'resources/lang'), $this->nameLower);
        $this->loadViewsFrom(module_path($this->name, 'resources/views'), $this->nameLower);
        
        // Registra le risorse Filament
        Resource::registerResources([
            PatientResource::class,
        ]);
    }
    
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();
        
        $this->app->register(RouteServiceProvider::class);
        
        $this->mergeConfigFrom(
            module_path($this->name, 'config/config.php'), $this->nameLower
        );
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [];
    }
}
