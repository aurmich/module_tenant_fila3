<?php

namespace Modules\Patient\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends XotBaseServiceProvider
{
    protected $moduleNamespace = 'Modules\Patient\Http\Controllers';
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

  
} 