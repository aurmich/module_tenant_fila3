<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Resources\PatientResource\Pages;

use Modules\Patient\Filament\Resources\PatientResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;
} 