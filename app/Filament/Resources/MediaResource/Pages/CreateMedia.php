<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Media\Filament\Resources\MediaResource;
<<<<<<< HEAD
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateMedia extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
=======

class CreateMedia extends CreateRecord
>>>>>>> origin/dev
{
    protected static string $resource = MediaResource::class;
}
