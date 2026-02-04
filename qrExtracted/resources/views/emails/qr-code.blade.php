<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El teu codi QR</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #000000;
            background: #000000;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #6b46c1 0%, #5b21b6 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 15px 15px 0 0;
            border: 1px solid rgba(107, 70, 193, 0.3);
            box-shadow: 0 8px 32px rgba(107, 70, 193, 0.3);
        }
        .content {
            background: #1a1a1a;
            padding: 30px;
            border-radius: 0 0 15px 15px;
            border: 1px solid rgba(107, 70, 193, 0.3);
            border-top: none;
            color: #000000;
        }
        .qr-container {
            background: rgba(10, 10, 10, 0.8);
            padding: 20px;
            text-align: center;
            border-radius: 15px;
            margin: 20px 0;
            border: 1px solid rgba(107, 70, 193, 0.4);
            box-shadow: 0 4px 20px rgba(107, 70, 193, 0.2);
        }
        .qr-image {
            max-width: 300px;
            border: 2px solid #8b5cf6;
            padding: 10px;
            border-radius: 10px;
            background: white;
        }
        .info-box {
            background: rgba(139, 92, 246, 0.1);
            padding: 15px;
            border-left: 4px solid #8b5cf6;
            margin: 20px 0;
            border-radius: 5px;
            color: #ffffff;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #9ca3af;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid rgba(107, 70, 193, 0.3);
        }
        ul {
            color: #ffffff;
        }
        ul li {
            margin: 8px 0;
        }
        h1, h3 {
            margin: 0;
        }
        strong {
            color: #8b5cf6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>El teu codi QR està llest!</h1>
    </div>
    
    <div class="content">
        <p>Hola!</p>
        <p>Has generat un nou codi QR amb el següent contingut:</p>
        
        <div class="info-box">
            <strong>Contingut del QR:</strong><br>
            <p style="word-break: break-all; margin: 10px 0;">{{ $qrContent }}</p>
        </div>

        <div class="qr-container">
            <img src="data:image/png;base64,{{ $qrImage }}" alt="Codi QR" class="qr-image">
        </div>

        <p style="margin-top: 30px;">
            Gràcies per utilitzar el nostre sistema de codis QR!
        </p>
    </div>

    <div class="footer">
        <p>Aquest és un correu automàtic generat pel sistema QR.</p>
        <p>&copy; {{ date('Y') }} QR Code System</p>
    </div>
</body>
</html>
