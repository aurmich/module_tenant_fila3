<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
<<<<<<< HEAD
=======
<<<<<<< HEAD
use RuntimeException;
=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
use Webmozart\Assert\Assert;

use function Safe\json_encode;
use function Safe\unlink;

trait SushiToJsons
{
    use \Sushi\Sushi;

    public function getSushiRows(): array
    {
        $tbl = $this->getTable();
        $path = TenantService::filePath('database/content/'.$tbl);
        $files = File::glob($path.'/*.json');
        $rows = [];
        foreach ($files as $id => $file) {
            $json = File::json($file);
            $item = [];
            foreach ($this->schema ?? [] as $name => $type) {
                $value = $json[$name] ?? null;
                if (is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT);
                }
                $item[$name] = $value;
            }
            $rows[] = $item;
        }

        return $rows;
    }

    public function getJsonFile(): string
    {
        Assert::string($tbl = $this->getTable());
        Assert::string($id = $this->getKey());

        $filename = 'database/content/'.$tbl.'/'.$id.'.json';
<<<<<<< HEAD

=======
<<<<<<< HEAD
=======

>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
        $file = TenantService::filePath($filename);

        return $file;
    }

    /**
     * bootUpdater function.
     */
    protected static function bootSushiToJsons(): void
    {
        /*
         * During a model create Eloquent will also update the updated_at field so
         * need to have the updated_by field here as well.
         */
        static::creating(
            function ($model): void {
                $model->id = $model->max('id') + 1;
                $model->updated_at = now();
                $model->updated_by = authId();
                $model->created_at = now();
                $model->created_by = authId();
                $data = $model->toArray();
                $item = [];
<<<<<<< HEAD
                if (! is_iterable($model->schema)) {
                    throw new \Exception('Schema not iterable');
                }
=======
<<<<<<< HEAD

                if (! isset($model->schema) || ! is_iterable($model->schema)) {
                    throw new RuntimeException('Schema non definito o non iterabile');
                }

>>>>>>> 48beab0 (.)
                foreach ($model->schema as $name => $type) {
                    $value = $data[$name] ?? null;
                    $item[$name] = $value;
                }
<<<<<<< HEAD
=======

                $content = json_encode($item, JSON_PRETTY_PRINT);
                $file = $model->getJsonFile();
                
                if (! File::exists(\dirname($file))) {
                    File::makeDirectory(\dirname($file), 0755, true, true);
                }
                
                File::put($file, $content);
            }
        );

=======
                if (! is_iterable($model->schema)) {
                    throw new \Exception('Schema not found');
                }
                foreach ($model->schema ?? [] as $name => $type) {
                    $value = $data[$name] ?? null;
                    $item[$name] = $value;
                }
>>>>>>> 48beab0 (.)
                $content = json_encode($item, JSON_PRETTY_PRINT);
                $file = $model->getJsonFile();
                if (! File::exists(\dirname($file))) {
                    File::makeDirectory(\dirname($file), 0755, true, true);
                }
                File::put($file, $content);
            }
        );
<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
        /*
         * updating.
         */
        static::updating(
            function ($model): void {
                $file = $model->getJsonFile();
                $model->updated_at = now();
                $model->updated_by = authId();
                $content = $model->toJson(JSON_PRETTY_PRINT);
                File::put($file, $content);
            }
        );
<<<<<<< HEAD
=======
<<<<<<< HEAD

        /*
         * Deleting a model is slightly different than creating or deleting.
         * For deletes we need to save the model first with the deleted_by field
         */
=======
>>>>>>> 48beab0 (.)
        // -------------------------------------------------------------------------------------
        /*
         * Deleting a model is slightly different than creating or deleting.
         * For deletes we need to save the model first with the deleted_by field
        */

<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
        static::deleting(
            function ($model): void {
                unlink($model->getJsonFile());
            }
        );
<<<<<<< HEAD
=======
<<<<<<< HEAD
    }
}
=======
>>>>>>> 48beab0 (.)

        // ----------------------
    }

    // end function boot
}// end trait Updater
<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
