<?php

declare(strict_types=1);

namespace Modules\Reporting\Filament\Resources\ReportResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Reporting\Filament\Resources\ReportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListReports extends XotBaseListRecords
{
    protected static string $resource = ReportResource::class;
}
