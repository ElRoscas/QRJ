<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Admin - La Salle Mollerussa</title>
    @vite(['resources/css/menu_admin.css'])
</head>

<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE
                        <img src="{{ asset('estrella.png') }}" class="star-img" alt="estrella">
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
    </div>
    <script src="{{ asset('js/menu_admin.js') }}"></script>
</body>

</html>