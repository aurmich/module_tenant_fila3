<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Xot\Models\XotBaseModel;

class Patient extends XotBaseModel
{
    use SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'surname',
        'fiscal_code',
        'birth_date',
        'phone',
        'email',
        'address',
        'city',
        'postal_code',
        'province',
        'country',
        'is_pregnant',
        'isee_code',
        'isee_value',
        'isee_expiry_date',
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
            'birth_date' => 'date',
            'isee_expiry_date' => 'date',
            'is_pregnant' => 'boolean',
            'isee_value' => 'decimal:2',
        ]);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function anamnesis(): HasMany
    {
        return $this->hasMany(Anamnesis::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(\Modules\Dental\Models\Appointment::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date->age;
    }

    public function isIseeExpired(): bool
    {
        return $this->isee_expiry_date && $this->isee_expiry_date->isPast();
    }
}
