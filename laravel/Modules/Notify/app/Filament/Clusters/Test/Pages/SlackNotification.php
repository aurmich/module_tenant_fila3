<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Pages\Page;
use Modules\Notify\Filament\Clusters\Test;

class SlackNotification extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static string $view = 'notify::filament.clusters.test.pages.slack-notification';

    protected static ?string $cluster = Test::class;
}
