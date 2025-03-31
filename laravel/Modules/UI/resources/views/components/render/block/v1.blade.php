@props(['block'])

@component("ui::components.blocks.{$block['type']}", $block['data'] ?? []) @endcomponent
