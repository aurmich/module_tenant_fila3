<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Modules\User\Models\BaseProfile;


class Profile extends BaseProfile{
    /** @var string */
    protected $connection = 'patient';
} 