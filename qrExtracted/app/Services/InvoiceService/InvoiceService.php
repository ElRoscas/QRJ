<?php

namespace App\Services\InvoiceService;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoiceService
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function createInvoiceAsPdf(): string
    {
        $orderId = 12345;
        
        $customer = new Buyer([
            'name'          => 'John Doe',
            'custom_fields' => [
                'email' => 'test@example.com',
            ],
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        // Generar QR amb PNG utilitzant Imagick
        $qrPng = QrCode::format('png')->size(200)->generate($orderId);
        
        // També guardar com a imatge per poder llegir-lo després
        Storage::put('public/qr-code.png', $qrPng);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(2)
            ->addItem($item)
            ->addCustomData([
                'order_id' => $orderId,
                'qr_data' => base64_encode($qrPng)
            ]);

        return $invoice->render()->output();
    }
}
