<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informació Usuaris - La Salle Mollerussa</title>
    <link rel="stylesheet" href="{{ asset('css/info_user.css') }}">
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
                <div class="info-box">
                    <h1 class="form-heading-black">INFORMACIÓ<br>USUARIS</h1>
                    
                    <div class="user-selector-container">
                        <select class="user-dropdown" onchange="location.href='{{ route('info.user', '') }}/' + this.value">
                            @foreach($users ?? [] as $u)
                            <option value="{{ $u->id }}" {{ isset($user) && $user->id == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @if(isset($user))
                    <div class="user-data-list">
                        <p><strong>Nom:</strong> {{ $user->name }}</p>
                        <p><strong>Cognoms:</strong> {{ $user->surname ?? 'N/A' }}</p>
                        <p><strong>Gmail:</strong> {{ $user->email }}</p>
                        <p><strong>Mobil:</strong> {{ $user->phone ?? 'N/A' }}</p>
                        <p><strong>Curs:</strong> {{ $user->course ?? 'N/A' }}</p>
                    </div>

                    <div class="events-section">
                        <h3 class="section-title">Esdeveniments on participa:</h3>
                        <div class="event-tags">
                            @forelse($user->events ?? [] as $event)
                            <span class="tag">{{ $event->name }}</span>
                            @empty
                            <span class="tag">Cap esdeveniment</span>
                            @endforelse
                        </div>
                    </div>
                    @endif

                    <div class="info-actions">
                        <button class="edit-btn" onclick="location.href='{{ route('user.edit', $user->id ?? 1) }}'">Editar</button>
                        <p class="back-link-wrapper">
                            <a href="{{ route('control.usuaris') }}" class="back-pill"> < Tornar enrere</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/info_user.js') }}"></script>
</body>
</html>
