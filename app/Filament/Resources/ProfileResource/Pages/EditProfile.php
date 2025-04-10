<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ProfileResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Gdpr\Filament\Resources\ProfileResource;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
