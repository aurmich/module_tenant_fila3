<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Patient\Models;
=======
namespace Modules\Patient\app\Models;
>>>>>>> 059ca8d4 (.)

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
<<<<<<< HEAD
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Xot\Models\XotBaseModel;
=======
use Modules\Tenant\app\Traits\BelongsToTenant;
>>>>>>> 059ca8d4 (.)

class Anamnesis extends XotBaseModel
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'allergies' => 'array',
            'chronic_diseases' => 'array',
            'medications' => 'array',
            'family_history' => 'array',
            'lifestyle' => 'array',
        ]);
    }

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
