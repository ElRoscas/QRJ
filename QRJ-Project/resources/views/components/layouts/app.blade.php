<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QRJ Project</title>

    {{-- LÍNIA 7: Corregida --}}
    @vite(['resources/css/app.css', 'resources/css/registre.css', 'resources/js/app.js'])
    
    @livewireStyles
    @fluxStyles
</head>
<body>
    {{ $slot }}

    @livewireScripts
    @fluxScripts
</body>
</html>