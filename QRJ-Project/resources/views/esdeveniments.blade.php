<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esdeveniments - La Salle Mollerussa</title>
    @vite(['resources/css/esdeveniments.css'])
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
                <div class="menu-box">
                    <h1 class="page-title-black">ESDEVENIMENTS</h1>

                    @if(session('success'))
                        <div class="alert alert-success"
                            style="background: #4ade80; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="event-grid">
                        @forelse($events ?? [] as $event)
                            <div class="event-item" onclick="location.href='#'">
                                <div class="icon-square">📅</div>
                                <p>{{ $event->Nom }}</p>
                                <small style="display: block; margin-top: 0.5rem; color: #666;">
                                    {{ \Carbon\Carbon::parse($event->Data_Esdeveniment)->format('d/m/Y') }}
                                </small>
                            </div>
                        @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: #666;">
                                <p>No hi ha esdeveniments disponibles</p>
                            </div>
                        @endforelse

                        @auth
                            @if(auth()->user()->permissos()->where('PermCode', '11111')->exists())
                                <div class="event-item full-width" onclick="location.href='{{ route('esdeveniment.create') }}'">
                                    <div class="icon-square">📅<span>+</span></div>
                                    <p>Crear un de nou</p>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <div class="footer-nav">
                        <a href="{{ url()->previous() }}" class="back-pill">
                            < Tornar enrere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/esdeveniments.js') }}"></script>
</body>

</html>