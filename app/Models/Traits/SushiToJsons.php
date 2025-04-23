<?php

/**
 * Trait per la gestione di modelli Eloquent con dati persistiti in file JSON.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
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

    /**
     * Ottiene il percorso completo del file JSON per questo modello.
     *
     * @throws \Exception Se la chiave o il nome della tabella non sono stringhe valide
     */
    public function getJsonFile(): string
    {
        Assert::string($tbl = $this->getTable());
        Assert::string($id = $this->getKey());

        $filename = 'database/content/'.$tbl.'/'.$id.'.json';

        $file = TenantService::filePath($filename);

        return $file;
    }

    /**
     * Inizializza il trait Updater.
     * Configura gli eventi del modello per la gestione dei dati JSON.
     */
    protected static function bootSushiToJsons(): void
    {
        /*
         * Durante la creazione di un modello, Eloquent aggiorna anche il campo updated_at,
         * quindi è necessario gestire anche il campo updated_by.
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
                if (! is_iterable($model->schema)) {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                    throw new \Exception('Schema not iterable');
                }
                foreach ($model->schema as $name => $type) {
=======
                    throw new \Exception('Schema not found');
                }
                foreach ($model->schema ?? [] as $name => $type) {
>>>>>>> 9ca9877 (Merge remote-tracking branch 'origin/dev' into dev)
=======
=======
>>>>>>> 09932dc (fix: auto resolve conflict)
                    throw new \Exception('Schema not found');
                }
                foreach ($model->schema ?? [] as $name => $type) {
=======
<<<<<<< HEAD
                    throw new \Exception('Schema not found');
                }
                foreach ($model->schema ?? [] as $name => $type) {
=======
                    throw new \Exception('Schema not iterable');
                }
                foreach ($model->schema as $name => $type) {
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
<<<<<<< HEAD
>>>>>>> ad1566e (fix: auto resolve conflict)
=======
=======
                    throw new \Exception('Schema not iterable');
                }
                foreach ($model->schema as $name => $type) {
>>>>>>> 7e34c9c (.)
>>>>>>> 09932dc (fix: auto resolve conflict)
=======
                    throw new \Exception('Schema not iterable');
                }
                foreach ($model->schema ?? [] as $name => $type) {
>>>>>>> 7afe333 (.)
                    $value = $data[$name] ?? null;
                    $item[$name] = $value;
                }
                $content = json_encode($item, JSON_PRETTY_PRINT);
                $file = $model->getJsonFile();
                if (! File::exists(\dirname($file))) {
                    File::makeDirectory(\dirname($file), 0755, true, true);
                }
                File::put($file, $content);
            }
        );

        /*
         * Aggiornamento del modello.
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

        /*
         * Eliminazione del modello.
         */
        static::deleting(
            function ($model): void {
                unlink($model->getJsonFile());
            }
        );
    }
}
