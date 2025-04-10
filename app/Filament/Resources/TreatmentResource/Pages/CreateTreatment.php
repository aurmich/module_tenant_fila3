<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Gdpr\Filament\Resources\TreatmentResource;

class CreateTreatment extends CreateRecord
{
    protected static string $resource = TreatmentResource::class;
}
