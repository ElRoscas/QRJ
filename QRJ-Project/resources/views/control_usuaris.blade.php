<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Usuaris - La Salle Mollerussa</title>
    @vite(['resources/css/control_usuaris.css'])
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
                <div class="users-box">
                    <h1 class="form-heading-black">CONTROL<br>USUARIS</h1>

                    <div class="search-bar-container">
                        <div class="search-input filter-wrapper">
                            <select id="filter-select" class="clean-select">
                                <option value="" disabled selected>Filtrar per...</option>
                                <option value="curs">Curs</option>
                                <option value="nom">Nom</option>
                                <option value="poblacio">Població</option>
                            </select>
                            <span class="icon">⊶</span>
                        </div>
                        <div class="search-input buscar-wrapper">
                            <input type="text" id="search-input" placeholder="Buscar per nom..." class="clean-input">
                            <span class="icon">🔍</span>
                        </div>
                    </div>

                    <div class="user-list">
                        @forelse($users ?? [] as $user)
                            <div class="user-entry">
                                <div class="user-name-tag">{{ $user->name }}</div>
                                <button class="info-btn" onclick="location.href='{{ route('info.user', $user->id) }}'">Veure
                                    info</button>
                            </div>
                        @empty
                            <div class="user-entry">
                                <div class="user-name-tag">No hi ha usuaris disponibles</div>
                            </div>
                        @endforelse
                    </div>

                    <div class="actions-container">
                        <button class="create-user-btn" onclick="alert('Funcionalitat no disponible en preview')">Crear
                            nou Usuari</button>
                        <p class="back-link-wrapper">
                            <a href="{{ route('preview.menu_admin') }}" class="back-pill">
                                < Tornar enrere</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/control_usuaris.js') }}"></script>
</body>

</html>