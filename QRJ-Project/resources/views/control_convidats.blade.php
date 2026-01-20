<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Convidats - La Salle Mollerussa</title>
    <link rel="stylesheet" href="{{ asset('css/control_convidats.css') }}">
</head>
<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE 
                        <img src="{{ asset('images/estrella.png') }}" class="floating-star" alt="★">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="guests-box">
                    <h1 class="form-heading-black">CONTROL<br>CONVIDATS</h1>
                    
                    <div class="search-bar-container">
                        <div class="search-input filter-wrapper">
                            <select id="filter-select" class="clean-select">
                                <option value="" disabled selected>Filtrar per...</option>
                                <option value="event">Esdeveniment</option>
                                <option value="nom">Nom</option>
                                <option value="estat">Estat</option>
                            </select>
                            <span class="icon">⊶</span>
                        </div>
                        <div class="search-input buscar-wrapper">
                            <input type="text" id="search-input" placeholder="Buscar per nom..." class="clean-input">
                            <span class="icon">🔍</span>
                        </div>
                    </div>

                    <div class="guest-list">
                        @forelse($guests ?? [] as $guest)
                        <div class="guest-entry">
                            <div class="guest-name-tag">{{ $guest->name }}</div>
                            <div class="guest-status">{{ $guest->status ?? 'Pendent' }}</div>
                        </div>
                        @empty
                        <div class="guest-entry">
                            <div class="guest-name-tag">No hi ha convidats registrats</div>
                        </div>
                        @endforelse
                    </div>

                    <div class="actions-container">
                        <button class="create-guest-btn" onclick="alert('Funcionalitat no disponible en preview')">Afegir Convidats</button>
                        <p class="back-link-wrapper">
                            <a href="{{ route('preview.menu_admin') }}" class="back-pill"> < Tornar enrere</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/control_convidats.js') }}"></script>
</body>
</html>
