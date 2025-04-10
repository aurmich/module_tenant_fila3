<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Modules\Xot\Filament\Widgets\EnvWidget;

class SettingPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'notify::filament.pages.setting';

    public function getHeaderWidgets(): array
    {
        $only = [
            'debugbar_enabled',
            // 'google_maps_api_key',
            'telegram_bot_token',
        ];

        return [
            EnvWidget::make(['only' => $only]),
        ];
    }
}
