<?php

declare(strict_types=1);

namespace Modules\Patient\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\app\Traits\BelongsToTenant;

class Anamnesis extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'allergies',
        'chronic_diseases',
        'medications',
        'family_history',
        'lifestyle',
        'notes',
    ];

    protected $casts = [
        'allergies' => 'array',
        'chronic_diseases' => 'array',
        'medications' => 'array',
        'family_history' => 'array',
        'lifestyle' => 'array',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function hasAllergies(): bool
    {
        return !empty($this->allergies);
    }

    public function hasChronicDiseases(): bool
    {
        return !empty($this->chronic_diseases);
    }

    public function isOnMedications(): bool
    {
        return !empty($this->medications);
    }
} 