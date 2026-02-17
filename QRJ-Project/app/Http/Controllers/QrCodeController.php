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
use App\Models\Esdeveniment;
use App\Models\QrCode;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    /**
     * Mostra el formulari per crear QR
     */
    public function create()
    {
        // Obtenir tots els usuaris amb informació de curs i permisos
        $users = User::with(['curs', 'permissos'])->orderBy('Nom')->get();

        // Añadir información de admin a cada usuario
        $users = $users->map(function ($user) {
            $user->is_admin = $user->permissos->where('PermCode', '11111')->isNotEmpty();
            return $user;
        });

        $cursos = \App\Models\Curs::actius()->get();

        // Obtenir esdeveniments propers (data >= avui)
        $esdeveniments = Esdeveniment::where('Data_Esdeveniment', '>=', now())
            ->orderBy('Data_Esdeveniment')
            ->get();

        return view('qr.create', compact('users', 'cursos', 'esdeveniments'));
    }

    /**
     * Genera el codi QR per un usuari
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:usuari,Correu',
            'esdeveniment_id' => 'required|exists:esdeveniments,id',
            'size' => 'nullable|integer|min:100|max:1000',
            'send_email' => 'nullable|boolean',
            'email_subject' => 'nullable|string|max:255',
            'email_body' => 'nullable|string',
        ]);

        $user = User::where('Correu', $request->user_id)->firstOrFail();
        $esdeveniment = Esdeveniment::findOrFail($request->esdeveniment_id);

        // Verificar quants QRs té l'usuari per aquest esdeveniment
        $qrCount = QrCode::where('usuari_correu', $user->Correu)
            ->where('esdeveniment_id', $esdeveniment->id)
            ->count();

        if ($qrCount >= $esdeveniment->max_qrs_per_usuari) {
            return redirect()->route('qr.create')
                ->with('error', "Aquest usuari ja té el màxim de QRs permesos ({$esdeveniment->max_qrs_per_usuari}) per aquest esdeveniment.");
        }

        // Generar codi únic per l'usuari amb format: ESDEVENIMENT - NOM #1
        $qrNumber = $qrCount + 1;
        $qrCode = strtoupper($esdeveniment->Nom) . ' - ' . strtoupper($user->Nom) . ' #' . $qrNumber;
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

        // Crear registre del QR a la base de dades
        QrCode::create([
            'usuari_correu' => $user->Correu,
            'esdeveniment_id' => $esdeveniment->id,
            'qr_code' => $qrCode,
            'qr_sent' => (bool) $request->send_email,
        ]);

        // Actualitzar usuari amb l'últim codi QR (per compatibilitat)
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

                $emailSubject = $request->email_subject ?: 'Codi QR - La Salle Mollerussa';
                $emailBody = $request->email_body;

                Mail::to($user->Correu)->send(new QrCodeMail($user->Nom, $path, $filename, $emailSubject, $emailBody));

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

    /**
     * Envío masivo de QR codes
     */
    public function sendMassive(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:usuari,Correu',
            'esdeveniment_id' => 'required|exists:esdeveniments,id',
            'size' => 'nullable|integer|min:100|max:1000',
        ]);

        $esdeveniment = Esdeveniment::findOrFail($request->esdeveniment_id);
        $size = $request->size ?? 300;
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($request->user_ids as $correuUsuari) {
            $user = User::where('Correu', $correuUsuari)->first();

            if (!$user) {
                $errorCount++;
                $errors[] = "Usuari no trobat: $correuUsuari";
                continue;
            }

            try {
                // Comprovar quants QRs té l'usuari per aquest esdeveniment
                $qrCount = QrCode::where('usuari_correu', $user->Correu)
                    ->where('esdeveniment_id', $esdeveniment->id)
                    ->count();

                if ($qrCount >= $esdeveniment->max_qrs_per_usuari) {
                    $errorCount++;
                    $errors[] = "{$user->Nom} ja té el màxim de QRs permesos ({$esdeveniment->max_qrs_per_usuari}) per aquest esdeveniment.";
                    continue;
                }

                // Generar codi únic per l'usuari amb format semblant al mètode store
                $qrNumber = $qrCount + 1;
                $qrCode = strtoupper($esdeveniment->Nom) . ' - ' . strtoupper($user->Nom) . ' #' . $qrNumber;

                // Generar QR
                $builder = new Builder(
                    writer: new PngWriter(),
                    data: $qrCode,
                    encoding: new Encoding('UTF-8'),
                    size: $size,
                    margin: 10
                );

                $result = $builder->build();

                // Crear registre del QR a la base de dades per a aquest esdeveniment
                QrCode::create([
                    'usuari_correu' => $user->Correu,
                    'esdeveniment_id' => $esdeveniment->id,
                    'qr_code' => $qrCode,
                    'qr_sent' => true,
                ]);

                // Actualitzar usuari (compatibilitat)
                $user->update([
                    'qr_code' => $qrCode,
                    'has_qr' => true,
                    'qr_status' => 'fora'
                ]);

                // Guardar temporalmente y enviar email
                $filename = 'qr_' . $user->Correu . '_' . time() . '.png';
                $path = storage_path('app/public/temp/' . $filename);

                if (!file_exists(storage_path('app/public/temp'))) {
                    mkdir(storage_path('app/public/temp'), 0755, true);
                }

                file_put_contents($path, $result->getString());

                Mail::to($user->Correu)->send(new QrCodeMail($user->Nom, $path, $filename));

                // Eliminar archivo temporal
                if (file_exists($path)) {
                    unlink($path);
                }

                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = "{$user->Nom}: " . $e->getMessage();
            }
        }

        $message = "QR enviats: $successCount";
        if ($errorCount > 0) {
            $message .= " | Errors: $errorCount";
        }

        return redirect()->route('qr.create')
            ->with('success', $message)
            ->with('errors', $errors);
    }
}
