<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

use Filament\Pages\Page;
<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
=======

class Dashboard extends Page
>>>>>>> 40aab39 (.)
=======
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
>>>>>>> e53d43b (.)
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'tenant::filament.pages.dashboard';
}
