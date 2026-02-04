<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codi QR - La Salle Mollerussa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #033473 0%, #3b4e8d 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .content p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .attachment-notice {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: left;
        }

        .attachment-notice p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }

        height: auto;
        border: 3px solid #033473;
        border-radius: 5px;
        }

        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #033473;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }

        .info-box strong {
            color: #033473;
        }

        .footer {
            background-color: #f8f9fa;
            color: #666;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }

        .footer a {
            color: #033473;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>LA SALLE MOLLERUSSA</h1>
            <p>Sistema de Codis QR</p>
        </div>

        <div class="content">
            <p>Hola,</p>
            <p>Aquí tens el codi QR que has sol·licitat com a fitxer adjunt.</p>

            <div class="attachment-notice">
                <p><strong>📎 Fitxer adjunt</strong><br>
                    El codi QR s'ha adjuntat com a fitxer PNG. Descarrega'l per utilitzar-lo.</p>
            </div>

            <div class="info-box">
                <strong>Contingut del QR:</strong><br>
                <code style="word-break: break-all;">{{ $qrContent }}</code>
            </div>

            <p style="color: #999; font-size: 14px; margin-top: 30px;">
                Pots escanejar el codi QR descarregant el fitxer adjunt.
            </p>
        </div>

        <div class="footer">
            <p>
                Aquest correu ha estat enviat automàticament pel sistema de gestió d'esdeveniments.<br>
                <strong>LA SALLE MOLLERUSSA</strong>
            </p>
        </div>
    </div>
</body>

</html>