<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

use Modules\Job\Filament\Resources\ImportResource\Pages;
use Modules\Job\Models\Import;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ImportResource extends XotBaseResource
{
    protected static ?string $model = Import::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => \Filament\Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            'file' => \Filament\Forms\Components\FileUpload::make('file')
                ->required()
                ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                ->maxSize(10240),
            'status' => \Filament\Forms\Components\Select::make('status')
                ->required()
                ->options([
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'completed' => 'Completed',
                    'failed' => 'Failed',
                ])
                ->default('pending'),
            'error_message' => \Filament\Forms\Components\Textarea::make('error_message')
                ->maxLength(65535),
            'total_rows' => \Filament\Forms\Components\TextInput::make('total_rows')
                ->numeric(),
            'processed_rows' => \Filament\Forms\Components\TextInput::make('processed_rows')
                ->numeric(),
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }
}
