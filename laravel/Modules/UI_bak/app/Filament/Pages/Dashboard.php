<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Pages;

use Filament\Pages\Page;
use Modules\UI\Filament\Widgets;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'ui::filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        $widgets = [
            [
                'class' => Widgets\TestChartWidget::class,
                'properties' => [
                    'qid' => 5,
                    'max_height' => '900px',
                    'type' => 'pie',
                ],
            ],
            [
                'class' => Widgets\TestChartWidget::class,
                'properties' => [
                    'qid' => 7,
                    'type' => 'bar',
                ],
            ],
            [
                'class' => Widgets\TestChartWidget::class,
                'properties' => [
                    'qid' => 9,
                    'type' => 'bar',
                ],
            ],
        ];

        return [
            // Widgets\TestChartWidget::make(['qid' => 5]),
            // Widgets\TestChartWidget::make(['qid' => 6]),
            // Widgets\StatsOverviewWidget::class,

            Widgets\StatWithIconWidget::make(['label' => 'Unique views', 'value' => '192.1k']),
            Widgets\TestWidget::make(['widgets' => $widgets]),
            Widgets\TestWidget::make(['widgets' => $widgets]),
            Widgets\TestWidget::make(['widgets' => $widgets]),
            Widgets\TestWidget::make(['widgets' => $widgets]),
        ];
    }
}
