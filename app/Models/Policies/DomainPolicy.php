<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Policies;

use Modules\Tenant\Models\Domain;
<<<<<<< HEAD
use Modules\Xot\Contracts\UserContract;
=======
use Modules\Xot\Contracts\ProfileContract;
>>>>>>> 1cbc182 (.)

class DomainPolicy extends TenantBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
<<<<<<< HEAD
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny');
=======
    public function viewAny(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }

    /**
     * Determine whether the user can view the model.
     */
<<<<<<< HEAD
    public function view(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.view');
=======
    public function view(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.view'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }

    /**
     * Determine whether the user can create models.
     */
<<<<<<< HEAD
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.create');
=======
    public function create(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.create'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }

    /**
     * Determine whether the user can update the model.
     */
<<<<<<< HEAD
    public function update(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.update');
=======
    public function update(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.update'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }

    /**
     * Determine whether the user can delete the model.
     */
<<<<<<< HEAD
    public function delete(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.delete');
=======
    public function delete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.delete'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }

    /**
     * Determine whether the user can restore the model.
     */
<<<<<<< HEAD
    public function restore(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.restore');
=======
    public function restore(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.restore'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
<<<<<<< HEAD
    public function forceDelete(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete');
=======
    public function forceDelete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }
}
