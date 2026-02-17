<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Usuari - La Salle Mollerussa</title>
    @vite(['resources/css/menu_user.css'])
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
                    <h2 class="admin-subtitle">PANNELL D'USUARI</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="menu-box">
                    <h1 class="menu-title">MENÚ</h1>

                    <div class="menu-grid">
                        <div class="menu-item" onclick="location.href='{{ route('events.user-list') }}'">
                            <div class="icon-card">📅</div>
                            <p>Esdeveniments</p>
                        </div>

                        <div class="menu-item disabled">
                            <div class="icon-card gray">📅<span>+</span></div>
                            <p>Crear Events</p>
                        </div>

                        <div class="menu-item disabled">
                            <div class="icon-card gray">👥</div>
                            <p>Control Usuaris</p>
                        </div>

                        <div class="menu-item disabled">
                            <div class="icon-card gray">📋</div>
                            <p>Control de Convidats</p>
                        </div>
                    </div>

                    <div class="footer-nav">
                        <form method="POST" action="{{ route('fortify.logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="back-btn"
                                style="background: none; border: none; cursor: pointer; font-size: inherit; font-family: inherit; color: inherit; padding: 0;">
                                < Tornar enrere</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/menu_user.js') }}"></script>
</body>

</html>