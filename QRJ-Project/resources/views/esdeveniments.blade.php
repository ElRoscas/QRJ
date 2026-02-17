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
                        <img src="{{ asset('estrella.png') }}" class="floating-star" alt="estrella">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-panel" style="height: 100%; overflow-y: scroll;">
                <div class="menu-box">
                    <h1 class="page-title-black">ESDEVENIMENTS</h1>

                    @if(session('success'))
                        <div class="alert alert-success"
                            style="background: #4ade80; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="event-grid">
                        @if(isset($events) && count($events) > 0)
                            @foreach($events as $event)
                                <div class="event-item" onclick="location.href='{{ route('esdeveniment.show', $event->id) }}'">
                                    <div class="icon-square">📅</div>
                                    <p>{{ $event->Nom ?? 'Sin nombre' }}</p>
                                    <small style="display: block; margin-top: 0.5rem; color: #666;">
                                        {{ $event->Data_Esdeveniment ? \Carbon\Carbon::parse($event->Data_Esdeveniment)->format('d/m/Y') : 'Sin fecha' }}
                                    </small>
                                </div>
                            @endforeach
                        @else
                            <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: #666;">
                                <p>No hi ha esdeveniments disponibles</p>
                            </div>
                        @endif
                    </div>

                    <div class="footer-nav" style="width: 100%; display: flex; justify-content: center; margin-top: auto; padding-top: 20px;">
                        <a href="{{ $backRoute ?? route('home') }}" class="back-pill">
                            < Tornar enrere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/esdeveniments.js') }}"></script>
</body>

</html>