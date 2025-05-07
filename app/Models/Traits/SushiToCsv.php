<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use League\Csv\Writer;
use Modules\Tenant\Services\TenantService;
use Webmozart\Assert\Assert;

trait SushiToCsv
{
    use \Sushi\Sushi;

    public function getSushiRows(): array
    {
<<<<<<< HEAD
        // return CSV::fromFile(__DIR__.'/roles.csv')->toArray();
        // load the CSV document from a file path
        $csv = Reader::createFromPath($this->getCsvPath(), 'r');
        // $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        // returns all the records as
        $records = $csv->getRecords(); // an Iterator object containing arrays
        // $records = $csv->getRecordsAsObject(MyDTO::class); // an Iterator object containing MyDTO objects
=======
<<<<<<< HEAD
        $csv = Reader::createFromPath($this->getCsvPath(), 'r');
        $csv->setHeaderOffset(0);
        
        $records = $csv->getRecords();
        $rows = iterator_to_array($records);
        
        return array_values($rows);
=======
        // return CSV::fromFile(__DIR__.'/roles.csv')->toArray();
        // load the CSV document from a file path
        $csv = $this->getCsvPath();
        $records = $csv->getRecords();
>>>>>>> 48beab0 (.)
        $rows = iterator_to_array($records);
        $rows = array_values($rows);

        return $rows;
<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
    }

    public function getCsvPath(): string
    {
        Assert::string($tbl = $this->getTable());
        $file = $tbl.'.csv';
        $path = TenantService::filePath($file);

        return $path;
    }

    public function getCsvHeader(): array
    {
        $reader = Reader::createFromPath($this->getCsvPath(), 'r');
        $reader->setHeaderOffset(0);

        return $reader->getHeader();
    }

    /**
     * bootUpdater function.
     */
    protected static function bootSushiToCsv(): void
    {
        /*
         * During a model create Eloquent will also update the updated_at field so
         * need to have the updated_by field here as well.
         */
        static::creating(
            function ($model): void {
                $model->id = (int) $model->max('id') + 1;
                $model->updated_at = now();
                $model->updated_by = authId();
                $model->created_at = now();
                $model->created_by = authId();

                $data = $model->toArray();
                $writer = Writer::createFromPath($model->getCsvPath(), 'a+');
                $header = $model->getCsvHeader();

                $item = [];
                foreach ($header as $name) {
                    $value = $data[$name] ?? null;
                    $item[$name] = $value;
                }

                $writer->insertOne($item);
            }
        );
<<<<<<< HEAD
=======
<<<<<<< HEAD

=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
        /*
         * updating.
         */
        static::updating(
            function ($model): void {
                $rows = $model->getSushiRows();
                $rows = Arr::keyBy($rows, 'id');
                $id = $model->getKey();
                $model->updated_at = now();
                $model->updated_by = authId();
                $new = array_merge($rows[$id], $model->toArray());
                $rows[$id] = $new;
                $dataArray = array_values($rows);
<<<<<<< HEAD
                // $header=$model->getCsvHeader();
                $header = array_keys($new);
=======
                $header = array_keys($new);
<<<<<<< HEAD
                
=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
                $writer = Writer::createFromPath($model->getCsvPath(), 'w+');
                $writer->insertOne($header);
                $writer->insertAll($dataArray);
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
                $rows = $model->getSushiRows();
                $rows = Arr::keyBy($rows, 'id');
                $id = $model->getKey();
                unset($rows[$id]);
                $dataArray = array_values($rows);
                $header = $model->getCsvHeader();
<<<<<<< HEAD
=======
<<<<<<< HEAD
                
=======
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
                $writer = Writer::createFromPath($model->getCsvPath(), 'w+');
                $writer->insertOne($header);
                $writer->insertAll($dataArray);
            }
        );
<<<<<<< HEAD

        // ----------------------
=======
<<<<<<< HEAD
=======

        // ----------------------
>>>>>>> origin/dev
>>>>>>> 48beab0 (.)
    }
}
