<?php

declare(strict_types=1);

namespace Modules\Notify\Providers;

// use Illuminate\Support\Facades\Notification;
use Modules\Xot\Providers\XotBaseServiceProvider;

class NotifyServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Notify';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
    }
}
