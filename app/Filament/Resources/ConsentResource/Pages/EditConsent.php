<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Gdpr\Filament\Resources\ConsentResource;

class EditConsent extends EditRecord
{
    protected static string $resource = ConsentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
