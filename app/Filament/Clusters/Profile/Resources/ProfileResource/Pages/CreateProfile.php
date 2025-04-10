<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters\Profile\Resources\ProfileResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Gdpr\Filament\Clusters\Profile\Resources\ProfileResource;

class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;
}
