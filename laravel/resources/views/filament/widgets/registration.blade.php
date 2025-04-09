<div>
    <form wire:submit="create">
        {{ $this->form }}

        <div class="flex justify-end mt-4">
            <x-filament::button type="submit">
                Registrati
            </x-filament::button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
            Hai già un account? Accedi
        </a>
    </div>
</div>
