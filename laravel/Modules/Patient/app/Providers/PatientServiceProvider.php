<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Patient\Filament\Widgets\PatientRegistrationWizard;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Document;
use Modules\Patient\Models\Anamnesis;
use Modules\Patient\Filament\Resources\PatientResource;
use Modules\Xot\Providers\XotBaseServiceProvider;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
    public string $nameLower = 'patient';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'patient');

        // Registrazione dei componenti Blade
        Blade::componentNamespace('Modules\\Patient\\View\\Components', 'patient');

        if (class_exists(Livewire::class)) {
            Livewire::component('patient.registration-wizard', PatientRegistrationWizard::class);
        }
    }
}
