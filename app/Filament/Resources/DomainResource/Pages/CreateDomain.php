<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources\DomainResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Tenant\Filament\Resources\DomainResource;

<<<<<<< HEAD
class CreateDomain extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
=======
class CreateDomain extends CreateRecord
>>>>>>> 9f73f2a (.)
{
    protected static string $resource = DomainResource::class;
}
