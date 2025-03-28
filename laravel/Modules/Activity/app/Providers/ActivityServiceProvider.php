<?php

declare(strict_types=1);

namespace Modules\Activity\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ActivityServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Activity';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Additional boot logic can be added here
    }

    public function register(): void
    {
        parent::register();
        // Additional register logic can be added here
    }
}
