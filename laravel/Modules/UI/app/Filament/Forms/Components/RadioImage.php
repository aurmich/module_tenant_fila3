<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Radio;

class RadioImage extends Radio
{
    /**
     * @var view-string
     */
    protected string $view = 'ui::filament.forms.components.radio-image';

    protected function setUp(): void
    {
        parent::setUp();

        /*
        $this->suffixAction(
            \Filament\Forms\Components\Actions\Action::make('icon')
            ->icon(fn (?string $state) => $state)
            // ->modalContent(fn ($record) => view('ui::filament.forms.components.icon-picker', ['record' => $record]))
            ->form([
                RadioIcon::make('status')
                    ->inline()
                    ->inlineLabel(false)
                    ->options([
                        'draft' => 'Dr<b>af</b>t',
                        'scheduled' => 'Scheduled',
                        'published' => 'Published',
                    ]),
            ])
        );
        */
    }
}
