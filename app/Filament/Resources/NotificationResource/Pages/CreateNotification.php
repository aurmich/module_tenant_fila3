<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationResource\Pages;

<<<<<<< HEAD
use Modules\Notify\Filament\Resources\NotificationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateNotification extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
=======
use Filament\Resources\Pages\CreateRecord;
use Modules\Notify\Filament\Resources\NotificationResource;

class CreateNotification extends CreateRecord
>>>>>>> origin/dev
{
    protected static string $resource = NotificationResource::class;
}
