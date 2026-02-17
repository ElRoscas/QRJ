<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Admin</title>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    @vite(['resources/css/menu_admin.css'])
</head>

<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE
                        <img src="{{ asset('images/estrella.png') }}" class="star-img" alt="estrella">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="menu-box-content">
                    <div class="menu-header">
                        <div>
                            <h1 class="menu-title">MENÚ</h1>
                            <p class="menu-subtitle">Administració</p>
                        </div>
                        <div class="menu-actions">
                            <span class="user-pill">{{ auth()->user()->Nom ?? 'usuari' }}</span>
                            <form method="POST" action="{{ route('fortify.logout') }}">
                                @csrf
                                <button type="submit" class="logout-btn">Tancar sessió</button>
                            </form>
                        </div>
                    </div>

                    <div class="menu-grid">
                        <div class="menu-item" onclick="location.href='{{ route('esdeveniment.index') }}'">
                            <div class="icon-card icon-blue">📅</div>
                            <p>Esdeveniments</p>
                            <span>Gestionar tots els events</span>
                        </div>

                        <div class="menu-item" onclick="location.href='{{ route('esdeveniment.create') }}'">
                            <div class="icon-card icon-gold">➕</div>
                            <p>Crear esdeveniment</p>
                            <span>Nou event i detalls</span>
                        </div>

                        <div class="menu-item" onclick="location.href='{{ route('qr.create') }}'">
                            <div class="icon-card icon-emerald">🎯</div>
                            <p>Crear QR</p>
                            <span>Generar codis QR</span>
                        </div>

                        <div class="menu-item" onclick="location.href='{{ route('qr.read') }}'">
                            <div class="icon-card icon-slate">📱</div>
                            <p>Llegir QR</p>
                            <span>Verificar codis</span>
                        </div>
                    </div>

                    <div class="footer-nav">
                        <a href="{{ route('home') }}" class="back-btn">
                            < Tornar enrere</a>
                    </div>
                </div>
            </div>
        </div>
=======
=======
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    </div>
</body>

</html>