<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduació La Salle Mollerussa</title>
    <link rel="stylesheet" href="{{ asset('css/graduacio.css') }}">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <h2 class="admin-subtitle">CONTROL D'ACCÉS EN TEMPS REAL</h2>
                </div>
            </div>

            <div class="right-panel">
                <h1 class="page-title-black">LECTOR QR</h1>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="label">Alumnes arribats</span>
                        <span id="count-alumnes" class="value">{{ $stats['alumnes'] ?? 0 }}</span>
                    </div>
                    <div class="stat-card">
                        <span class="label">Assistents</span>
                        <span id="count-assistents" class="value">{{ $stats['assistents'] ?? 0 }}</span>
                    </div>
                    <div class="stat-card">
                        <span class="label">Fora recinte</span>
                        <span id="count-fora" class="value">{{ $stats['fora'] ?? 450 }}</span>
                    </div>
                    <div class="stat-card highlight">
                        <span class="label">QR Llegits</span>
                        <span id="count-qr" class="value">{{ $stats['qr_llegits'] ?? 0 }}</span>
                    </div>
                </div>

                <div id="reader-frame">
                    <div id="qr-reader"></div>
                </div>

                <div id="feedback-display">
                    <p id="qr-result">Escaneja un codi per registrar l'entrada</p>
                </div>

                <div class="footer-nav">
                    <a href="{{ route('menu.admin') }}" class="back-pill"> < Tornar enrere</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/graduacio.js') }}"></script>
</body>
</html>
