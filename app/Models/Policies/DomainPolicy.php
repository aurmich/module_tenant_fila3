<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Policies;

use Modules\Tenant\Models\Domain;
use Modules\Xot\Contracts\ProfileContract;

class DomainPolicy extends TenantBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.view'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.create'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.update'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.delete'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.restore'); /** @phpstan-ignore method.nonObject */
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete'); /** @phpstan-ignore method.nonObject */
    }
}
