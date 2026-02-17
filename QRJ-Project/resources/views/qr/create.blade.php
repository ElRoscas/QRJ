<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Codi QR - La Salle Mollerussa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navegació -->
        <nav class="bg-white shadow-md">
            <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">
                    <span class="text-blue-600">LA SALLE</span> MOLLERUSSA
                </h1>
                <a href="{{ route('menu_admin') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="bi bi-arrow-left"></i> Tornar al Menú
                </a>
            </div>
        </nav>

        <!-- Contingut Principal -->
        <div class="max-w-4xl mx-auto p-6">
            <!-- Missatges -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Formulari -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">
                    <i class="bi bi-qr-code"></i> Crear Codi QR per Usuari
                </h2>

                <form action="{{ route('qr.store') }}" method="POST">
                    @csrf

                    <!-- Selector d'usuari -->
                    <div class="mb-4">
                        <label for="user_id" class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-person"></i> Selecciona l'usuari
                        </label>
                        <select
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror"
                            id="user_id" name="user_id" required>
                            <option value="">-- Selecciona un usuari --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->Correu }}">
                                    {{ $user->Nom }} ({{ $user->Correu }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Només es mostren usuaris sense QR assignat</p>
                    </div>

                    <!-- Selector d'esdeveniment -->
                    <div class="mb-4">
                        <label for="esdeveniment_id" class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-calendar-event"></i> Selecciona l'esdeveniment *
                        </label>
                        <select
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('esdeveniment_id') border-red-500 @enderror"
                            id="esdeveniment_id" name="esdeveniment_id" required>
                            <option value="">-- Selecciona un esdeveniment --</option>
                            @foreach($esdeveniments as $esdeveniment)
                                <option value="{{ $esdeveniment->id }}">
                                    {{ $esdeveniment->Nom }} - {{ $esdeveniment->Data_Esdeveniment->format('d/m/Y') }}
                                    (Max: {{ $esdeveniment->max_qrs_per_usuari }}
                                    QR{{ $esdeveniment->max_qrs_per_usuari > 1 ? 's' : '' }} per usuari)
                                </option>
                            @endforeach
                        </select>
                        @error('esdeveniment_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-sm mt-1">Només es mostren esdeveniments propers</p>
                    </div>

                    <!-- Mida -->
                    <div class="mb-4">
                        <label for="size" class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-arrows-angle-expand"></i> Mida del QR
                        </label>
                        <select
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="size" name="size">
                            <option value="200">Petita (200x200)</option>
                            <option value="300" selected>Mitjana (300x300)</option>
                            <option value="400">Gran (400x400)</option>
                            <option value="500">Extra Gran (500x500)</option>
                        </select>
                    </div>

                    <!-- Enviar per correu -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="send_email" value="1" class="mr-2 w-5 h-5 text-blue-600">
                            <span class="text-gray-700 font-semibold">
                                <i class="bi bi-envelope"></i> Enviar QR al correu de l'usuari
                            </span>
                        </label>
                        <p class="text-gray-500 text-sm mt-1 ml-7">El QR s'enviarà automàticament al correu de l'usuari
                            seleccionat</p>
                    </div>

                    <!-- Contingut del correu (opcional) -->
                    <div class="mb-4">
                        <label for="email_subject" class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-card-text"></i> Assumpte del correu (opcional)
                        </label>
                        <input type="text" id="email_subject" name="email_subject" value="{{ old('email_subject') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-gray-500 text-sm mt-1">Si es deixa en blanc, s'utilitzarà l'assumpte per defecte.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="email_body" class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-body-text"></i> Contingut del correu (opcional)
                        </label>
                        <textarea id="email_body" name="email_body" rows="4"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('email_body') }}</textarea>
                        <p class="text-gray-500 text-sm mt-1">Pots personalitzar el missatge que rebrà l'usuari. El codi
                            QR s'adjuntarà automàticament com a imatge.</p>
                    </div>

                    <!-- Botons -->
                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('menu_admin') }}"
                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                            <i class="bi bi-arrow-left"></i> Cancel·lar
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="bi bi-qr-code"></i> Generar QR
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview del QR generat -->
            @if(session('qr_image'))
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-green-600">
                        <i class="bi bi-check-circle"></i> QR Generat per {{ session('user_name') }}
                    </h3>

                    <div class="text-center">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-gray-700">
                                <strong>Usuari:</strong> {{ session('user_name') }}<br>
                                <strong>Estat actual:</strong> <span class="text-blue-600 font-semibold">Fora</span>
                            </p>
                        </div>

                        <div class="mb-4">
                            <img src="data:image/png;base64,{{ session('qr_image') }}" alt="QR Code"
                                class="mx-auto border-4 border-gray-200 rounded-lg p-2" style="max-width: 400px;">
                        </div>

                        <div class="flex gap-3 justify-center flex-wrap">
                            <a href="data:image/png;base64,{{ session('qr_image') }}"
                                download="qr-{{ session('user_name') }}.png"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <i class="bi bi-download"></i> Descarregar PNG
                            </a>
                            <a href="{{ route('qr.create') }}"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="bi bi-plus-lg"></i> Crear un Altre
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>

</html>