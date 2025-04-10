<x-filament::page>

    <x-filament-panels::form wire:submit="sendNotification()">
        {{ $this->notificationForm }}

        <x-filament-panels::form.actions :actions="$this->getNotificationFormActions()" />

        <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="sendNotification()" />

    </x-filament-panels::form>
</x-filament::page>
