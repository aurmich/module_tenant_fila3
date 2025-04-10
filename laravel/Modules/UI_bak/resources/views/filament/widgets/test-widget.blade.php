{{--
<div>
    @foreach ($widgets as $widget)
        @livewire($widget['class'], $widget['properties'])
    @endforeach

</div>
--}}
{{--
<x-filament::section icon="heroicon-o-user" collapsible>
    AAAAAAAA



--}}
<x-filament-widgets::widget>
    <x-filament::section collapsible>
        <x-filament::grid lg='2'>
            <x-filament::grid.column>
                @livewire($widgets[0]['class'], $widgets[0]['properties'])

            </x-filament::grid.column>
            <x-filament::grid.column>
                @livewire($widgets[1]['class'], $widgets[1]['properties'])<br />
                @livewire($widgets[2]['class'], $widgets[2]['properties'])
            </x-filament::grid.column>
        </x-filament::grid>
    </x-filament::section>
</x-filament-widgets::widget>
