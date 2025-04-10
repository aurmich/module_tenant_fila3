<x-filament::widget>
    <x-filament::card>
        {{-- Widget content --}}
        @php
            // Debug information if needed
            // dddx([
            //     'get_defined_vars()' => get_defined_vars(),
            //     '$this' => $this,
            //     'get_class_methods' => get_class_methods($this),
            // ]);
        @endphp
<<<<<<< HEAD:laravel/Modules/User_bak/resources/views/filament/resources/user-resource/widgets/user-overview.blade.php
        
=======
        {{ $record->name ?? 'Utente' }}
>>>>>>> 1db18947ce600c11b19f8ed6a94168595ad573cf:resources/views/filament/resources/user-resource/widgets/user-overview.blade.php
    </x-filament::card>
</x-filament::widget>
