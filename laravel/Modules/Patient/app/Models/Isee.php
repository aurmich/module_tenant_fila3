<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;

/**
 * Modello Isee per la gestione dei dati relativi all'ISEE delle pazienti.
 */
class Isee extends BaseModel
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
        'isee_code',
        'isee_value',
        'isee_expiry_date',
        'isee_issue_date',
        'isee_type',
        'isee_document_path',
        'is_valid',
        'notes',
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'isee_value' => 'decimal:2',
        'isee_expiry_date' => 'date',
        'isee_issue_date' => 'date',
        'is_valid' => 'boolean',
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
     * Verifica se l'ISEE è scaduto.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->isee_expiry_date && $this->isee_expiry_date->isPast();
    }

    /**
     * Verifica se l'ISEE è valido per il progetto (sotto i 20.000 euro).
     *
     * @return bool
     */
    public function isEligibleForProject(): bool
    {
        return $this->isee_value <= 20000.00 && !$this->isExpired();
    }

    /**
     * Calcola i giorni rimanenti alla scadenza dell'ISEE.
     *
     * @return int
     */
    public function daysUntilExpiry(): int
    {
        return now()->diffInDays($this->isee_expiry_date, false);
    }

    /**
     * Scope per filtrare gli ISEE validi per il progetto (sotto i 20.000 euro).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEligibleForProject($query)
    {
        return $query->where('isee_value', '<=', 20000.00)
                     ->where('isee_expiry_date', '>', now());
    }
}