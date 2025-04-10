<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Resources\PatientResource\Pages;

use Modules\Patient\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\XotBaseResource\Pages\XotBaseEditRecord;

class EditPatient extends XotBaseEditRecord
{
    protected static string $resource = PatientResource::class;
}
