<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Dental\Filament\Resources\AppointmentWorkflowResource;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditAppointmentWorkflow extends XotBaseEditRecord
{
    protected static string $resource = AppointmentWorkflowResource::class;

    /**
     * Definisce le azioni nell'header della pagina.
     *
     * @return array<Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('continue')
                ->label('Continua Workflow')
                ->icon('heroicon-o-play')
                ->color('primary')
                ->url(fn (AppointmentWorkflow $record): string => static::getResource()::getUrl('workflow', ['record' => $record->id]))
                ->visible(fn (AppointmentWorkflow $record): bool => !$record->isCompleted() && !$record->isCancelled()),
        ];
    }
}
