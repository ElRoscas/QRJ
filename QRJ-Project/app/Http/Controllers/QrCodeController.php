<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use App\Mail\QrCodeMail;
use App\Models\User;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    /**
     * Mostra el formulari per crear QR
     */
    public function create()
    {
        // Obtenir usuaris que no tenen QR assignat
        $users = User::where('has_qr', false)->get();
        return view('qr.create', compact('users'));
    }

    /**
     * Genera el codi QR per un usuari
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:usuari,Correu',
            'size' => 'nullable|integer|min:100|max:1000',
            'send_email' => 'nullable|boolean'
        ]);

        $user = User::where('Correu', $request->user_id)->firstOrFail();

        // Verificar que no tingui ja un QR
        if ($user->has_qr) {
            return redirect()->route('qr.create')
                ->with('error', 'Aquest usuari ja té un QR assignat.');
        }

        // Generar codi únic per l'usuari
        $qrCode = 'USER_' . Str::upper(Str::random(16));
        $size = $request->size ?? 300;

        // Generar QR amb endroid/qr-code v6
        $builder = new Builder(
            writer: new PngWriter(),
            data: $qrCode,
            encoding: new Encoding('UTF-8'),
            size: $size,
            margin: 10
        );

        $result = $builder->build();

        // Convertir PNG a base64 per mostrar-lo
        $base64Image = base64_encode($result->getString());

        // Actualitzar usuari amb el codi QR
        $user->update([
            'qr_code' => $qrCode,
            'has_qr' => true,
            'qr_status' => 'fora'
        ]);

        // Si s'ha de enviar per correu
        if ($request->send_email) {
            try {
                // Guardar temporalment el QR com a fitxer
                $filename = 'qr_' . $user->Correu . '_' . time() . '.png';
                $path = storage_path('app/public/temp/' . $filename);

                // Crear directori si no existeix
                if (!file_exists(storage_path('app/public/temp'))) {
                    mkdir(storage_path('app/public/temp'), 0755, true);
                }

                // Guardar el fitxer
                file_put_contents($path, $result->getString());

                Mail::to($user->Correu)->send(new QrCodeMail($user->Nom, $path, $filename));

                // Eliminar el fitxer temporal després d'enviar
                if (file_exists($path)) {
                    unlink($path);
                }

                return redirect()->route('qr.create')
                    ->with('success', 'QR generat per ' . $user->Nom . ' i enviat al seu correu')
                    ->with('qr_image', $base64Image)
                    ->with('user_name', $user->Nom);
            } catch (\Exception $e) {
                return redirect()->route('qr.create')
                    ->with('warning', 'QR generat per ' . $user->Nom . ' però no s\'ha pogut enviar el correu: ' . $e->getMessage())
                    ->with('qr_image', $base64Image)
                    ->with('user_name', $user->Nom);
            }
        }

        return redirect()->route('qr.create')
            ->with('success', 'QR generat correctament per ' . $user->Nom)
            ->with('qr_image', $base64Image)
            ->with('user_name', $user->Nom);
    }

    /**
     * Mostra el formulari per llegir QR
     */
    public function read()
    {
        return view('qr.read');
    }

    /**
     * Descodifica el QR des d'una imatge i valida l'usuari
     */
    public function decode(Request $request)
    {
        // Si ve del escàner amb càmera
        if ($request->has('qr_code')) {
            $qrCode = $request->input('qr_code');

            // Buscar l'usuari amb aquest codi QR
            $user = User::where('qr_code', $qrCode)->first();

            if (!$user) {
                return redirect()->route('qr.read')
                    ->with('error', 'Codi QR no vàlid. No s\'ha trobat cap usuari amb aquest codi.');
            }

            // Canviar l'estat de l'usuari (entrada/sortida)
            $newStatus = $user->qr_status === 'fora' ? 'dins' : 'fora';
            $action = $newStatus === 'dins' ? 'entrar' : 'sortir';

            $user->update(['qr_status' => $newStatus]);

            return redirect()->route('qr.read')
                ->with('success', "El <strong>{$user->Nom}</strong> pot {$action}")
                ->with('user_name', $user->Nom)
                ->with('action', $action)
                ->with('status', $newStatus);
        }

        // Si ve d'upload d'imatge (funcionalitat antiga - mantenir per compatibilitat)
        $request->validate([
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            // Guardar la imatge temporalment
            $path = $request->file('qr_image')->store('qr-uploads', 'public');
            $fullPath = Storage::path('public/' . $path);

            // Intentar llegir el QR amb diferents mètodes
            $qrCode = $this->tryDecodeQr($fullPath);

            // Eliminar imatge temporal
            Storage::delete('public/' . $path);

            if (!$qrCode) {
                return redirect()->route('qr.read')
                    ->with('error', 'No s\'ha pogut llegir el codi QR de la imatge.');
            }

            // Buscar l'usuari amb aquest codi QR
            $user = User::where('qr_code', $qrCode)->first();

            if (!$user) {
                return redirect()->route('qr.read')
                    ->with('error', 'Codi QR no vàlid. No s\'ha trobat cap usuari amb aquest codi.');
            }

            // Canviar l'estat de l'usuari (entrada/sortida)
            $newStatus = $user->qr_status === 'fora' ? 'dins' : 'fora';
            $action = $newStatus === 'dins' ? 'entrar' : 'sortir';

            $user->update(['qr_status' => $newStatus]);

            return redirect()->route('qr.read')
                ->with('success', "El <strong>{$user->Nom}</strong> pot {$action}")
                ->with('user_name', $user->Nom)
                ->with('action', $action)
                ->with('status', $newStatus);

        } catch (\Exception $e) {
            return redirect()->route('qr.read')
                ->with('error', 'Error llegint el QR: ' . $e->getMessage());
        }
    }

    /**
     * Intenta descodificar el QR amb diferents mètodes
     */
    private function tryDecodeQr($imagePath)
    {
        // Método 1: Intentar con Zxing si está disponible
        if (class_exists('\Zxing\QrReader')) {
            try {
                $qrcode = new \Zxing\QrReader($imagePath);
                $text = $qrcode->text();
                if ($text)
                    return $text;
            } catch (\Exception $e) {
                // Continuar con otros métodos
            }
        }

        // TODO: Agregar más métodos de decodificación si es necesario

        return null;
    }

    /**
     * Lector QR en vivo (admin)
     */
    public function scanner()
    {
        return view('qr.scanner');
    }

    /**
     * Procesar QR escaneado
     */
    public function processScan(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string'
        ]);

        $data = $request->qr_data;

        // TODO: Aquí puedes procesar el QR escaneado
        // Por ejemplo, buscar un evento o invitado por el código

        return response()->json([
            'success' => true,
            'message' => 'QR processat correctament',
            'data' => $data
        ]);
    }
}
