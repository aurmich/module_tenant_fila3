<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Pages;

use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected static bool $shouldRegisterNavigation = true;

    protected static bool $isDiscovered = false;
}
