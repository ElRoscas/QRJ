<?php

namespace App\Services\ImageProcessingService;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Zxing\QrReader;

/**
 * Versió ALTERNATIVA sense Imagick ni ZBar
 * Utilitza khanamiryan/qrcode-detector-decoder (PHP pur)
 */
class ImageProcessingServiceAlternative
{
    /**
     * Llegeix un codi QR des d'una imatge PNG/JPG
     * Nota: No funciona directament amb PDF, necessita convertir primer
     */
    public function readQrCodeFromImage(string $imagePath): string|null
    {
        try {
            $fullPath = Storage::path($imagePath);
            
            if (!file_exists($fullPath)) {
                throw new \Exception("Fitxer no trobat: $fullPath");
            }

            $qrcode = new QrReader($fullPath);
            $text = $qrcode->text();
            
            return $text ?: null;
        } catch (\Exception $e) {
            \Log::error("Error llegint QR code: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Per llegir des de PDF necessitaries:
     * 1. Convertir PDF a imatge (amb GD o similar)
     * 2. Extreure la regió del QR
     * 3. Llegir amb QrReader
     */
    public function readQrCodeFromPdfSimple(string $pdfPath): string|null
    {
        // Aquesta és una implementació simplificada
        // Per utilitzar-la, primer hauries de tenir la imatge del QR extreta
        
        return "Implementació simplificada - requereix imatge PNG/JPG directament";
    }
}
