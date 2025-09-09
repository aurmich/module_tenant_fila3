<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
<<<<<<< HEAD
use Modules\Xot\Contracts\UserContract;
=======
use Modules\Xot\Contracts\ProfileContract;
>>>>>>> 1cbc182 (.)
use Modules\Xot\Datas\XotData;

abstract class TenantBasePolicy
{
    use HandlesAuthorization;

<<<<<<< HEAD
    public function before(UserContract $user, string $ability): ?bool
    {
        $xotData = XotData::make();
        if ($user->hasRole('super-admin')) {
=======
    public function before(ProfileContract $user, string $ability): ?bool
    {
        $xotData = XotData::make();
        if ($user->hasRole('super-admin')/** @phpstan-ignore method.nonObject */) {
>>>>>>> 1cbc182 (.)
            return true;
        }

        return null;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 1cbc182 (.)
