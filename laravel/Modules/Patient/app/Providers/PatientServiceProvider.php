<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Document;
use Modules\Patient\Models\Anamnesis;
use Modules\Patient\Filament\Resources\PatientResource;
use Modules\Patient\Filament\Resources\DocumentResource;
use Modules\Patient\Filament\Resources\AnamnesisResource;
use Modules\Patient\Providers\Filament\AdminPanelProvider;
use Filament\Facades\Filament;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
     protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
    
    
} 