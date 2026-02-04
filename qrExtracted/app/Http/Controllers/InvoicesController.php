<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\Facades\InvoiceService;
use App\Mail\InvoiceMail;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoicesController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'order_id' => 'required|integer',
            'item_title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tax' => 'nullable|numeric|min:0|max:100',
            'shipping' => 'nullable|numeric|min:0',
        ]);

        // Crear client
        $customer = new Buyer([
            'name' => $validated['customer_name'],
            'custom_fields' => [
                'email' => $validated['customer_email'],
            ],
        ]);

        // Crear producte
        $item = (new InvoiceItem())
            ->title($validated['item_title'])
            ->pricePerUnit($validated['price'])
            ->quantity($request->quantity ?? 1);

        // Generar QR amb PNG utilitzant Imagick
        $qrPng = QrCode::format('png')->size(200)->generate($validated['order_id']);

        // Crear factura
        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent($request->discount ?? 0)
            ->taxRate($request->tax ?? 21)
            ->shipping($request->shipping ?? 0)
            ->addItem($item)
            ->addCustomData([
                'order_id' => $validated['order_id'],
                'qr_data' => base64_encode($qrPng)
            ]);

        $pdfContent = $invoice->render()->output();

        // Guardar temporalment el PDF
        $filename = 'invoice-' . $validated['order_id'] . '.pdf';
        $pdfPath = 'invoices/' . $filename;
        Storage::put($pdfPath, $pdfContent);

        $emailMessage = null;

        // Enviar per correu si està marcat
        if ($request->send_email) {
            try {
                Mail::to($validated['customer_email'])->send(
                    new InvoiceMail($validated, $pdfPath)
                );
                $emailMessage = 'Factura enviada a ' . $validated['customer_email'];
            } catch (\Exception $e) {
                $emailMessage = 'Error enviant el correu: ' . $e->getMessage();
            }
        }

        // Si vol descarregar
        if ($request->download_pdf) {
            Storage::delete($pdfPath); // Netejar després de descarregar
            
            return response()->streamDownload(
                function () use ($pdfContent) {
                    echo $pdfContent;
                },
                $filename,
                ['Content-Type' => 'application/pdf']
            )->with('success', $emailMessage ?? 'Factura generada correctament');
        }

        Storage::delete($pdfPath); // Netejar
        
        return redirect()->route('invoices.index')
            ->with('success', $emailMessage ?? 'Factura generada correctament');
    }
}
