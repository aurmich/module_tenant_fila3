@props(['blocks'])
{{-- Blocks  --}}
@foreach ($blocks as $block)
    <x-render.block :block="$block" :model="$model" />
@endforeach
