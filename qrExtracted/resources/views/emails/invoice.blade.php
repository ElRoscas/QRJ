<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La teva factura</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #000000;
            background: #ffffff;
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
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 15px 15px;
            border: 1px solid rgba(107, 70, 193, 0.3);
            border-top: none;
            color: #000000;
        }
        .invoice-details {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            border: 1px solid rgba(107, 70, 193, 0.4);
            box-shadow: 0 4px 20px rgba(107, 70, 193, 0.2);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(107, 70, 193, 0.2);
            color: #000000;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-row strong {
            color: #8b5cf6;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #9ca3af;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid rgba(107, 70, 193, 0.3);
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #6b46c1 0%, #8b5cf6 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(107, 70, 193, 0.3);
        }
        h1, h2, h3 {
            margin: 0 0 10px 0;
        }
        p {
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📄 Nova Factura</h1>
        <p>Factura #{{ $invoiceData['order_id'] }}</p>
    </div>
    
    <div class="content">
        <p>Hola <strong>{{ $invoiceData['customer_name'] }}</strong>,</p>
        
        <p>T'adjuntem la factura sol·licitada. Trobaràs el document PDF adjunt a aquest correu.</p>

        <div class="invoice-details">
            <h3>Detalls de la Factura</h3>
            
            <div class="detail-row">
                <strong>Número de Factura:</strong>
                <span>#{{ $invoiceData['order_id'] }}</span>
            </div>
            
            <div class="detail-row">
                <strong>Client:</strong>
                <span>{{ $invoiceData['customer_name'] }}</span>
            </div>
            
            <div class="detail-row">
                <strong>Producte/Servei:</strong>
                <span>{{ $invoiceData['item_title'] }}</span>
            </div>
            
            <div class="detail-row">
                <strong>Preu:</strong>
                <span>{{ number_format($invoiceData['price'], 2) }}€</span>
            </div>
            
            @if(isset($invoiceData['tax']) && $invoiceData['tax'] > 0)
            <div class="detail-row">
                <strong>IVA:</strong>
                <span>{{ $invoiceData['tax'] }}%</span>
            </div>
            @endif
        </div>

        <p><strong>📎 Document adjunt:</strong> factura-{{ $invoiceData['order_id'] }}.pdf</p>

        <p>La factura inclou un codi QR amb el número de comanda per facilitar la seva verificació.</p>

        <p style="margin-top: 30px;">
            Si tens qualsevol dubte sobre aquesta factura, no dubtis en contactar amb nosaltres.
        </p>

        <p>Gràcies per la teva confiança!</p>
    </div>

    <div class="footer">
        <p>Aquest és un correu automàtic generat pel sistema de facturació.</p>
        <p>&copy; {{ date('Y') }} Sistema de Facturació</p>
    </div>
</body>
</html>
