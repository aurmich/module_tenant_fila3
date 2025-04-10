<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Pages;

use Filament\Tables;
use Modules\Job\Filament\Resources\ScheduleResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListSchedules extends XotBaseListRecords
{
    protected static string $resource = ScheduleResource::class;

    public function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'command' => Tables\Columns\TextColumn::make('command')
                ->sortable()
                ->searchable(),
            'params' => Tables\Columns\TextColumn::make('params')
                ->wrap()
                ->searchable(),
            'expression' => Tables\Columns\TextColumn::make('expression')
                ->sortable()
                ->searchable(),
            'timezone' => Tables\Columns\TextColumn::make('timezone')
                ->sortable()
                ->searchable(),
            'is_active' => Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
            'without_overlapping' => Tables\Columns\IconColumn::make('without_overlapping')
                ->boolean()
                ->sortable(),
            'on_one_server' => Tables\Columns\IconColumn::make('on_one_server')
                ->boolean()
                ->sortable(),
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public function getListTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->hidden(fn ($record) => $record->trashed())
                ->tooltip(__('filament-support::actions/edit.single.label')),
            Tables\Actions\RestoreAction::make()
                ->tooltip(__('filament-support::actions/restore.single.label')),
            Tables\Actions\DeleteAction::make()
                ->tooltip(__('filament-support::actions/delete.single.label')),
            Tables\Actions\ForceDeleteAction::make()
                ->tooltip(__('filament-support::actions/force-delete.single.label')),
            Tables\Actions\ViewAction::make()
                ->icon('history')
                ->color('gray')
                ->tooltip(static::trans('buttons.history')),
        ];
    }

    public function getListTableBulkActions(): array
    {
        return [
            Tables\Actions\DeleteBulkAction::make(),
        ];
    }

    protected function getTableRecordUrlUsing(): ?\Closure
    {
        return static fn (): ?string => null;
    }
}
