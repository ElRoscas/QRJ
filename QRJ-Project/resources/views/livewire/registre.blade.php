<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre - La Salle Mollerussa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE 
                        <img src="{{ asset('estrella.png') }}" class="floating-star" alt="★">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="form-box">
                    <h1 class="form-heading-black">REGISTRE</h1>
                    
                    <form action="#" method="POST" class="registration-form">
                        @csrf
                        <div class="input-group">
                            <label>Nom :</label>
                            <input type="text" name="nom" placeholder="El teu nom" required>
                        </div>
                        <div class="input-group">
                            <label>Correu :</label>
                            <input type="email" name="email" placeholder="correu@exemple.com" required>
                        </div>
                        <div class="input-group">
                            <label>Telefon :</label>
                            <input type="tel" name="telefon" placeholder="000 000 000">
                        </div>
                        <div class="input-group">
                            <label>Contrasenya :</label>
                            <input type="password" name="password" placeholder="********" required>
                        </div>
                        <div class="input-group">
                            <label>Repetir Contrasenya :</label>
                            <input type="password" name="password_confirmation" placeholder="********" required>
                        </div>
                        
                        <div class="login-redirect">
                            <span>O Inicia Sessió:</span>
                            <button type="submit" class="log-in-btn">LOG IN</button>
                        </div>
                    </form>

                    <p class="back-link">
                        <a href="{{ url('/') }}"> < Tornar enrere</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = () => {
            const container = document.getElementById('starContainer');
            if (container) {
                // Generem estrelles ambientals al panell blau
                for (let i = 0; i < 20; i++) {
                    const star = document.createElement('div');
                    star.innerHTML = '★';
                    star.className = 'bg-star';
                    star.style.left = Math.random() * 100 + '%';
                    star.style.top = Math.random() * 100 + '%';
                    star.style.fontSize = (Math.random() * 20 + 10) + 'px';
                    container.appendChild(star);
                }
            }
        };
    </script>
</body>
</html>