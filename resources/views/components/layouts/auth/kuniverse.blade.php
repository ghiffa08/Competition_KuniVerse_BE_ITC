<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    @include('partials.head')
</head>
<body class="antialiased min-h-screen font-sans">
    {{ $slot }}

    @fluxScripts
</body>
</html>
