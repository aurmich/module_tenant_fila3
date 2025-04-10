<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Media\Filament\Resources\MediaResource;
<<<<<<< HEAD
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ConvertMedia extends \Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord
{
    protected static string $resource = MediaResource::class;

    public function getInfolistSchema(): array
    {
        return [
            // Definire qui i componenti dell'infolist
=======

class ConvertMedia extends ViewRecord
{
    protected static string $resource = MediaResource::class;

    /**
     * @return DeleteAction[]
     *
     * @psalm-return list{DeleteAction}
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
>>>>>>> origin/dev
        ];
    }
}
