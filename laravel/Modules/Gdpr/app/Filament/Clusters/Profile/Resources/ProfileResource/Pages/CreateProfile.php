<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters\Profile\Resources\ProfileResource\Pages;

use Modules\Gdpr\Filament\Clusters\Profile\Resources\ProfileResource;

class CreateProfile extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
{
    protected static string $resource = ProfileResource::class;
}
