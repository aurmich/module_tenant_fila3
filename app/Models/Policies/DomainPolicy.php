<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Policies;

use Modules\Tenant\Models\Domain;
<<<<<<< HEAD
use Modules\Xot\Contracts\ProfileContract;
=======
use Modules\Xot\Contracts\UserContract;
>>>>>>> 864e16e (.)

class DomainPolicy extends TenantBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
<<<<<<< HEAD
    public function viewAny(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny'); /** @phpstan-ignore method.nonObject */
=======
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny');
>>>>>>> 864e16e (.)
    }

    /**
     * Determine whether the user can view the model.
     */
<<<<<<< HEAD
    public function view(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.view'); /** @phpstan-ignore method.nonObject */
=======
    public function view(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.view');
>>>>>>> 864e16e (.)
    }

    /**
     * Determine whether the user can create models.
     */
<<<<<<< HEAD
    public function create(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.create'); /** @phpstan-ignore method.nonObject */
=======
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.create');
>>>>>>> 864e16e (.)
    }

    /**
     * Determine whether the user can update the model.
     */
<<<<<<< HEAD
    public function update(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.update'); /** @phpstan-ignore method.nonObject */
=======
    public function update(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.update');
>>>>>>> 864e16e (.)
    }

    /**
     * Determine whether the user can delete the model.
     */
<<<<<<< HEAD
    public function delete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.delete'); /** @phpstan-ignore method.nonObject */
=======
    public function delete(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.delete');
>>>>>>> 864e16e (.)
    }

    /**
     * Determine whether the user can restore the model.
     */
<<<<<<< HEAD
    public function restore(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.restore'); /** @phpstan-ignore method.nonObject */
=======
    public function restore(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.restore');
>>>>>>> 864e16e (.)
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
<<<<<<< HEAD
    public function forceDelete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete'); /** @phpstan-ignore method.nonObject */
    }
}
=======
    public function forceDelete(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete');
    }
}
>>>>>>> 864e16e (.)
