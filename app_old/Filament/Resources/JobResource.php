<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Modules\Job\Filament\Resources\JobResource\Pages;
use Modules\Job\Filament\Resources\JobResource\Widgets;
use Modules\Job\Models\Job;
use Modules\Xot\Filament\Resources\XotBaseResource;

class JobResource extends XotBaseResource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $recordTitleAttribute = 'display_name';

    public static function getFormSchema(): array
    {
        return [
            'queue' => \Filament\Forms\Components\TextInput::make('queue')
                ->required()
                ->maxLength(255),
            'payload' => \Filament\Forms\Components\TextInput::make('payload')
                ->required(),
            'attempts' => \Filament\Forms\Components\TextInput::make('attempts')
                ->numeric()
                ->required(),
            'available_at' => \Filament\Forms\Components\DateTimePicker::make('available_at')
                ->required(),
            'created_at' => \Filament\Forms\Components\DateTimePicker::make('created_at')
                ->required(),
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
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'board' => Pages\BoardJobs::route('/board'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\JobStatsOverview::class,
        ];
    }
}
