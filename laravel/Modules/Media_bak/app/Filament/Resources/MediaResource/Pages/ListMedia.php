<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Pages;

use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Media\Filament\Resources\MediaResource;
<<<<<<< HEAD
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Webmozart\Assert\Assert;
=======
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
>>>>>>> origin/dev

class ListMedia extends XotBaseListRecords
{
    protected static string $resource = MediaResource::class;

    /**
     * @return array<string, Tables\Columns\Column>
     */
    public function getListTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
<<<<<<< HEAD
            'model_type' => TextColumn::make('model_type')
                ->searchable(),
            'model_id' => TextColumn::make('model_id')
                ->searchable(),
            'collection_name' => TextColumn::make('collection_name')
                ->searchable(),
            'name' => TextColumn::make('name')
                ->searchable(),
            'file_name' => TextColumn::make('file_name')
                ->searchable(),
            'mime_type' => TextColumn::make('mime_type')
                ->searchable(),
            'disk' => TextColumn::make('disk')
                ->searchable(),
            'size' => TextColumn::make('size')
                ->formatStateUsing(fn (string $state): string => number_format((int) $state / 1024, 2).' KB'),
            'created_at' => TextColumn::make('created_at')
                ->dateTime(),
=======
            'name' => TextColumn::make('name')
                ->sortable()
                ->searchable(),
            'size' => TextColumn::make('size')
                ->formatStateUsing(fn (string $state): string => number_format((int) $state / 1024, 2).' KB'),
            'mime_type' => TextColumn::make('mime_type')
                ->sortable()
                ->searchable(),
>>>>>>> origin/dev
        ];
    }

    /**
     * @return array<string, Tables\Filters\BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
<<<<<<< HEAD
            'collection_name' => SelectFilter::make('collection_name')
                ->options(fn () => Media::distinct()->pluck('collection_name', 'collection_name')->toArray()),
            'mime_type' => SelectFilter::make('mime_type')
                ->options(fn () => Media::distinct()->pluck('mime_type', 'mime_type')->toArray()),
=======
            'type' => SelectFilter::make('mime_type')
                ->options([
                    'image/jpeg' => 'JPEG',
                    'image/png' => 'PNG',
                    'application/pdf' => 'PDF',
                ]),
>>>>>>> origin/dev
        ];
    }

    /**
     * @return array<string, Tables\Actions\Action|Tables\Actions\ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
<<<<<<< HEAD
            'view' => ViewAction::make()
                ,
            'view_attachment' => Action::make('view_attachment')
                
                ->icon('heroicon-s-eye')
                ->color('gray')
                ->url(
                    static fn (Media $record): string => $record->getUrl()
                )->openUrlInNewTab(true),
            'delete' => DeleteAction::make()
                
                ->requiresConfirmation(),
            'download' => Action::make('download_attachment')
                
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(
                    static fn ($record) => response()->download($record->getPath(), $record->file_name)
                ),
            'convert' => Action::make('convert')
                
                ->icon('convert01')
                ->color('gray')
                ->url(
                    function ($record): string {
                        Assert::string($res = static::$resource::getUrl('convert', ['record' => $record]));
                        return $res;
                    }
                )->openUrlInNewTab(true),
=======
            'view' => ViewAction::make(),
            'download' => Action::make('download')
                ->url(fn ($record) => route('media.download', $record))
                ->openUrlInNewTab(),
            'delete' => DeleteAction::make(),
            'preview' => Action::make('preview')
                ->url(fn ($record) => route('media.preview', $record))
                ->openUrlInNewTab(),
            'stream' => Action::make('stream')
                ->url(fn ($record) => route('media.stream', $record))
                ->openUrlInNewTab(),
>>>>>>> origin/dev
        ];
    }
}
