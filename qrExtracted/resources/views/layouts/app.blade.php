<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SISTEMA QR - LA SALLE')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --ls-blue: #033473;
            --ls-blue-medium: #3b4e8d;
            --ls-yellow: #facc15;
            --ls-bg-dark: #0d1117;

            --radius-xl: 24px;
            --shadow-main: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            --transition-base: 0.3s ease;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            -webkit-text-size-adjust: 100%;
            scroll-behavior: smooth;
        }

        body, html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: var(--ls-bg-dark);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Contenidor Principal Responsive */
        .main-container {
            width: 100%;
            max-width: 1150px;
            margin: 1rem;
            display: flex;
            flex-direction: row;
            background-color: #fff;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-main);
            min-height: 750px;
            transition: all var(--transition-base);
        }

        /* Sidebar */
        .sidebar {
            flex: 0 0 35%;
            min-width: 320px;
            background-color: var(--ls-blue-medium);
            background-image:
                linear-gradient(rgba(59, 78, 141, 0.85), rgba(59, 78, 141, 0.85)),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 0l8 22h22l-18 14 7 22-19-14-19 14 7-22-18-14h22z' fill='%23ffffff' fill-opacity='0.1'/%3E%3C/svg%3E");
            padding: clamp(2rem, 5vw, 3rem) 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
            position: relative;
        }

        .sidebar h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            line-height: 0.95;
            text-transform: uppercase;
            color: #000;
            margin: 0;
            letter-spacing: -1px;
        }

        .sidebar .subtitle {
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 1.5rem;
            font-size: 1rem;
            letter-spacing: 2px;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Àrea de Contingut */
        .content-area {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            background: #fff;
            max-height: 90vh;
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        .content-area::-webkit-scrollbar {
            width: 10px;
        }

        .content-area::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.15);
            border-radius: 999px;
        }

        /* Media Queries */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
                max-width: 700px;
                min-height: auto;
                height: auto;
            }

            .sidebar {
                flex: none;
                width: 100%;
                min-width: 0;
                padding: 4rem 2rem;
                text-align: center;
                align-items: center;
            }

            .content-area {
                max-height: none;
                padding: 2.5rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            body {
                align-items: flex-start;
            }

            .main-container {
                margin: 0;
                border-radius: 0;
            }

            .sidebar h1 {
                font-size: 2.2rem;
            }
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        :focus-visible {
            outline: 3px solid var(--ls-yellow);
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="main-container shadow-lg">
        <aside class="sidebar">
            <div class="text-container">
                <h1>LA SALLE<br>MOLLERUSSA</h1>
                <p class="subtitle">Administrador d'Esdeveniments</p>
            </div>
        </aside>

        <main class="content-area">
            <div class="container-fluid">
                @yield('content')
            </div>

            <footer class="mt-auto pt-5 text-center text-muted small">
                <div class="border-top pt-3">
                    © {{ date('Y') }} La Salle Mollerussa | Sistema de Codis QR
                </div>
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
