<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\File;
>>>>>>> afc9385 (.)
use Modules\Tenant\Models\Traits\SushiToJson;

/**
 * Modello di test per il trait SushiToJson.
 * Utilizzato esclusivamente per i test del trait.
 */
class TestSushiModel extends Model
{
    use SushiToJson;

    /**
<<<<<<< HEAD
=======
     * Schema esplicito per Sushi quando non ci sono righe.
     *
     * @var array<string, string>
     */
    protected $schema = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'metadata' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
>>>>>>> afc9385 (.)
     * La tabella associata al modello.
     */
    protected $table = 'test_sushi';

    /**
<<<<<<< HEAD
=======
     * Override del path JSON in ambiente di test per NON toccare config/local/saluteora/.
     */
    public function getJsonFile(): string
    {
        if (app()->environment('testing')) {
            $dir = storage_path('tests/sushi-json');
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0755, true, true);
            }
            return $dir.'/test_sushi.json';
        }

        // fallback: usa il comportamento del trait (replicato qui)
        $tbl = $this->getTable();
        /** @var class-string $tenantService */
        $tenantService = \Modules\Tenant\Services\TenantService::class;
        return $tenantService::filePath('database/content/'.$tbl.'.json');
    }

    /**
     * Implementa il metodo getRows() richiesto da Sushi.
     * Delega al metodo getSushiRows() del trait.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * Nota: non esporre i metodi protetti del trait.
     * I metodi del trait vengono utilizzati internamente dagli eventi Eloquent.
     */

    /**
>>>>>>> afc9385 (.)
     * Gli attributi che sono assegnabili in massa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'metadata',
<<<<<<< HEAD
=======
        'created_by',
        'updated_by',
>>>>>>> afc9385 (.)
    ];

    /**
     * Gli attributi che devono essere convertiti.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
<<<<<<< HEAD
=======
            'created_by' => 'integer',
            'updated_by' => 'integer',
>>>>>>> afc9385 (.)
        ];
    }
}
