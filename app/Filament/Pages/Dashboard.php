<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

use Filament\Pages\Page;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
<<<<<<< HEAD
    protected static null|string $navigationIcon = 'heroicon-o-home';
=======
    protected static ?string $navigationIcon = 'heroicon-o-home';
>>>>>>> 1cbc182 (.)

    protected static string $view = 'tenant::filament.pages.dashboard';
}
