<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Pages;

use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * --
 */
class CreateNotifyTheme extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
{
    protected static string $resource = NotifyThemeResource::class;
}
