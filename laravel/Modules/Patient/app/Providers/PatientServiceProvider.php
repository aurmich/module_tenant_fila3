<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

<<<<<<< HEAD
<<<<<<< HEAD
use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Patient\Filament\Widgets\PatientRegistrationWizard;
=======
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Xot\Providers\XotBaseServiceProvider;
>>>>>>> 2004ea4c (.)
=======
use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Patient\Filament\Widgets\PatientRegistrationWizard;
>>>>>>> 5079a23a (.)
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Document;
use Modules\Patient\Models\Anamnesis;
use Modules\Patient\Filament\Resources\PatientResource;
<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Xot\Providers\XotBaseServiceProvider;
=======
>>>>>>> 2004ea4c (.)
=======
use Modules\Xot\Providers\XotBaseServiceProvider;
>>>>>>> 5079a23a (.)

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
    public string $nameLower = 'patient';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5079a23a (.)

    public function boot(): void
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'patient');

        // Registrazione dei componenti Blade
        Blade::componentNamespace('Modules\\Patient\\View\\Components', 'patient');

        if (class_exists(Livewire::class)) {
            Livewire::component('patient.registration-wizard', PatientRegistrationWizard::class);
        }
<<<<<<< HEAD
=======
    
    
<<<<<<< HEAD
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
>>>>>>> 2004ea4c (.)
    }
=======
>>>>>>> b47e8d10 (.)
=======
    }
>>>>>>> 5079a23a (.)
}
