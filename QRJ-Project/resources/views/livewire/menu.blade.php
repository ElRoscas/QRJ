<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <nav class="bg-white shadow-md">
            <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Menú d'Administració</h1>
                <div class="flex items-center gap-4">
                    <span class="text-gray-700">{{ auth()->user()->Nom ?? 'usuari' }}</span>
                    <form method="POST" action="{{ route('fortify.logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                            Tancar sessió
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="max-w-6xl mx-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <h2 class="text-xl font-bold mb-2 text-gray-800">Dashboard</h2>
                    <p class="text-gray-600 mb-4">Veure informació general</p>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Anar
                        &rarr;</a>
                </div>

                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <h2 class="text-xl font-bold mb-2 text-gray-800">Esdeveniments</h2>
                    <p class="text-gray-600 mb-4">Gestionar tots els eventos</p>
                    <a href="{{ route('evenimente.llistar') }}"
                        class="text-blue-600 hover:text-blue-800 font-semibold">Anar &rarr;</a>
                </div>

                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <h2 class="text-xl font-bold mb-2 text-gray-800">Lector QR</h2>
                    <p class="text-gray-600 mb-4">Controlar accessos</p>
                    <a href="{{ route('lector_qr') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Anar
                        &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>