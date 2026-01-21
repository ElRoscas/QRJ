<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Esdeveniments - La Salle Mollerussa</title>
    @vite(['resources/css/crear_esdeveniments.css'])
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
                <div class="form-card">
                    <h1 class="form-title">
                        CREAR<br>
                        ESDEVENIMENTS<span class="star-icon">★</span>
                    </h1>

                    <form class="event-form" method="POST" action="{{ route('esdeveniment.store') }}">
                        @csrf

                        @if(session('success'))
                            <div class="alert alert-success"
                                style="background: #4ade80; color: white; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label>Tipus de esdeveniments</label>
                            <input type="text" name="type" class="form-input" value="{{ old('type') }}" required>
                            @error('type')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Número de invitats</label>
                            <input type="number" name="guests" class="form-input" value="{{ old('guests') }}" required>
                            @error('guests')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Ubicació</label>
                            <input type="text" name="location" class="form-input" value="{{ old('location') }}"
                                required>
                            @error('location')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Data de l'esdeveniment</label>
                            <input type="date" name="event_date" class="form-input" value="{{ old('event_date') }}"
                                required>
                            @error('event_date')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Hora inici esdeveniment</label>
                            <input type="time" name="start_time" class="form-input" value="{{ old('start_time') }}"
                                required>
                            @error('start_time')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Data limit de confirmació</label>
                            <input type="date" name="confirmation_deadline" class="form-input"
                                value="{{ old('confirmation_deadline') }}" required>
                            @error('confirmation_deadline')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="submit-btn">Crear Esdeveniment</button>
                    </form>

                    <div class="back-link-container">
                        <a href="{{ route('esdeveniments') }}" class="back-link">
                            <span class="arrow">←</span> Tornar enrere
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/crear_esdeveniments.js') }}"></script>
</body>

</html>