<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('estrella.png') }}">

    <link rel="apple-touch-icon" href="{{ asset('estrella.png') }}">
    <title>Registre - La Salle Mollerussa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* --- CONFIGURACIÓ GENERAL --- */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial Black', sans-serif;
            /* Font gruixuda per al títol */
            background-color: #0d1117;
            /* Fons fosc de l'aplicació */
        }

        .desktop-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 15px;
        }

        .main-container {
            width: 1000px;
            height: 600px;
            display: flex;
            background-color: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        /* --- PANEL ESQUERRE --- */
        .left-side {
            flex: 1.3;
            position: relative;
            display: flex;
            align-items: center;
            padding-left: 50px;
            background-color: #3b4e8d;
            /* Gradient blau semi-transparent sobre la imatge fondos.png */
            background-image: linear-gradient(rgba(59, 78, 141, 0.8), rgba(59, 78, 141, 0.8)),
                url("{{ asset('fondos.png') }}");
            background-size: cover;
            background-position: center;
        }

        .brand-content {
            position: relative;
            z-index: 10;
        }

        .main-title {
            color: #000;
            font-size: 3.5rem;
            font-weight: 900;
            margin: 0;
            line-height: 0.9;
            text-transform: uppercase;
            position: relative;
        }

        /* L'estrella penjant al costat del títol */
        .star-img {
            width: 70px;
            height: auto;
            position: absolute;
            top: -10px;
            right: 35px;
            /* Ajustat per quedar al costat de la lletra E */
            transform: rotate(10deg);
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
        }

        .admin-subtitle {
            color: #fff;
            font-size: 1.4rem;
            margin-top: 30px;
            text-transform: uppercase;
            font-family: 'Segoe UI', sans-serif;
            font-weight: 800;
            letter-spacing: 1px;
        }

        /* --- PANEL DRET --- */
        .right-side {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #ffffff;
        }

        .form-title {
            font-size: 2rem;
            color: #1a1a1a;
            margin-bottom: 30px;
            font-weight: 900;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .divider {
            text-align: center;
            font-size: 0.75rem;
            color: #888;
            margin: 20px 0 15px;
            text-transform: uppercase;
            font-weight: 800;
        }

        .google-btn {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 25px;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-weight: 600;
            color: #555;
            transition: background 0.2s;
        }

        .google-btn img {
            width: 18px;
        }

        .submit-btn {
            background: linear-gradient(to right, #003366 0%, #003366 45%, #ffcc00 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 30px;
            font-weight: 900;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .footer-link {
            text-align: center;
            font-size: 0.9rem;
            margin-top: 25px;
            font-weight: 700;
        }

        .footer-link a {
            color: #008cff;
            text-decoration: none;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                height: auto;
                width: 95%;
            }

            .left-side {
                padding: 50px 20px;
                justify-content: center;
                text-align: center;
                min-height: 250px;
            }

            .star-img {
                width: 45px;
                position: static;
                display: inline-block;
                vertical-align: middle;
                margin-left: 10px;
            }

            .main-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-side">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE<br>MOLLERUSSA
                        <img src="{{ asset('estrella.png') }}" class="star-img" alt="Estrella">
                    </h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-side">
                <div class="login-box">
                    <h1 class="form-title">Registre</h1>

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        @if ($errors->any())
                            <div class="error-message">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nom complet">
                        </div>

                        <div class="form-group">
                            <label>Correu electrònic</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="Ex: alumne@lasalle.cat">
                        </div>

                        <div class="form-group">
                            <label>Contrasenya</label>
                            <input type="password" name="password" required placeholder="••••••••">
                        </div>

                        <div class="form-group">
                            <label>Confirmar Contrasenya</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••">
                        </div>

                        <button type="submit" class="submit-btn">Registra't</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>