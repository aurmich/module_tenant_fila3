<?php

<<<<<<< HEAD
=======
/**
 * ---.
 */

>>>>>>> origin/dev
declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Pages;

<<<<<<< HEAD
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * --
 */
class CreateNotifyTheme extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
=======
use Filament\Resources\Pages\CreateRecord;
use Modules\Notify\Filament\Resources\NotifyThemeResource;

class CreateNotifyTheme extends CreateRecord
>>>>>>> origin/dev
{
    protected static string $resource = NotifyThemeResource::class;
}
