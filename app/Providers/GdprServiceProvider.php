<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Illuminate\Routing\Router;
use Modules\Xot\Providers\XotBaseServiceProvider;

class GdprServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Gdpr';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();

        $relativePath = config('modules.paths.generator.lang.path');
        $lang_path = module_path($this->name, $relativePath);

        $this->loadTranslationsFrom($lang_path, 'cookie-consent');
        $router = app('router');

        // $this->app['router']->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
        $this->registerMyMiddleware($router);
    }

    public function registerMyMiddleware(Router $router): void
    {
        $router->pushMiddlewareToGroup('web', \Statikbe\CookieConsent\CookieConsentMiddleware::class);
    }

    public function register(): void
    {
        parent::register();
    }
}
