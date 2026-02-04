<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El teu codi QR</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.4;
            color: #333333;
            background: #0f172a; /* Fons fosc exterior */
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        /* Contenidor principal que simula la targeta de la imatge */
        .main-container {
            display: flex;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            min-height: 500px;
        }
        /* Part esquerra (Blava amb estrelles) */
        .sidebar {
            flex: 1;
            background-color: #4c669f;
            background-image: radial-gradient(circle at 20px 20px, rgba(255,255,255,0.1) 2%, transparent 0%);
            background-size: 40px 40px;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        .sidebar h2 {
            font-size: 3.5rem;
            line-height: 0.9;
            margin: 0;
            font-weight: 900;
            text-transform: uppercase;
        }
        .sidebar .star {
            color: #facc15;
            font-size: 3rem;
            position: absolute;
            top: 40%;
            right: 30px;
        }
        .sidebar .subtitle {
            margin-top: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            font-size: 1.1rem;
        }
        /* Part dreta (Contingut blanc) */
        .content {
            flex: 1;
            padding: 40px;
            background: #ffffff;
        }
        .header-badge {
            background: linear-gradient(to right, #033473, #facc15);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .header-badge h1 {
            font-size: 1.2rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .welcome-text {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        .info-box {
            background: #f1f5f9;
            padding: 15px;
            border-left: 5px solid #3b82f6;
            margin: 15px 0;
            border-radius: 4px;
        }
        .info-box strong {
            color: #1e293b;
            display: block;
            margin-bottom: 5px;
        }
        .info-box.pdf {
            background: #ecfdf5;
            border-left-color: #10b981;
        }
        .info-box.pdf strong {
            color: #065f46;
        }
        h3 {
            color: #1e3a8a;
            margin-top: 25px;
            font-size: 1.2rem;
        }
        ul {
            padding-left: 20px;
            margin-bottom: 30px;
        }
        ul li {
            margin: 5px 0;
            font-size: 0.9rem;
        }
        .footer {
            background: #f8fafc;
            padding: 15px;
            border-radius: 4px;
            font-size: 0.8rem;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="sidebar">
            <h2>LA SALLE MOLLERUSSA</h2>
            <div class="star">★</div>
            <div class="subtitle">ADMINISTRADOR D'ESDEVENIMENTS</div>
        </div>

        <div class="content">
            <div class="header-badge">
                <h1>🔲 El teu codi QR està llest!</h1>
            </div>
            
            <p class="welcome-text">Hola!</p>
            <p>Has generat un nou codi QR amb el següent contingut:</p>
            
            <div class="info-box">
                <strong>Contingut del QR:</strong>
                <span style="word-break: break-all;">{{ $qrContent }}</span>
            </div>

            <div class="info-box pdf">
                <strong>📎 Adjunt PDF:</strong>
                <p style="margin: 0; font-size: 0.9rem;">
                    Hem adjuntat el teu codi QR en format PDF per a que el puguis descarregar, imprimir o compartir fàcilment.
                </p>
            </div>

            <h3>Com utilitzar el QR:</h3>
            <ul>
                <li>Escaneja amb la càmera del teu mòbil</li>
                <li>Utilitza la nostra pàgina o qualsevol app</li>
                <li>Imprimeix el PDF adjunt</li>
            </ul>

            <div class="footer">
                <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                    <span style="color: #3b82f6;">🔲</span> <strong>QR System - Generat amb Laravel</strong>
                </div>
                <p style="margin: 0;">Aquest és un correu automàtic generat pel sistema QR.</p>
                <p style="margin: 0;">&copy; {{ date('Y') }} QR Code System</p>
            </div>
        </div>
    </div>
</body>
</html>