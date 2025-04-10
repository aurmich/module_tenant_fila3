@props(['blocks'])

@foreach ($blocks as $block)
    {{-- OBSOLETE
    <x-render-block :block="$block" />
    --}}
@endforeach
