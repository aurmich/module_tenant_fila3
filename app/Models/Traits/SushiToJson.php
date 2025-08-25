<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
use Webmozart\Assert\Assert;

use function Safe\json_encode;
use function Safe\json_decode;
use function Safe\file_get_contents;
use function Safe\unlink;

/**
 * Trait SushiToJson.
 * 
 * Questo trait permette ai modelli di utilizzare il pacchetto Sushi per leggere
 * dati da file JSON con isolamento per tenant. Ogni tenant ha i propri file JSON
 * nella directory config/{tenant_name}/database/content/.
 * 
 * @see https://github.com/calebporzio/sushi
 */
trait SushiToJson
{
    use \Sushi\Sushi;

    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     * Il file è specifico per il tenant corrente e la tabella del modello.
     *
     * @return string Percorso completo del file JSON
     */
    public function getJsonFile(): string
    {
        Assert::string($tbl = $this->getTable());
        $path = TenantService::filePath('database/content/'.$tbl.'.json');

        return $path;
    }

    /**
     * Ottiene i dati dal file JSON per il modello Sushi.
     * I dati vengono normalizzati per garantire compatibilità con Eloquent.
     *
     * @return array<int, array<string, mixed>> Array di record per Sushi
     * @throws \Exception Se i dati non sono in formato array valido
     */
    public function getSushiRows(): array
    {
        $path = $this->getJsonFile();

        if (! File::exists($path)) {
            return [];
        }

        /** @var array<int, array<string, mixed>>|mixed $data */
        $data = json_decode(file_get_contents($path), true);
        if (! \is_array($data)) {
            throw new \Exception('Data is not array ['.$path.']');
        }

        // Normalize nested arrays/objects into JSON strings for Sushi
        foreach ($data as $idx => $item) {
            if (\is_array($item)) {
                foreach ($item as $key => $value) {
                    if (\is_array($value) || \is_object($value)) {
                        $value = json_encode($value, JSON_PRETTY_PRINT);
                    }
                    $item[$key] = $value;
                }
            }
            $data[$idx] = $item;
        }

        Assert::isArray($data);

        return $data;
    }

    /**
     * Salva i dati del modello nel file JSON.
     * Crea la directory se non esiste e salva con formattazione JSON.
     *
     * @param array<string, mixed> $data Dati da salvare
     * @return bool True se il salvataggio è riuscito
     */
    public function saveToJson(array $data): bool
    {
        try {
            $file = $this->getJsonFile();
            $directory = dirname($file);
            
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }
            
            $content = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            File::put($file, $content);
            
            return true;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    /**
     * Carica i dati esistenti dal file JSON.
     *
     * @return array<int, array<string, mixed>> Dati esistenti
     */
    protected function loadExistingData(): array
    {
        $path = $this->getJsonFile();
        
        if (!File::exists($path)) {
            return [];
        }
        
        $content = file_get_contents($path);
        $data = json_decode($content, true);
        
        if (!is_array($data)) {
            return [];
        }
        
        // Assicura che i dati siano nel formato corretto
        $normalizedData = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $normalizedData[(int)$key] = $value;
            }
        }
        
        return $normalizedData;
    }

    /**
     * Ottiene l'ID successivo disponibile per un nuovo record.
     *
     * @return int ID successivo disponibile
     */
    protected function getNextId(): int
    {
        $existingData = $this->loadExistingData();
        
        if (empty($existingData)) {
            return 1;
        }
        
        $keys = array_keys($existingData);
        if (empty($keys)) {
            return 1;
        }
        
        $maxId = max($keys);
        return is_numeric($maxId) ? (int) $maxId + 1 : 1;
    }

    /**
     * Boot method per il trait SushiToJson.
     * Gestisce gli eventi di creazione, aggiornamento e cancellazione
     * per sincronizzare automaticamente i dati con i file JSON.
     */
    protected static function bootSushiToJson(): void
    {
        // Evento di creazione
        static::creating(
<<<<<<< HEAD
            function ($model): void {
<<<<<<< HEAD
=======
            function (\Illuminate\Database\Eloquent\Model $model): void {
>>>>>>> 6fc381b (.)
                $file = $model->getJsonFile();
=======
                /** @var static $modelWithTrait */
                $modelWithTrait = $model;
                /** @phpstan-ignore-next-line */
                $file = $modelWithTrait->getJsonFile();
>>>>>>> bf127a0 (.)

                // Load existing rows
                /** @var array<int, array<string, mixed>> $rows */
                $rows = [];
                if (File::exists($file)) {
                    $decoded = json_decode(file_get_contents($file), true);
                    if (\is_array($decoded)) {
                        $rows = $decoded;
                    }
                }

                // Compute next id
                $maxId = 0;
                foreach ($rows as $r) {
<<<<<<< HEAD
<<<<<<< HEAD
                    $maxId = max($maxId, (int) ($r['id'] ?? 0));
=======
=======
>>>>>>> bf127a0 (.)
                    // Ensure each row is an array before accessing offsets
                    if (!\is_array($r)) {
                        continue;
                    }
                    $rawId = $r['id'] ?? 0;
                    $id = \is_numeric($rawId) ? (int) $rawId : 0;
                    $maxId = max($maxId, $id);
<<<<<<< HEAD
>>>>>>> 6fc381b (.)
                }

                $model->id = $maxId + 1;
                $model->updated_at = now();
                if (\function_exists('authId')) {
                    $model->updated_by = authId();
                }
                $model->created_at = now();
                if (\function_exists('authId')) {
                    $model->created_by = authId();
                }

                // Append new row from attributes
                $rows[] = $model->getAttributes();
=======
                }

                $modelWithTrait->setAttribute('id', $maxId + 1);
                $modelWithTrait->setAttribute('updated_at', now());
                if (\function_exists('authId')) {
                    $modelWithTrait->setAttribute('updated_by', authId());
                }
                $modelWithTrait->setAttribute('created_at', now());
                if (\function_exists('authId')) {
                    $modelWithTrait->setAttribute('created_by', authId());
                }

                // Append new row from attributes
                $rows[] = $modelWithTrait->getAttributes();
>>>>>>> bf127a0 (.)

                if (! File::exists(\dirname($file))) {
                    File::makeDirectory(\dirname($file), 0755, true, true);
                }

<<<<<<< HEAD
<<<<<<< HEAD
                File::put($file, json_encode($rows, JSON_PRETTY_PRINT));
=======
                /** @var \Illuminate\Database\Eloquent\Model&\Modules\Tenant\Models\Traits\SushiToJson $modelWithTrait */
                $modelWithTrait = $model;
                $modelWithTrait->saveToJson($rows);
>>>>>>> 6fc381b (.)
            }
        );

        // Evento di aggiornamento
<<<<<<< HEAD
        static::updating(function ($model): void {
=======
        static::updating(function (\Illuminate\Database\Eloquent\Model $model): void {
>>>>>>> 6fc381b (.)
            $model->updated_at = now();
            
            if (\function_exists('authId')) {
                $model->updated_by = authId();
            }
            
            // Aggiorna i dati nel file JSON
<<<<<<< HEAD
            $existingData = $model->loadExistingData();
            if (isset($model->id)) {
                $existingData[$model->id] = $model->toArray();
                $model->saveToJson($existingData);
=======
            /** @var \Illuminate\Database\Eloquent\Model&\Modules\Tenant\Models\Traits\SushiToJson $modelWithTrait */
            $modelWithTrait = $model;
            $existingData = $modelWithTrait->loadExistingData();
            if (isset($model->id)) {
                $existingData[$model->id] = $model->toArray();
                $modelWithTrait->saveToJson($existingData);
>>>>>>> 6fc381b (.)
=======
                /** @phpstan-ignore-next-line */
                $modelWithTrait->saveToJson($rows);
>>>>>>> bf127a0 (.)
            }
        });

<<<<<<< HEAD
        // Evento di cancellazione
<<<<<<< HEAD
        static::deleting(function ($model): void {
            // Rimuove il record dal file JSON
            if (isset($model->id)) {
                $existingData = $model->loadExistingData();
                unset($existingData[$model->id]);
                $model->saveToJson($existingData);
=======
        static::deleting(function (\Illuminate\Database\Eloquent\Model $model): void {
            // Rimuove il record dal file JSON
            if (isset($model->id)) {
                /** @var \Illuminate\Database\Eloquent\Model&\Modules\Tenant\Models\Traits\SushiToJson $modelWithTrait */
                $modelWithTrait = $model;
                $existingData = $modelWithTrait->loadExistingData();
                unset($existingData[$model->id]);
                $modelWithTrait->saveToJson($existingData);
>>>>>>> 6fc381b (.)
=======
        // Evento di aggiornamento
        static::updating(function ($model): void {
            /** @var static $modelWithTrait */
            $modelWithTrait = $model;
            $modelWithTrait->setAttribute('updated_at', now());

            if (\function_exists('authId')) {
                $modelWithTrait->setAttribute('updated_by', authId());
            }

            // Aggiorna i dati nel file JSON
            /** @phpstan-ignore-next-line */
            $existingData = $modelWithTrait->loadExistingData();
            $id = (int) ($modelWithTrait->getAttribute('id') ?? 0);
            if ($id > 0) {
                $existingData[$id] = $modelWithTrait->toArray();
                /** @phpstan-ignore-next-line */
                $modelWithTrait->saveToJson($existingData);
            }
        });

        // Evento di cancellazione
        static::deleting(function ($model): void {
            /** @var static $modelWithTrait */
            $modelWithTrait = $model;
            // Rimuove il record dal file JSON
            $id = (int) ($modelWithTrait->getAttribute('id') ?? 0);
            if ($id > 0) {
                /** @phpstan-ignore-next-line */
                $existingData = $modelWithTrait->loadExistingData();
                unset($existingData[$id]);
                /** @phpstan-ignore-next-line */
                $modelWithTrait->saveToJson($existingData);
>>>>>>> bf127a0 (.)
            }
        });
    }
}
<<<<<<< HEAD

=======
>>>>>>> bf127a0 (.)
