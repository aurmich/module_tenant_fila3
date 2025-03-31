<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources\TreatmentResource\Pages;

use Modules\Dental\Filament\Resources\TreatmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListTreatments extends XotBaseListRecords
{
    protected static string $resource = TreatmentResource::class;
}
