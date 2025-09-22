<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Policies;

use Modules\Tenant\Models\Domain;
<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Xot\Contracts\UserContract;
=======
use Modules\Xot\Contracts\ProfileContract;
>>>>>>> 1cbc182 (.)
=======
use Modules\Xot\Contracts\ProfileContract;
=======
use Modules\Xot\Contracts\UserContract;
>>>>>>> 864e16e (.)
>>>>>>> 564de7e (.)

class DomainPolicy extends TenantBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny');
=======
    public function viewAny(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
=======
    public function viewAny(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny'); /** @phpstan-ignore method.nonObject */
=======
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny');
>>>>>>> 864e16e (.)
>>>>>>> 564de7e (.)
    }

    /**
     * Determine whether the user can view the model.
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function view(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.view');
=======
    public function view(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.view'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
=======
    public function view(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.view'); /** @phpstan-ignore method.nonObject */
=======
    public function view(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.view');
>>>>>>> 864e16e (.)
>>>>>>> 564de7e (.)
    }

    /**
     * Determine whether the user can create models.
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.create');
=======
    public function create(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.create'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
=======
    public function create(ProfileContract $user): bool
    {
        return $user->hasPermissionTo('domain.create'); /** @phpstan-ignore method.nonObject */
=======
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.create');
>>>>>>> 864e16e (.)
>>>>>>> 564de7e (.)
    }

    /**
     * Determine whether the user can update the model.
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function update(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.update');
=======
    public function update(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.update'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
=======
    public function update(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.update'); /** @phpstan-ignore method.nonObject */
=======
    public function update(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.update');
>>>>>>> 864e16e (.)
>>>>>>> 564de7e (.)
    }

    /**
     * Determine whether the user can delete the model.
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function delete(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.delete');
=======
    public function delete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.delete'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
=======
    public function delete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.delete'); /** @phpstan-ignore method.nonObject */
=======
    public function delete(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.delete');
>>>>>>> 864e16e (.)
>>>>>>> 564de7e (.)
    }

    /**
     * Determine whether the user can restore the model.
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function restore(UserContract $user, Domain $_domain): bool
    {
        return $user->hasPermissionTo('domain.restore');
=======
    public function restore(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.restore'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
=======
    public function restore(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.restore'); /** @phpstan-ignore method.nonObject */
=======
    public function restore(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.restore');
>>>>>>> 864e16e (.)
>>>>>>> 564de7e (.)
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
<<<<<<< HEAD
<<<<<<< HEAD
    public function forceDelete(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete');
=======
=======
>>>>>>> 564de7e (.)
    public function forceDelete(ProfileContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete'); /** @phpstan-ignore method.nonObject */
>>>>>>> 1cbc182 (.)
    }
}
=======
    public function forceDelete(UserContract $user, Domain $domain): bool
    {
        return $user->hasPermissionTo('domain.forceDelete');
    }
}
>>>>>>> 864e16e (.)
