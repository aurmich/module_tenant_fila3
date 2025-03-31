<?php

declare(strict_types=1);

namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;

class AppointmentWorkflow extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;
    
    /**
     * Gli stati possibili del workflow.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PATIENT_INFO = 'patient_info_completed';
    public const STATUS_DENTIST_SELECTED = 'dentist_selected';
    public const STATUS_DATE_SELECTED = 'date_selected';
    public const STATUS_TREATMENT_DEFINED = 'treatment_defined';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';
    
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'tenant_id',
        'appointment_id',
        'patient_id',
        'current_step',
        'status',
        'step_data',
        'started_at',
        'completed_at',
        'last_interaction_at',
        'meta',
        'created_by',
        'session_id',
    ];
    
    /**
     * Gli attributi che dovrebbero essere cast a tipi nativi.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'step_data' => 'array',
        'meta' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_interaction_at' => 'datetime',
    ];
    
    /**
     * Relazione con l'appuntamento.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    
    /**
     * Relazione con il paziente.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(\Modules\Patient\Models\Patient::class);
    }
    
    /**
     * Controlla se questo workflow è completato.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_CONFIRMED && $this->completed_at !== null;
    }
    
    /**
     * Controlla se questo workflow è in corso.
     */
    public function isInProgress(): bool
    {
        return !$this->isCompleted() && $this->status !== self::STATUS_CANCELLED;
    }
    
    /**
     * Controlla se questo workflow è cancellato.
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
    
    /**
     * Ottiene l'elenco dei passi del workflow.
     *
     * @return array<string, string>
     */
    public static function getSteps(): array
    {
        return [
            'patient_info' => 'Informazioni Paziente',
            'eligibility_check' => 'Verifica Idoneità',
            'dentist_selection' => 'Selezione Dentista',
            'date_selection' => 'Selezione Data e Ora',
            'treatment_definition' => 'Definizione Trattamento',
            'confirmation' => 'Conferma Appuntamento',
        ];
    }
    
    /**
     * Ottiene l'indice numerico del passo corrente.
     */
    public function getCurrentStepIndex(): int
    {
        $steps = array_keys(self::getSteps());
        return array_search($this->current_step, $steps) !== false
            ? array_search($this->current_step, $steps)
            : 0;
    }
    
    /**
     * Verifica se un determinato passo è completato.
     */
    public function isStepCompleted(string $step): bool
    {
        $stepsMap = [
            'patient_info' => self::STATUS_PATIENT_INFO,
            'eligibility_check' => self::STATUS_PATIENT_INFO, // Stato identico dopo verifica idoneità
            'dentist_selection' => self::STATUS_DENTIST_SELECTED,
            'date_selection' => self::STATUS_DATE_SELECTED,
            'treatment_definition' => self::STATUS_TREATMENT_DEFINED,
            'confirmation' => self::STATUS_CONFIRMED,
        ];
        
        if (!isset($stepsMap[$step])) {
            return false;
        }
        
        // Un passo è completato se lo stato del workflow è uguale o "successivo" allo stato mappato per il passo
        $statuses = [
            self::STATUS_DRAFT,
            self::STATUS_PATIENT_INFO,
            self::STATUS_DENTIST_SELECTED,
            self::STATUS_DATE_SELECTED,
            self::STATUS_TREATMENT_DEFINED,
            self::STATUS_CONFIRMED,
        ];
        
        $currentStatusIndex = array_search($this->status, $statuses);
        $stepStatusIndex = array_search($stepsMap[$step], $statuses);
        
        return $currentStatusIndex !== false && $stepStatusIndex !== false && $currentStatusIndex >= $stepStatusIndex;
    }
}
