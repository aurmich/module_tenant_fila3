<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToJson;

/**
 * Modello di test per il trait SushiToJson.
 * Utilizzato esclusivamente per i test del trait.
 */
class TestSushiModel extends Model
{
    use SushiToJson;

    /**
     * La tabella associata al modello.
     */
    protected $table = 'test_sushi';

    /**
     * Gli attributi che sono assegnabili in massa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'metadata',
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
        ];
    }
}
