<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters\Profile\Resources;

use Modules\Gdpr\Filament\Clusters\Profile as ProfileCluster;
use Modules\Gdpr\Filament\Clusters\Profile\Resources\ProfileResource\Pages;
use Modules\Gdpr\Models\Profile;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ProfileResource extends XotBaseResource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = ProfileCluster::class;

    public static function getFormSchema(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
