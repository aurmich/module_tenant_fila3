<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Pages;

use Filament\Pages\Actions\DeleteAction;
<<<<<<< HEAD
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * --
 */
class EditNotifyTheme extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
=======
use Filament\Resources\Pages\EditRecord;
use Modules\Notify\Filament\Resources\NotifyThemeResource;

class EditNotifyTheme extends EditRecord
>>>>>>> origin/dev
{
    protected static string $resource = NotifyThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
