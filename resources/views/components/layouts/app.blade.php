<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Or link to your compiled CSS --}}
        @livewireStyles
    </head>
    <body>
        <div class="container mx-auto p-4">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>