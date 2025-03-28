<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Pages;

use Modules\Activity\Filament\Resources\StoredEventResource;

class EditStoredEvent extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
{
    protected static string $resource = StoredEventResource::class;
}
