<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\ContactResource\Pages;

<<<<<<< HEAD
use Modules\Notify\Filament\Resources\ContactResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateContact extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
=======
use Filament\Resources\Pages\CreateRecord;
use Modules\Notify\Filament\Resources\ContactResource;

class CreateContact extends CreateRecord
>>>>>>> origin/dev
{
    protected static string $resource = ContactResource::class;
}
