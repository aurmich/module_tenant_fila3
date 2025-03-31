<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * BaseModel per il modulo Patient.
 * 
 * Estende le funzionalità di Eloquent Model con
 * metodi e proprietà specifiche per il contesto Patient.
 */
class BaseModel extends Model
{
    /**
     * Indica se il modello deve utilizzare timestamp.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Il formato per i timestamp del modello.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Costruttore.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Esegue l'override del metodo boot.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
    }

    /**
     * Imposta il tenant ID per il modello.
     *
     * @param int $tenantId
     * @return $this
     */
    public function setTenantId(int $tenantId): self
    {
        $this->tenant_id = $tenantId;
        return $this;
    }
}
