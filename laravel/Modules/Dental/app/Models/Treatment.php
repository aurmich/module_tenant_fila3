<?php

declare(strict_types=1);

namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Pregnancy;
use Modules\Tenant\Traits\BelongsToTenant;

/**
 * Modello Treatment per la gestione dei trattamenti odontoiatrici.
 */
class Treatment extends BaseModel
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
        'dentist_id',
        'appointment_id',
        'type',
        'description',
        'notes',
        'status',
        'start_date',
        'end_date',
        'cost',
        'is_covered',
        'is_pregnancy_safe',
        'teeth_involved',
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cost' => 'decimal:2',
        'is_covered' => 'boolean',
        'is_pregnancy_safe' => 'boolean',
        'teeth_involved' => 'array',
    ];

    /**
     * Relazione con il paziente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relazione con il dentista.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dentist(): BelongsTo
    {
        return $this->belongsTo(Dentist::class);
    }

    /**
     * Relazione con l'appuntamento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Verifica se il trattamento è completato.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Verifica se il trattamento è in corso.
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Verifica se il trattamento è coperto dal progetto.
     *
     * @return bool
     */
    public function isCovered(): bool
    {
        return $this->is_covered;
    }

    /**
     * Scope per filtrare i trattamenti completati.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope per filtrare i trattamenti in corso.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope per filtrare i trattamenti coperti dal progetto.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCovered($query)
    {
        return $query->where('is_covered', true);
    }
    
    /**
     * Verifica se il trattamento è sicuro per pazienti in gravidanza.
     *
     * @return bool
     */
    public function isSafeForPregnancy(): bool
    {
        // Lista di tipi di trattamenti sicuri per la gravidanza
        $safeTypes = [
            'check-up',
            'cleaning',
            'emergency',
            'consultation',
            'preventive',
        ];
        
        return in_array($this->type, $safeTypes);
    }
    
    /**
     * Verifica se il paziente associato è in gravidanza.
     *
     * @return bool
     */
    public function hasPregnantPatient(): bool
    {
        if (!$this->patient_id) {
            return false;
        }
        
        return Pregnancy::where('patient_id', $this->patient_id)
            ->whereNull('deleted_at')
            ->exists();
    }
    
    /**
     * Scope per filtrare i trattamenti sicuri per la gravidanza.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSafeForPregnancy($query)
    {
        return $query->whereIn('type', [
            'check-up',
            'cleaning',
            'emergency',
            'consultation',
            'preventive',
        ]);
    }
}