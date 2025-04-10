<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters\Profile\Resources\ConsentResource\Pages;

use Modules\Gdpr\Filament\Clusters\Profile\Resources\ConsentResource;

class CreateConsent extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
{
    protected static string $resource = ConsentResource::class;
}
