<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Modules\Xot\Console\Commands\DatabaseBackUpCommand;
use Modules\Xot\Providers\Traits\TranslatorTrait;
use Modules\Xot\View\Composers\XotComposer;

use function Safe\realpath;

/**
 * Class XotServiceProvider.
 */
class XotServiceProvider extends XotBaseServiceProvider
{
    // use Traits\PresenterTrait;
    use TranslatorTrait;

    public string $module_name = 'xot';

    /**
     * The module directory.
     */
    protected string $module_dir = __DIR__;

    /**
     * The module namespace.
     */
    protected string $module_ns = __NAMESPACE__;

    public function bootCallback(): void
    {
        // $this->registerConfigs();
        $this->registerCommands();

        $this->redirectSSL();

        $this->registerTranslator();

        // $this->registerCacheOPCache();
        // $this->registerScout();

        // $this->registerLivewireComponents();

        $this->registerViewComposers(); // rompe filament

        // $this->registerPanel();
        // $this->registerDropbox();// PROBLEMA DI COMPOSER
        $this->registerEvents();
    }

    // end bootCallback

    public function registerConfigs(): void
    {
        $config_file = realpath(__DIR__.'/../Config/metatag.php');
        $this->mergeConfigFrom($config_file, 'metatag');
        // dddx('a');
    }

    public function registerCallback(): void
    {
        // $this->loadHelpersFrom(__DIR__.'/../Helpers'); //non serve piu
        // $aliasLoader = AliasLoader::getInstance();
        // $aliasLoader->alias('Panel', PanelService::class);

        // $loader->alias(\Modules\Xot\Facades\Profile::class,
        // $this->registerPresenter();

        // $this->registerPanel();
        // $this->registerBladeDirectives(); //non intercetta
        // $this->app->singleton('profile', function (Application $app) {
        //    return new \Modul
        // });
        // $this->app->bind('profile', \Modules\Xot\Services\ProfileTest::class);

        // $this->app->bind(
        //    'profile',
        //    static fn (): ProfileTest => new ProfileTest()
        // );
        $this->registerConfigs();
    }

    /*
    public function mergeConfigs(): void {
        $configs = ['database', 'filesystems', 'auth', 'metatag', 'services', 'xra', 'social'];
        foreach ($configs as $v) {
            $tmp = Tenant::config($v);
            //dddx($tmp);
        }
        //DB::purge('mysql');//Call to a member function prepare() on null
        //DB::purge('liveuser_general');
        //DB::reconnect();
    }

    //end mergeConfigs
    //*/
    public function loadHelpersFrom(string $path): void
    {
        $files = File::files($path);
        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            if ($file->getRealPath() === false) {
                continue;
            }
            include_once $file->getRealPath();
        }
    }

    /*
    public function mergeConfigs(): void {
        $configs = ['database', 'filesystems', 'auth', 'metatag', 'services', 'xra', 'social'];
        foreach ($configs as $v) {
            $tmp = Tenant::config($v);
            //dddx($tmp);
        }
        //DB::purge('mysql');//Call to a member function prepare() on null
        //DB::purge('liveuser_general');
        //DB::reconnect();
    }

    //end mergeConfigs
    //*/

    private function redirectSSL(): void
    {
        // --- meglio ficcare un controllo anche sull'env
        if (config('xra.forcessl') && (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] !== 'localhost'
            && isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'http')) {
            URL::forceScheme('https');
            /*
             * da fare in htaccess
             */
            if (! request()->secure() /* && in_array(env('APP_ENV'), ['stage', 'production']) */) {
                exit(redirect()->secure(request()->getRequestUri()));
            }
        }
    }

    /**
     * Undocumented function.
     *
     * @see https://medium.com/@dobron/running-laravel-ide-helper-generator-automatically-b909e75849d0
     */
    private function registerEvents(): void
    {
        Event::listen(
            MigrationsEnded::class,
            static function (): void {
                Artisan::call('ide-helper:models -r -W');
            }
        );
    }

    /**
     * Undocumented function.
     */
    private function registerCommands(): void
    {
        $this->commands(
            [
                // \Modules\Xot\Console\CreateAllRepositoriesCommand::class,
                // \Modules\Xot\Console\PanelMakeCommand::class,
                // \Modules\Xot\Console\FixProvidersCommand::class,
                DatabaseBackUpCommand::class,
                // \Modules\Xot\Console\Commands\WorkerCheck::class,
                // \Modules\Xot\Console\Commands\WorkerRetry::class,
                // \Modules\Xot\Console\Commands\WorkerStop::class,
            ]
        );
    }

    // Method Modules\Xot\Providers\XotServiceProvider::registerViewComposers() is unused
    private function registerViewComposers(): void
    {
        // Factory $view
        // $view->composer('bootstrap-italia::page', BootstrapItaliaComposer::class);
        View::composer('*', XotComposer::class);
        // dddx($res);
    }
} // end class
