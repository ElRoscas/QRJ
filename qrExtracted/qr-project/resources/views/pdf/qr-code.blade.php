<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El teu Codi QR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a0a2e 50%, #0a0a0a 100%);
            min-height: 100vh;
            padding: 30px;
            color: #000000;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #6b46c1 0%, #5b21b6 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 15px 15px 0 0;
            border: 2px solid rgba(139, 92, 246, 0.6);
            border-bottom: none;
        }
        
        .header h1 {
            font-size: 28px;
            margin: 0;
            letter-spacing: 1px;
        }
        
        .header .subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 8px;
        }
        
        /* Main Card */
        .card {
            background: rgba(17, 17, 27, 0.95);
            border: 2px solid rgba(139, 92, 246, 0.6);
            border-top: none;
            border-radius: 0 0 15px 15px;
            padding: 40px 30px;
        }
        
        /* QR Container */
        .qr-container {
            text-align: center;
            margin: 20px 0 30px;
            padding: 25px;
            background: rgba(10, 10, 10, 0.8);
            border-radius: 15px;
            border: 1px solid rgba(107, 70, 193, 0.4);
        }
        
        .qr-image {
            max-width: 280px;
            width: 100%;
            border: 3px solid #8b5cf6;
            padding: 15px;
            border-radius: 15px;
            background: white;
        }
        
        /* Info Box */
        .info-box {
            background: rgba(139, 92, 246, 0.15);
            padding: 20px;
            border-left: 4px solid #8b5cf6;
            margin: 25px 0;
            border-radius: 0 10px 10px 0;
        }
        
        .info-box .label {
            color: #8b5cf6;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .info-box .content {
            color: #ffffff;
            font-size: 16px;
            word-break: break-all;
            line-height: 1.5;
        }
        
        /* Features Section */
        .features {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid rgba(107, 70, 193, 0.3);
        }
        
        .features h3 {
            color: #8b5cf6;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            color: #ffffff;
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
            font-size: 14px;
        }
        
        .feature-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(107, 70, 193, 0.3);
        }
        
        .footer p {
            color: #9ca3af;
            font-size: 12px;
        }
        
        .footer .brand {
            color: #8b5cf6;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .date {
            color: #6b7280;
            font-size: 11px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>El teu Codi QR</h1>
            <p class="subtitle">QR System - Generat automàticament</p>
        </div>
        
        <!-- Main Card -->
        <div class="card">
            <!-- QR Code -->
            <div class="qr-container">
                <img src="data:image/png;base64,{{ $qrImage }}" alt="Codi QR" class="qr-image">
            </div>
            
            <!-- Content Info -->
            <div class="info-box">
                <div class="label">Contingut del QR</div>
                <div class="content">{{ $qrContent }}</div>
            </div>
            
            <!-- Features -->
            <div class="features">
                <h3>Com utilitzar aquest QR:</h3>
                <ul class="feature-list">
                    <li>Escaneja amb la càmera del teu mòbil</li>
                    <li>Utilitza la nostra pagina o qualsevol app de lectura QR</li>
                    <li>Imprimeix aquest PDF per compartir-lo</li>
                    <li>El codi QR no caduca mai</li>
                </ul>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p class="brand">QR System</p>
                <p>Generat amb Laravel & DomPDF</p>
                <p class="date">Data de generació: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
