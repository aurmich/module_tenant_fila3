<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'activity::filament.pages.dashboard';

    // public function mount(): void
    // {
    //     // $user = auth()->user();
    //     // if(!$user->hasRole('super-admin')){
    //     //     redirect('/admin');
    //     // }
    //     ActivityEvent::dispatch();
    // }
}
