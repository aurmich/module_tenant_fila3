<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Actions\Table;

use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Session;
use Modules\UI\Enums\TableLayoutEnum;

class TableLayoutToggleTableAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        $current = $this->getCurrentLayout();
        $this
            ->name('tableLayoutToggle')
            ->label('') // Nessuna label, solo tooltip
            ->tooltip($current->getLabel())
            ->color($current->getColor()) // Colore basato sulla sessione
            ->icon($current->getIcon()) // Usa l'icona basata sulla sessione
            ->action(fn ($livewire) => $this->toggleLayout($livewire)) // Esegui il toggle

            ->requiresConfirmation(false); // Non richiede conferma
    }

    protected function toggleLayout(ListRecords $livewire): void
    {
        $currentLayout = $this->getCurrentLayout();
        $newLayout = $currentLayout->toggle(); // Esegui il toggle tra GRID e LIST
        Session::put('table_layout', $newLayout->value); // Salva il layout nella sessione
        // Aggiorna la vista del layout dinamicamente
        if (! property_exists($livewire, 'layoutView')) {
            throw new \Exception('add layoutView to ['.$livewire::class.']');
        }
        $livewire->layoutView = $newLayout;
        $livewire->dispatch('$refresh');
        $livewire->dispatch('refreshTable');
        $livewire->resetTable();
    }

    protected function getCurrentLayout(): TableLayoutEnum
    {
        $layout = Session::get('table_layout', TableLayoutEnum::init()->value); // Recupera il layout dalla sessione
        if (! is_string($layout)) {
            return TableLayoutEnum::init();
        }
        $res = TableLayoutEnum::TryFrom($layout);
        if (null !== $res) {
            return $res;
        }

        return TableLayoutEnum::init();
    }
}
