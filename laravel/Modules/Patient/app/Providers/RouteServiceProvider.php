<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
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
   
    
   
}
