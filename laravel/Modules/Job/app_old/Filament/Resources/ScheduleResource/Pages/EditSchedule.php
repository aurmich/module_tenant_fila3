<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Pages;

use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Modules\Job\Filament\Resources\ScheduleResource;
use Modules\Xot\Filament\Traits\NavigationPageLabelTrait;
use Webmozart\Assert\Assert;

class EditSchedule extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
{
    use NavigationPageLabelTrait;

    public Collection $commands;

    protected static string $resource = ScheduleResource::class;

    public function getformSchema(): array
    {
        Assert::isArray($res = $this->getResource()::getFormSchema());

        return $res;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema());
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    // protected function getRedirectUrl(): string
    // {
    //    return $this->getResource()::getUrl('index');
    // }
}
