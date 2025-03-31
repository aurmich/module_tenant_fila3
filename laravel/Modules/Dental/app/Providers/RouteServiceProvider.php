<?php

declare(strict_types=1);

namespace Modules\Dental\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Dental';
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Dental\Http\Controllers';
}
