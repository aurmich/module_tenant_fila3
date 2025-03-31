<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;

class Patient extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'name',
        'surname',
        'fiscal_code',
        'birth_date',
        'phone',
        'email',
        'isee_expiry_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'isee_expiry_date' => 'date',
    ];

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