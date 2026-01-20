<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Admin - La Salle Mollerussa</title>
    <link rel="stylesheet" href="{{ asset('css/menu_admin.css') }}">
</head>
<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE 
                        <img src="{{ asset('images/estrella.png') }}" class="floating-star" alt="estrella">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="menu-box-content">
                    <h1 class="menu-title">MENÚ <span class="star-accent-inline">★</span></h1>
                    
                    <div class="menu-grid">
                        <div class="menu-item" onclick="location.href='{{ route('esdeveniments') }}'">
                            <div class="icon-card">📅</div>
                            <p>Esdeveniments</p>
                        </div>
                        <div class="menu-item" onclick="location.href='{{ route('event.create') }}'">
                            <div class="icon-card">📅<span>+</span></div>
                            <p>Crear Events</p>
                        </div>
                        <div class="menu-item" onclick="location.href='{{ route('control.usuaris') }}'">
                            <div class="icon-card">👥</div>
                            <p>Control Usuaris</p>
                        </div>
                        <div class="menu-item" onclick="location.href='{{ route('control.convidats') }}'">
                            <div class="icon-card">📋</div>
                            <p>Control de Convidats</p>
                        </div>
                    </div>

                    <div class="footer-nav">
                        <a href="{{ route('home') }}" class="back-btn"> < Tornar enrere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/menu_admin.js') }}"></script>
</body>
</html>
