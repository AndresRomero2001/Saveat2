@props(['name'])

@php
    $svgContent = file_get_contents(public_path("app-icons/{$name}.svg"));
@endphp

{!! $svgContent !!}
