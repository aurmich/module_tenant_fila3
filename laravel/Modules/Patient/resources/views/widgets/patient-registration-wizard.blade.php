<div class="p-4 bg-white rounded-xl shadow">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Registrazione Paziente
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Compila tutti i campi per completare la registrazione
            </p>
        </div>

        <form wire:submit="submit">
            {{ $this->form }}
        </form>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('patient-registered', (event) => {
            window.location.href = `/patient/${event.patientId}`;
        });
    });
</script>
@endscript
