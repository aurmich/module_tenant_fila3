<?php

/**
 * @see https://gitlab.com/amvisor/filament-failed-jobs/-/blob/master/src/resources/FailedJobsResource.php
 */

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Filament\Forms;
use Modules\Job\Filament\Resources\FailedJobResource\Pages;
use Modules\Job\Models\FailedJob;
use Modules\Xot\Filament\Resources\XotBaseResource;

class FailedJobResource extends XotBaseResource
{
    protected static ?string $model = FailedJob::class;

    public static function getFormSchema(): array
    {
        return [
            'uuid' => Forms\Components\TextInput::make('uuid')
                ->disabled()
                ->columnSpan(4),
            'failed_at' => Forms\Components\TextInput::make('failed_at')
                ->disabled(),
            'id' => Forms\Components\TextInput::make('id')
                ->disabled(),
            'connection' => Forms\Components\TextInput::make('connection')
                ->disabled(),
            'queue' => Forms\Components\TextInput::make('queue')
                ->disabled(),
            'exception' => Forms\Components\Textarea::make('exception')
                ->disabled()
                ->columnSpan(4)
                ->extraInputAttributes(['style' => 'font-size: 80%;']),
            'payload' => Forms\Components\Textarea::make('payload')
                ->disabled()
                ->columnSpan(4)
                ->extraInputAttributes(['style' => 'font-size: 80%;']),
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFailedJobs::route('/'),
        ];
    }
}
