<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esdeveniments - La Salle Mollerussa</title>
    <link rel="stylesheet" href="{{ asset('css/esdeveniments.css') }}">
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
                    <h1 class="page-title-black">ESDEVENIMENT</h1>
                    
                    <div class="event-grid">
                        @foreach($events ?? [] as $event)
                        <div class="event-item" onclick="location.href='{{ route('event.show', $event->id) }}'">
                            <div class="icon-square">{{ $event->icon ?? '📅' }}</div>
                            <p>{{ $event->name }}</p>
                        </div>
                        @endforeach
                        
                        <div class="event-item full-width" onclick="location.href='{{ route('event.create') }}'">
                            <div class="icon-square">📅<span>+</span></div>
                            <p>Crear un de nou</p>
                        </div>
                    </div>

                    <div class="footer-nav">
                        <a href="{{ route('preview.menu_admin') }}" class="back-pill"> < Tornar enrere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/esdeveniments.js') }}"></script>
</body>
</html>
