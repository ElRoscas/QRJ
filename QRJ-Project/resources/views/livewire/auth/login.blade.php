<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessió - La Salle Mollerussa</title>

    <link rel="icon" type="image/png" href="{{ asset('estrella.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('estrella.png') }}">

    @vite(['resources/css/index.css'])
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

                <form action="{{ route('fortify.login') }}" method="POST">
                    @csrf
                    <div class="input-fields">
                        @if ($errors->any())
                            <div class="error-message">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="field">
                            <label>Correu electrònic</label>
                            <input type="email" name="Correu" value="{{ old('Correu') }}"
                                placeholder="Ex: admin@lasalle.cat" required autofocus>
                        </div>
                        <div class="field">
                            <label>Contrasenya</label>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="main-btn">Iniciar Sessió</button>
                </form>

                @if (Route::has('register'))
                    <p class="signup-text">
                        No tens compte? <a href="{{ route('register') }}">Registra't aquí</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>