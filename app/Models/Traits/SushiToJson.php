<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
use Webmozart\Assert\Assert;

use function Safe\json_encode;
use function Safe\json_decode;
use function Safe\file_get_contents;
use function Safe\unlink;

trait SushiToJson
{
    use \Sushi\Sushi;

    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $path= TenantService::filePath('database/content/'.$tbl.'.json');
        return $path;
    }

    public function getSushiRows(): array
    {
        
        $path = $this->getJsonFile();
        $data = json_decode(file_get_contents($path), true);
        if(!is_array($data)){
            throw new \Exception('Data is not array ['.$path.']');
        }
        foreach($data as $id => $item){
            if(is_array($item)){
                foreach($item as $key => $value){
                    if(is_array($value)){
                        $value=json_encode($value);
                    }
                    $item[$key]=$value;
                }
            }
            $data[$id]=$item;
        }
        Assert::isArray($data);
        return $data;
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
                /*
                $model->id = $model->max('id') + 1;
                $model->updated_at = now();
                $model->updated_by = authId();
                $model->created_at = now();
                $model->created_by = authId();
                $data = $model->toArray();
                $item = [];
                if (! is_iterable($model->schema)) {
                    throw new \Exception('Schema not iterable');
                }
                foreach ($model->schema as $name => $type) {
                    $value = $data[$name] ?? null;
                    $item[$name] = $value;
                }
                $content = json_encode($item, JSON_PRETTY_PRINT);
                $file = $model->getJsonFile();
                if (! File::exists(\dirname($file))) {
                    File::makeDirectory(\dirname($file), 0755, true, true);
                }
                File::put($file, $content);
                */
                dddx('wip');
            }
        );
        /*
         * updating.
         */
        static::updating(
            function ($model): void {
                /*
                $file = $model->getJsonFile();
                $model->updated_at = now();
                $model->updated_by = authId();
                $content = $model->toJson(JSON_PRETTY_PRINT);
                File::put($file, $content);
                */
                dddx('wip');
            }
        );
        // -------------------------------------------------------------------------------------
        /*
         * Deleting a model is slightly different than creating or deleting.
         * For deletes we need to save the model first with the deleted_by field
        */

        static::deleting(
            function ($model): void {
                dddx('wip');
                //unlink($model->getJsonFile());
            }
        );

        // ----------------------
    }

    // end function boot
}// end trait Updater
