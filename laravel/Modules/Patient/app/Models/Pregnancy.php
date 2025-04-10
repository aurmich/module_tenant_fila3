<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;

/**
 * Modello Pregnancy per la gestione dei dati relativi alla gravidanza.
 */
class Pregnancy extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'patient_id',
        'expected_delivery_date',
        'weeks_pregnant',
        'trimester',
        'high_risk',
        'notes',
        'last_checkup_date',
        'next_checkup_date',
        'healthcare_provider',
        'healthcare_facility',
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expected_delivery_date' => 'date',
        'last_checkup_date' => 'date',
        'next_checkup_date' => 'date',
        'high_risk' => 'boolean',
        'weeks_pregnant' => 'integer',
    ];

    /**
     * Relazione con la paziente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Calcola il trimestre in base alle settimane di gravidanza.
     *
     * @return int
     */
    public function calculateTrimester(): int
    {
        if ($this->weeks_pregnant <= 13) {
            return 1;
        } elseif ($this->weeks_pregnant <= 26) {
            return 2;
        } else {
            return 3;
        }
    }

    /**
     * Aggiorna automaticamente il trimestre quando vengono aggiornate le settimane di gravidanza.
     *
     * @return void
     */
    public function updateTrimester(): void
    {
        $this->trimester = $this->calculateTrimester();
        $this->save();
    }

    /**
     * Verifica se la gravidanza è ad alto rischio.
     *
     * @return bool
     */
    public function isHighRisk(): bool
    {
        return $this->high_risk;
    }

    /**
     * Calcola i giorni rimanenti alla data prevista del parto.
     *
     * @return int
     */
    public function daysUntilDelivery(): int
    {
        return now()->diffInDays($this->expected_delivery_date, false);
    }
}