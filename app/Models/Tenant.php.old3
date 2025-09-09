<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\User;

/**
 * Modello Tenant per la gestione multi-tenant dell'applicazione.
 *
 * @property-read \Modules\Predict\Models\Profile|null $creator
 * @property-read string $url
 * @property-write mixed $name
 * @property-read \Modules\Predict\Models\Profile|null $updater
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static \Modules\Tenant\Database\Factories\TenantFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant query()
 * @method static Tenant|null first()
 * @method static \Illuminate\Database\Eloquent\Collection<int, Tenant> get()
 * @method static Tenant create(array $attributes = [])
 * @method static Tenant firstOrCreate(array $attributes = [], array $values = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant where(string|\Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereNotNull(string|\Illuminate\Contracts\Database\Query\Expression $columns)
 * @method static int count(string $columns = '*')
 *
 * @mixin \Eloquent
 */
class Tenant extends BaseModel
{
    // use SoftDeletes;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'domain',
        'database',
        'slug',
        'settings',
        'is_active',
        'logo',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'province',
        'country',
        'tax_code',
        'vat_number',
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relazione con gli utenti associati al tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relazione con i pazienti associati al tenant.
     */
    public function patients(): HasMany
    {
        return $this->hasMany(\Modules\Patient\Models\Patient::class);
    }

    /**
     * Relazione con gli appuntamenti associati al tenant.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(\Modules\Dental\Models\Appointment::class);
    }

    /**
     * Verifica se il tenant è attivo.
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Genera lo slug dal nome se non fornito.
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;

        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Str::slug($value);
        }
    }

    /**
     * Restituisce l'URL del tenant.
     */
    public function getUrlAttribute(): string
    {
        return $this->domain ?? config('app.url');
    }
}
