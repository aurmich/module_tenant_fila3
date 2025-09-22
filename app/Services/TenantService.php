<?php

declare(strict_types=1);

namespace Modules\Tenant\Services;

// use Illuminate\Support\Facades\Storage;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\GetTenantNameAction;
use Nwidart\Modules\Facades\Module;
use Webmozart\Assert\Assert;

use function Safe\preg_replace;
use function Safe\realpath;

/**
 * Class TenantService.
 */
class TenantService
{
    /**
     * Undocumented function.
     */
    public static function getName(): string
    {
        return app(GetTenantNameAction::class)->execute();
    }

    // end function

    /**
     * Undocumented function.
     */
    public static function filePath(string $filename): string
    {
        if (isRunningTestBench()) {
<<<<<<< HEAD
            return realpath(__DIR__ . '/../Config') . DIRECTORY_SEPARATOR . $filename;
        }
        $path = base_path('config/' . self::getName() . '/' . $filename);
=======
            return realpath(__DIR__.'/../Config').DIRECTORY_SEPARATOR.$filename;
        }
        $path = base_path('config/'.self::getName().'/'.$filename);
>>>>>>> 1cbc182 (.)

        return str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
    }

    // end function
    /**
     * tenant config.
     * ret_old \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed.
     * ret_old1 \Illuminate\Config\Repository|mixed.
     */
<<<<<<< HEAD
    public static function config(string $key, string|int|array|null $_default = null): float|int|string|array|null
    {
        /*
         * if(app()->runningInConsole()){
         * return config($key, $default);
         * }
         */
=======
    public static function config(string $key, string|int|array|null $default = null): float|int|string|array|null
    {
        /*
        if(app()->runningInConsole()){
            return config($key, $default);
        }
        */
>>>>>>> 1cbc182 (.)
        if (inAdmin() && Str::startsWith($key, 'morph_map') && Request::segment(2) !== null) {
            $module_name = Request::segment(2);
            $models = getModuleModels($module_name);
            $original_conf = config('morph_map');
<<<<<<< HEAD
            if (!\is_array($original_conf)) {
=======
            if (! \is_array($original_conf)) {
>>>>>>> 1cbc182 (.)
                $original_conf = [];
            }

            $path = self::filePath('morph_map.php');
            $tenant_conf = [];
            if (File::exists($path)) {
                $tenant_conf = File::getRequire($path);
            }

<<<<<<< HEAD
            if (!\is_array($tenant_conf)) {
                $tenant_conf = [];
            }

            $merge_conf = collect($models)->merge($original_conf)->merge($tenant_conf)->all();
=======
            if (! \is_array($tenant_conf)) {
                $tenant_conf = [];
            }

            $merge_conf = collect($models)
                ->merge($original_conf)
                ->merge($tenant_conf)
                ->all();
>>>>>>> 1cbc182 (.)
            Config::set('morph_map', $merge_conf);
            $res = config($key);

            if (is_numeric($res) || \is_string($res) || \is_array($res)) {
                return $res;
            }

<<<<<<< HEAD
            throw new \Exception('[' . __LINE__ . '][' . class_basename(__CLASS__) . ']');
=======
            throw new \Exception('['.__LINE__.']['.class_basename(__CLASS__).']');
>>>>>>> 1cbc182 (.)
        }

        $group = collect(explode('.', $key))->first();

        $original_conf = config($group);
        $tenant_name = self::getName();

<<<<<<< HEAD
        $config_name = str_replace('/', '.', $tenant_name) . '.' . $group;
        $extra_conf = config($config_name);

        if (!\is_array($original_conf)) {
            $original_conf = [];
        }

        if (!\is_array($extra_conf)) {
=======
        $config_name = str_replace('/', '.', $tenant_name).'.'.$group;
        $extra_conf = config($config_name);

        if (! \is_array($original_conf)) {
            $original_conf = [];
        }

        if (! \is_array($extra_conf)) {
>>>>>>> 1cbc182 (.)
            $extra_conf = [];
        }

        // -- ogni modulo ha la sua connessione separata
        // -- replicazione liveuser con lu.. tenere lu anche in database
        if ($key === 'database') {
            $default = Arr::get($extra_conf, 'default', null);
            if ($default === null) {
                $default = Arr::get($original_conf, 'default', null);
            }
            if ($default === null) {
                // $default = 'mysql';
                // $default = env('DB_CONNECTION', 'mysql');
                $default = config('database.default');
            }

            /**
             * @var Collection<\Nwidart\Modules\Module>
             */
            $modules = Module::toCollection();
            foreach ($modules as $module) {
                $name = $module->getSnakeName();
<<<<<<< HEAD
                if (!isset($extra_conf['connections'][$name])) {
                    // Skip if the default connection doesn't exist in extra_conf (e.g., 'testing' connection)
                    if (!isset($extra_conf['connections'][$default])) {
=======
                if (! isset($extra_conf['connections'][$name])) {
                    // Skip if the default connection doesn't exist in extra_conf (e.g., 'testing' connection)
                    if (! isset($extra_conf['connections'][$default])) {
>>>>>>> 1cbc182 (.)
                        continue;
                    }
                    $extra_conf['connections'][$name] = $extra_conf['connections'][$default];
                }
            }
        }

        $merge_conf = collect($original_conf)->merge($extra_conf)->all();
        if ($group === null) {
<<<<<<< HEAD
            throw new \Exception('[' . __LINE__ . '][' . class_basename(self::class) . ']');
=======
            throw new \Exception('['.__LINE__.']['.class_basename(self::class).']');
>>>>>>> 1cbc182 (.)
        }

        Config::set($group, $merge_conf);

        $res = config($key);

<<<<<<< HEAD
        if ($res === null && isset($default)) {
            $index = Str::after($key, $group . '.');
            $data = Arr::set($extra_conf, $index, $default);
            /*
             * dddx([
             * 'key' => $key,
             * 'group' => $group,
             * 'index' => $index,
             * '$config_name' => $config_name,
             * 'data' => $data,
             * ]);
             */
            throw new \Exception('[' . __LINE__ . '][' . class_basename(self::class) . ']');

            // self::saveConfig($group,$data);
=======
        if ($res === null && $default !== null) {
            $index = Str::after($key, $group.'.');
            $data = Arr::set($extra_conf, $index, $default);
            /*
            dddx([
                'key' => $key,
                'group' => $group,
                'index' => $index,
                '$config_name' => $config_name,
                'data' => $data,
            ]);
            */
            throw new \Exception('['.__LINE__.']['.class_basename(self::class).']');
            // self::saveConfig($group,$data);

>>>>>>> 1cbc182 (.)
            // return $default;
        }

        // dddx(gettype($res));//array;
        if (is_numeric($res) || \is_string($res) || \is_array($res) || $res === null) {
            return $res;
        }

        dddx($res);
<<<<<<< HEAD
        throw new \Exception('[' . __LINE__ . '][' . class_basename(self::class) . ']');

=======
        throw new \Exception('['.__LINE__.']['.class_basename(self::class).']');
>>>>>>> 1cbc182 (.)
        // return $res;
    }

    public static function getConfigPath(string $key): string
    {
        $name = self::getName();

<<<<<<< HEAD
        return str_replace('/', '.', $name) . '.' . $key;
=======
        return str_replace('/', '.', $name).'.'.$key;
>>>>>>> 1cbc182 (.)
    }

    public static function getConfig(string $name): array
    {
<<<<<<< HEAD
        $path = self::filePath($name . '.php');
=======
        $path = self::filePath($name.'.php');
>>>>>>> 1cbc182 (.)
        try {
            $data = File::getRequire($path);
        } catch (\Exception $e) {
            $data = [];
        }
<<<<<<< HEAD
        if (!\is_array($data)) {
=======
        if (! \is_array($data)) {
>>>>>>> 1cbc182 (.)
            $data = [];
        }

        return $data;
    }

    public static function saveConfig(string $name, array $data): void
    {
<<<<<<< HEAD
        $path = self::filePath($name . '.php');
=======
        $path = self::filePath($name.'.php');
>>>>>>> 1cbc182 (.)

        $config_data = [];
        if (File::exists($path)) {
            $config_data = File::getRequire($path);
        }

<<<<<<< HEAD
        if (!\is_array($config_data)) {
=======
        if (! \is_array($config_data)) {
>>>>>>> 1cbc182 (.)
            $config_data = [];
        }

        $config_data = array_merge_recursive_distinct($config_data, $data); // funzione in helper

        $config_data = Arr::sortRecursive($config_data);

<<<<<<< HEAD
        $path = self::filePath($name . '.php');
        $content = '<?php' . \chr(13) . \chr(13) . ' return ' . var_export($config_data, true) . ';';
        $content = str_replace('\\\\', '\\', $content);

        File::put($path . '', $content);
=======
        $path = self::filePath($name.'.php');
        $content = '<'.'?php'.\chr(13).\chr(13).' return '.var_export($config_data, true).';';
        $content = str_replace('\\\\', '\\', $content);

        File::put($path.'', $content);
>>>>>>> 1cbc182 (.)
    }

    /**
     * Undocumented function.
     */
<<<<<<< HEAD
    public static function modelClass(string $name): null|string
=======
    public static function modelClass(string $name): ?string
>>>>>>> 1cbc182 (.)
    {
        $name = Str::singular($name);
        $name = Str::snake($name);

        // $class = \Illuminate\Database\Eloquent\Relations\Relation::getMorphedModel($name);
<<<<<<< HEAD
        $class = self::config('morph_map.' . $name);

        if ($class === null) {
            $models = getAllModulesModels();
            if (!isset($models[$name])) {
                throw new \Exception('model unknown [' .
                $name .
                ']
                [line:' .
                __LINE__ .
                '][' .
                basename(__FILE__) .
                    ']');
=======
        $class = self::config('morph_map.'.$name);

        if ($class === null) {
            $models = getAllModulesModels();
            if (! isset($models[$name])) {
                throw new \Exception('model unknown ['.$name.']
                [line:'.__LINE__.']['.basename(__FILE__).']');
>>>>>>> 1cbc182 (.)
            }

            $class = $models[$name];
            $data = [];
            $data[$name] = $class;
            self::saveConfig('morph_map', $data);
        }

        // $model = app($class);
<<<<<<< HEAD
        if (!\is_string($class)) {
            if (\is_array($class)) {
                Assert::string($res = $class[0], __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
=======
        if (! \is_string($class)) {
            if (\is_array($class)) {
                Assert::string($res = $class[0]);
>>>>>>> 1cbc182 (.)

                return $res;
            }

<<<<<<< HEAD
            dddx([
                'name' => $name,
                'class' => $class,
            ]);
=======
            dddx(
                [
                    'name' => $name,
                    'class' => $class,
                ]
            );
>>>>>>> 1cbc182 (.)
        }

        // 272    Method Modules\Tenant\Services\TenantService::model()
        // should return Illuminate\Database\Eloquent\Model
        // but returns object.
        // $model = new $class();
<<<<<<< HEAD
        if (!\is_string($class)) {
            throw new \Exception('[' . __LINE__ . '][' . class_basename(self::class) . ']');
=======
        if (! \is_string($class)) {
            throw new \Exception('['.__LINE__.']['.class_basename(self::class).']');
>>>>>>> 1cbc182 (.)
        }

        return $class;
    }

    /**
     * @throws \ReflectionException
     */
    public static function model(string $name): Model
    {
        $class = self::modelClass($name);

        $model = app($class);
        Assert::isInstanceOf($model, Model::class);

        return $model;
    }

    /**
     * deprecated non dobbiamo usare in tenant robe di panel .. tenant dipende solo da xot.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ReflectionException
     *                              public static function modelEager(string $name): \Illuminate\Database\Eloquent\Builder {
     *                              $model = self::model($name);
     *                              // Strict comparison using === between null and Illuminate\Database\Eloquent\Model will always evaluate to false.
     *                              // if (null === $model) {
     *                              // return null;
     *                              //    throw new \Exception('model is null');
     *                              // }
     *                              $panel = PanelService::make()->get($model);
     *                              // Strict comparison using === between null and Modules\Cms\Contracts\PanelContract will always evaluate to false.
     *                              // if (null === $panel) {
     *                              // return null;
     *                              //    throw new \Exception('panel is null');
     *                              // }
     *                              $with = $panel->with();
     *                              // $model = $model->load($with);
     *                              $with = $panel->with;
     *                              $model = $model->with($with);
     *
     * return $model;
     * }
     */

    /**
     * Find the path to a localized Markdown resource. copiata da jetstream.php.
     */
    public static function localizedMarkdownPath(string $name): string
    {
<<<<<<< HEAD
        preg_replace('#(\.md)$#i', '.' . app()->getLocale() . '$1', $name);
        $lang = app()->getLocale();
        $paths = [
            self::filePath('lang/' . $lang . '/' . $name),
            self::filePath($name),
        ];

        $path = Arr::first($paths, file_exists(...));
        if (!\is_string($path)) {
            return '#';

=======
        preg_replace('#(\.md)$#i', '.'.app()->getLocale().'$1', $name);
        $lang = app()->getLocale();
        $paths = [
            self::filePath('lang/'.$lang.'/'.$name),
            self::filePath($name),
        ];

        $path = Arr::first(
            $paths,
            static fn ($path): bool => file_exists($path)
        );
        if (! \is_string($path)) {
            return '#';
>>>>>>> 1cbc182 (.)
            // throw new Exception('[' . __LINE__ . '][' . __FILE__ . ']');
        }

        return $path;
    }

<<<<<<< HEAD
    public static function trans(string $key): string
    {
        $lang = app()->getLocale();
        $trans_file = Str::of($key)
            ->before('.')
            ->append('.php')
            ->toString();
        $arr_key = Str::of($key)->after('.')->toString();
        $path = self::filePath('lang/' . $lang . '/' . $trans_file);
        $data = File::getRequire($path);
        Assert::isArray($data);
        Assert::string($res = Arr::get($data, $arr_key));
=======
    

    public static function trans(string $key): string
    {

        $lang = app()->getLocale();
        $trans_file = Str::of($key)->before('.')->append('.php')->toString();
        $arr_key=Str::of($key)->after('.')->toString();
        $path = self::filePath('lang/'.$lang.'/'.$trans_file);
        $data = File::getRequire($path);
        Assert::isArray($data);
        Assert::string($res=Arr::get($data, $arr_key));
>>>>>>> 1cbc182 (.)
        return $res;
    }

    public static function getConfigNames(): array
    {
        $name = self::getName();
        // if (app()->runningInConsole()) {
        // File::makeDirectory(config_path($name), 0755, true, true);
        // File::copyDirectory(realpath(__DIR__.'/../Config'), config_path($name));

        //  Using $this when not in object context
        // $this->publishes([
        //    __DIR__ . '/../config/xra.php' => config_path('xra.php'),
        // ], 'config');

        // Using $this when not in object context
        // $this->mergeConfigFrom(, 'xra');
        // $path = __DIR__.'/../config/xra.php';
        // $key = 'xra';
        // $config = app()->make('config');
        // $config->set($key, array_merge(
        //    require $path, $config->get($key, [])
        // ));
        // dddx($name);
        // dddx();
        // }

        $dir = config_path($name);
        $dir = app(\Modules\Xot\Actions\File\FixPathAction::class)->execute($dir);

        $files = File::files($dir);

        return collect($files)
<<<<<<< HEAD
            ->filter(static fn($item): bool => $item->getExtension() === 'php')
            ->map(static fn($item, $k): array => [
                'id' => $k + 1,
                'name' => $item->getFilenameWithoutExtension(),
            ])
            ->values()
=======
            ->filter(
                static fn ($item): bool => $item->getExtension() === 'php'
            )
            ->map(
                static fn ($item, $k): array => [
                    'id' => $k + 1,
                    'name' => $item->getFilenameWithoutExtension(),
                ]
            )->values()
>>>>>>> 1cbc182 (.)
            ->all();
    }

    /**
     * @return array<string>
     */
    public static function allModules(): array
    {
        $filePath = static::filePath('modules_statuses.json');
        $contents = File::get($filePath);
        try {
            /** @var array */
            $json = \Safe\json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
<<<<<<< HEAD
            throw new \Exception(
                $e->getMessage() . '[' . $filePath . '][' . __LINE__ . '][' . basename(__FILE__) . ']',
            );
        }
        $modules = [];
        foreach ($json as $name => $enabled) {
            if (!$enabled) {
                continue;
            }

            if (!File::exists(base_path('Modules/' . $name))) {
=======
            throw new \Exception($e->getMessage().'['.$filePath.']['.__LINE__.']['.basename(__FILE__).']');
        }
        $modules = [];
        foreach ($json as $name => $enabled) {
            if (! $enabled) {
                continue;
            }

            if (! File::exists(base_path('Modules/'.$name))) {
>>>>>>> 1cbc182 (.)
                continue;
            }

            $modules[] = $name;
        }

        return $modules;
    }
}
