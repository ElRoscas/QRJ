<?php

namespace App\Services\ImageProcessingService;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Zxing\QrReader;

/**
 * Servei per processar imatges i llegir codis QR
 * Versió sense Imagick - Compatible amb PHP 8.3
 */
class ImageProcessingService
{
    /**
     * Llegeix un codi QR des d'una imatge
     * 
     * @param string $imagePath Ruta de la imatge (relative to storage)
     * @return string|null El contingut del QR o null si no es pot llegir
     */
    public function readQrCodeFromImage(string $imagePath): string|null
    {
        try {
            $fullPath = Storage::path($imagePath);
            
            if (!file_exists($fullPath)) {
                throw new \Exception("Imatge no trobada: $fullPath");
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
     * Llegeix un codi QR des de la imatge guardada (compatibilitat amb codi anterior)
     */
    public function readQrCode(string $filePath): string|null
    {
        return $this->readQrCodeFromImage($filePath);
    }
}
