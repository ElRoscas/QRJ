<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre - La Salle Mollerussa</title>
    <link rel="stylesheet" href="{{ asset('css/registre.css') }}">
</head>
<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE 
                        <img src="{{ asset('estrella.png') }}" class="star-img" alt="estrella">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="form-box">
                    <h1 class="form-heading-black">REGISTRE</h1>
                    
                    <form class="registration-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="input-group">
                            <label>Nom :</label>
                            <input type="text" name="name" placeholder="El teu nom" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="input-group">
                            <label>Correu :</label>
                            <input type="email" name="email" placeholder="correu@exemple.com" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="input-group">
                            <label>Telefon :</label>
                            <input type="tel" name="phone" placeholder="000 000 000" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="input-group">
                            <label>Contrasenya :</label>
                            <input type="password" name="password" placeholder="********" required>
                            @error('password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="input-group">
                            <label>Repetir Contrasenya :</label>
                            <input type="password" name="password_confirmation" placeholder="********" required>
                        </div>
                        
                        <div class="login-redirect">
                            <span>O Inicia Sessió:</span>
                            <button type="button" class="log-in-btn" onclick="location.href='{{ route('login') }}'">LOG IN</button>
                        </div>
                        
                        <button type="submit" class="submit-btn" style="display:none;">Registrar</button>
                    </form>

                    <p class="back-link">
                        <a href="{{ route('home') }}"> < Tornar enrere</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/registre.js') }}"></script>
</body>
</html>
