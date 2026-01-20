<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Salle Mollerussa - Accés</title>
   
    <link rel="icon" type="image/png" href="{{ asset('estrella.png') }}">
    
    <link rel="apple-touch-icon" href="{{ asset('estrella.png') }}">

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <div class="desktop-wrapper">
        <div class="container">
            <div class="left-side" id="mainContainer">
                <div class="overlay-text">
                    <h1 class="title-black">
                        LA SALLE 
                        <img src="{{ asset('estrella.png') }}" class="star-img" alt="Estrella">
                    </h1>
                    <h1 class="title-black">MOLLERUSSA</h1>
                    <h2 class="subtitle-white">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-side">
                <h2 class="form-title">Iniciar sessió</h2>
                
                <form action="#" method="POST">
                    @csrf
                    <div class="input-fields">
                        <div class="field">
                            <label>Nom d'usuari o correu electrònic</label>
                            <input type="text" name="email" placeholder="Ex: alumne@lasalle.cat" required>
                        </div>
                        <div class="field">
                            <label>Contrasenya</label>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <p class="separator">o inicia sessió amb</p>
                    
                    <div class="social-actions">
                        <button type="button" class="social-btn">
                            <img src="https://cdn-icons-png.flaticon.com/128/300/300221.png" alt="Google Logo"> 
                            Google
                        </button>
                    </div>

                    <button type="submit" class="login-submit">INICIAR SESSIÓ</button>
                </form>
                
                <p class="footer-link">
                    Si no tens compte, <a href="{{ route('register') }}">Registra't</a>
                </p>
                
                <button type="button" class="continue-without-login" onclick="location.href='{{ route('preview.menu_admin') }}'">
                    Continuar sense login
                </button>
            </div>
        </div>
    </div>
</body>
</html>