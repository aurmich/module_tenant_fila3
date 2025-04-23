<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources\DomainResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Tenant\Filament\Resources\DomainResource;

class CreateDomain extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
<<<<<<< HEAD
=======
<<<<<<< HEAD
class CreateDomain extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
=======
class CreateDomain extends CreateRecord
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
=======
>>>>>>> 7e34c9c (.)
{
    protected static string $resource = DomainResource::class;
}
