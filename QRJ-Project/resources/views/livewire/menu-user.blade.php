<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Usuari</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">Benvingut/da</h1>
            <p class="text-gray-600 mb-6">Hola, {{ auth()->user()->Nom ?? 'usuari' }}.</p>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-sm text-blue-700">
                    De moment, no tens permisos d'administrador.
                </p>
            </div>

            <div class="space-y-3">
                <a href="{{ route('profile.edit') }}"
                    class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Configuració del perfil
                </a>

                <form method="POST" action="{{ route('fortify.logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                        Tancar sessió
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>