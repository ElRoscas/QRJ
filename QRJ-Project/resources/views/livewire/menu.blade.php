<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Menú d'administració</h1>
            <form method="POST" action="{{ route('fortify.logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                    Tancar sessió
                </button>
            </form>
        </div>
        <p>Benvingut/da, {{ auth()->user()->Nom ?? 'usuari' }}.</p>
        <ul class="list-disc list-inside mt-4 space-y-2">
            <li><a class="text-blue-600 underline" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a class="text-blue-600 underline" href="{{ route('esdeveniments.llistar') }}">Esdeveniments</a></li>
            <li><a class="text-blue-600 underline" href="{{ route('lector_qr') }}">Lector QR</a></li>
        </ul>
    </div>
</body>

</html>