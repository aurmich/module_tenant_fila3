<?php

declare(strict_types=1);

namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Patient\Models\Patient;
use Modules\Tenant\Traits\BelongsToTenant;

class Appointment extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'dentist_id',
        'date',
        'start_time',
        'end_time',
        'type',
        'status',
        'notes',
        'treatment_plan',
        'is_emergency',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_emergency' => 'boolean',
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
        // Assumendo che esista un modello Dentist, da implementare in futuro
        return $this->belongsTo(Dentist::class);
    }

    /**
     * Verifica se l'appuntamento è in corso.
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        $now = now();
        return $now->between($this->start_time, $this->end_time);
    }

    /**
     * Verifica se l'appuntamento è completato.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Verifica se l'appuntamento è cancellato.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Verifica se l'appuntamento è confermato.
     *
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Verifica se l'appuntamento è imminente (entro le prossime 24 ore).
     *
     * @return bool
     */
    public function isUpcoming(): bool
    {
        $now = now();
        return $now->lt($this->start_time) && $now->diffInHours($this->start_time) <= 24;
    }
}
