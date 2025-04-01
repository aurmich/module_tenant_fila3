<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Resources\PatientResource\Pages;

use Modules\Patient\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\XotBaseResource\Pages\XotBaseCreateRecord;

class CreatePatient extends XotBaseCreateRecord
{
    protected static string $resource = PatientResource::class;
}
