<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Dental\Actions\InitiateAppointmentWorkflowAction;
use Modules\Dental\Filament\Resources\AppointmentWorkflowResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListAppointmentWorkflows extends XotBaseListRecords
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
            Actions\CreateAction::make()
                ->label('Crea Nuovo Workflow')
                ->icon('heroicon-o-plus')
                ->after(function (array $data, $record): void {
                    // Dopo la creazione del record, inizializza il workflow
                    // con l'action Spatie QueueableAction
                    app(InitiateAppointmentWorkflowAction::class)->execute(
                        patient: $record->patient,
                        initialData: [],
                        userId: auth()->id()
                    );
                }),
        ];
    }
}
