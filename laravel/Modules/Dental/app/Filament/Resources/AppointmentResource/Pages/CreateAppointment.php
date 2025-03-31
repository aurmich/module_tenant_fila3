<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources\AppointmentResource\Pages;

use Modules\Dental\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateAppointment extends XotBaseCreateRecord
{
    protected static string $resource = AppointmentResource::class;
}
