<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Gdpr\Filament\Resources\ConsentResource;

class CreateConsent extends CreateRecord
{
    protected static string $resource = ConsentResource::class;
}
