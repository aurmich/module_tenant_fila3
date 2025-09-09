<?php

<<<<<<< HEAD
<<<<<<< HEAD
=======
/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

>>>>>>> 40aab39 (.)
=======
>>>>>>> e53d43b (.)
declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
use Webmozart\Assert\Assert;

use function Safe\json_encode;
use function Safe\json_decode;
use function Safe\file_get_contents;
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> e53d43b (.)

/**
 * Trait SushiToJson.
 * 
 * Questo trait permette ai modelli di utilizzare il pacchetto Sushi per leggere
 * dati da file JSON con isolamento per tenant. Ogni tenant ha i propri file JSON
 * nella directory config/{tenant_name}/database/content/.
 * 
 * @see https://github.com/calebporzio/sushi
 */
<<<<<<< HEAD
=======
use function Safe\unlink;

>>>>>>> 40aab39 (.)
=======
>>>>>>> e53d43b (.)
trait SushiToJson
{
    use \Sushi\Sushi;

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> e53d43b (.)
    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     * Il file è specifico per il tenant corrente e la tabella del modello.
     *
     * @return string Percorso completo del file JSON
     */
    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        Assert::string($tbl);
        $path = TenantService::filePath('database/content/'.$tbl.'.json');
        
        return $path;
    }

    /**
     * Metodo richiesto da Sushi per popolare la tabella in-memory.
     * Delegato a getSushiRows() per mantenere separazione semantica.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
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

        $data = json_decode(file_get_contents($path), true);
        if (! \is_array($data)) {
            throw new \Exception('Data is not array ['.$path.']');
        }

        // Normalize nested arrays/objects into JSON strings for Sushi
        $normalizedData = [];
        foreach ($data as $item) {
            if (\is_array($item)) {
                foreach ($item as $key => $value) {
                    if (\is_array($value) || \is_object($value)) {
                        $value = json_encode($value);
                    }
                    $item[$key] = $value;
                }
                $normalizedData[] = $item;
            }
        }

        Assert::isArray($normalizedData);

        return $normalizedData;
    }

    /**
     * Carica i dati esistenti dal file JSON.
     * Preserva la struttura originale dei dati senza normalizzazione.
     *
     * @return array<int, array<string, mixed>> Dati esistenti
     */
    public function loadExistingData(): array
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
        
        // Assicura che i dati abbiano la struttura corretta
        $result = [];
        foreach ($data as $item) {
            if (is_array($item)) {
                $result[] = $item;
            }
        }
        
        return $result;
    }

    /**
     * Salva i dati del modello nel file JSON.
     * Crea la directory se non esiste e salva con formattazione JSON.
     * Utilizza JSON_PRETTY_PRINT e JSON_UNESCAPED_UNICODE per leggibilità.
     *
     * @param array<int, array<string, mixed>> $data Array di record da salvare
     * @return bool True se il salvataggio è riuscito, false in caso di errore
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
        static::creating(function ($model): void {
            /** @var static $modelWithTrait */
            $modelWithTrait = $model;
            $file = $modelWithTrait->getJsonFile();

            // Load existing data and compute next ID
            $existingData = $modelWithTrait->loadExistingData();
            $rows = $existingData;
            $maxIdFromFile = 0;
            foreach ($rows as $r) {
                if (!\is_array($r)) {
                    continue;
                }
                $rawId = $r['id'] ?? 0;
                $id = \is_numeric($rawId) ? (int) $rawId : 0;
                $maxIdFromFile = max($maxIdFromFile, $id);
            }
            // Safely read current max id from table (Sushi in-memory)
            $maxIdFromDb = 0;
            try {
                /** @var int|null $dbMax */
                $dbMax = static::query()->max('id');
                if (\is_int($dbMax)) {
                    $maxIdFromDb = $dbMax;
                }
            } catch (\Throwable) {
                // ignore if table not initialized yet
            }

            $nextId = max($maxIdFromFile, $maxIdFromDb) + 1;
            $modelWithTrait->setAttribute('id', $nextId);
            $modelWithTrait->setAttribute('updated_at', now());
            $modelWithTrait->setAttribute('created_at', now());
            
            // Set audit fields if available via helper
            $authId = $modelWithTrait->authId();
            if ($authId !== null) {
                $modelWithTrait->setAttribute('updated_by', $authId);
                $modelWithTrait->setAttribute('created_by', $authId);
            }

            // Add new record to existing data
            $existingData[] = $modelWithTrait->getAttributes();

            // Ensure directory exists and save
            $modelWithTrait->ensureDirectoryExists($file);
            $modelWithTrait->saveToJson($existingData);
        });

        static::updating(function ($model): void {
            /** @var static $modelWithTrait */
            $modelWithTrait = $model;
            $modelWithTrait->setAttribute('updated_at', now());

            // Set audit fields if available via helper
            $authId = $modelWithTrait->authId();
            if ($authId !== null) {
                $modelWithTrait->setAttribute('updated_by', $authId);
            }

            // Update existing record
            $existingData = $modelWithTrait->loadExistingData();
            $id = (int) ($modelWithTrait->getAttribute('id') ?? 0);
            
            if ($id > 0) {
                $index = $modelWithTrait->findRowIndexById($existingData, $id);
                if ($index !== null) {
                    $existingData[$index] = $modelWithTrait->toArray();
                    $modelWithTrait->saveToJson($existingData);
                }
            }
        });

        static::deleting(function ($model): void {
            /** @var static $modelWithTrait */
            $modelWithTrait = $model;
            $id = (int) ($modelWithTrait->getAttribute('id') ?? 0);
            
            if ($id > 0) {
                $existingData = $modelWithTrait->loadExistingData();
                $index = $modelWithTrait->findRowIndexById($existingData, $id);
                
                if ($index !== null) {
                    unset($existingData[$index]);
                    $existingData = array_values($existingData);
                    $modelWithTrait->saveToJson($existingData);
                }
            }
        });
    }

    /**
     * Trova l'indice del record nell'array dato un id.
     *
     * @param array<int, array<string, mixed>> $rows
     * @param int $id
     * @return int|null Indice se trovato, altrimenti null
     */
    protected function findRowIndexById(array $rows, int $id): ?int
    {
        foreach ($rows as $index => $row) {
            if (is_array($row) && (int) ($row['id'] ?? 0) === $id) {
                return (int) $index;
            }
        }
        return null;
    }

    /**
     * Ottiene l'ID dell'utente autenticato per i campi di audit.
     *
     * @return int|string|null
     */
    protected function authId(): int|string|null
    {
        if (\function_exists('authId')) {
            return authId();
        }
        
        if (class_exists('\Illuminate\Support\Facades\Auth')) {
            return \Illuminate\Support\Facades\Auth::id();
        }
        
        return null;
    }

    /**
     * Assicura che la directory per il file JSON esista.
     *
     * @param string $filePath
     * @return void
     */
    protected function ensureDirectoryExists(string $filePath): void
    {
        $directory = dirname($filePath);
        
        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
    }
}

<<<<<<< HEAD
=======
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
>>>>>>> 40aab39 (.)
=======
>>>>>>> e53d43b (.)
