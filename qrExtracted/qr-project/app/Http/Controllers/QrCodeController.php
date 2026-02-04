<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Zxing\QrReader;
use App\Mail\QrCodeMail;
use Barryvdh\DomPDF\Facade\Pdf;

class QrCodeController extends Controller
{
    /**
     * Mostra el formulari per crear QR
     */
    public function create()
    {
        return view('qr.create');
    }

    /**
     * Genera el codi QR
     */
    public function store(Request $request)
    {
        $request->validate([
            'qr_content' => 'required|string|max:1000',
            'size' => 'nullable|integer|min:100|max:1000',
            'email' => 'nullable|email'
        ]);

        $content = $request->qr_content;
        $size = $request->size ?? 300;

        // Generar QR amb PNG utilitzant Imagick
        $qrPng = QrCode::format('png')
            ->size($size)
            ->generate($content);

        // Convertir PNG a base64 per mostrar-lo
        $base64Image = base64_encode($qrPng);

        // Si hi ha email, enviar per correu amb PDF adjunt
        if ($request->email) {
            try {
                // Generar el PDF amb el QR
                $pdf = Pdf::loadView('pdf.qr-code', [
                    'qrContent' => $content,
                    'qrImage' => $base64Image
                ]);
                
                $pdfContent = $pdf->output();
                
                Mail::to($request->email)->send(new QrCodeMail($content, $base64Image, $pdfContent));
                
                return redirect()->route('qr.create')
                    ->with('success', 'QR generat i enviat a ' . $request->email . ' amb PDF adjunt!')
                    ->with('qr_image', $base64Image);
            } catch (\Exception $e) {
                return redirect()->route('qr.create')
                    ->with('error', 'QR generat però no s\'ha pogut enviar el correu: ' . $e->getMessage())
                    ->with('qr_image', $base64Image);
            }
        }

        return redirect()->route('qr.create')
            ->with('success', 'QR generat correctament!')
            ->with('qr_image', $base64Image);
    }

    /**
     * Mostra el formulari per llegir QR
     */
    public function read()
    {
        return view('qr.read');
    }

    /**
     * Descodifica el QR des d'una imatge
     */
    public function decode(Request $request)
    {
        $request->validate([
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            // Guardar la imatge
            $path = $request->file('qr_image')->store('qr-uploads', 'public');
            $fullPath = Storage::path('public/' . $path);

            // Llegir el QR
            $qrcode = new QrReader($fullPath);
            $text = $qrcode->text();

            if (!$text) {
                return redirect()->route('qr.read')
                    ->with('error', 'No s\'ha pogut llegir el codi QR de la imatge. Assegura\'t que la imatge contingui un codi QR vàlid.');
            }

            return redirect()->route('qr.read')
                ->with('success', 'Codi QR llegit correctament!')
                ->with('decoded_content', $text)
                ->with('uploaded_image', $path);

        } catch (\Exception $e) {
            return redirect()->route('qr.read')
                ->with('error', 'Error llegint el QR: ' . $e->getMessage());
        }
    }
}
