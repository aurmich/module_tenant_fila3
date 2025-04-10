<?php

declare(strict_types=1);

namespace Modules\Tenant\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Tenant\Models\Tenant;

/**
 * Trait BelongsToTenant
 * 
 * Implementa le funzionalità di multi-tenant per i modelli
 * che appartengono a un tenant specifico.
 */
trait BelongsToTenant
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::check() && Auth::user()->tenant_id) {
                $builder->where('tenant_id', Auth::user()->tenant_id);
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->tenant_id && !$model->tenant_id) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }

    /**
     * Relazione con il tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope per filtrare per tenant specifico.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $tenantId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTenant(Builder $query, ?int $tenantId = null): Builder
    {
        return $query->where('tenant_id', $tenantId ?? (Auth::check() ? Auth::user()->tenant_id : null));
    }
}
