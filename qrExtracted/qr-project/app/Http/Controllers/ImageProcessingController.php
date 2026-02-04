<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Services\Facades\ImageProcessingService;

class ImageProcessingController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * Llegeix el QR des de la imatge PNG guardada
     * Compatible amb PHP 8.3 (sense Imagick)
     */
    public function __invoke(): JsonResponse
    {
        try {
            $imagePath = 'public/qr-code.png';
            
            if (!Storage::exists($imagePath)) {
                return response()->json([
                    'error' => 'QR code image not found. Generate an invoice first at /get-invoice',
                    'expected_path' => Storage::path($imagePath)
                ], 404);
            }

            $code = ImageProcessingService::readQrCodeFromImage($imagePath);
            
            if (!$code) {
                return response()->json([
                    'error' => 'No s\'ha pogut llegir el codi QR de la imatge'
                ], 400);
            }
            
            return response()->json([
                'code' => $code,
                'method' => 'PHP Pure (Zxing/QrReader)',
                'note' => 'Compatible amb PHP 8.3 - No requereix Imagick'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

