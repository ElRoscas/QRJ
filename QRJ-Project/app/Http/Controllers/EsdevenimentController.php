<?php

namespace App\Http\Controllers;

use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EsdevenimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Esdeveniment::with(['user', 'assistents'])
            ->orderBy('Data_Esdeveniment', 'desc')
            ->get();

        $user = auth()->user();
        $isAdmin = $user
            ? $user->permissos()->where('PermCode', '11111')->exists()
            : false;
        $backRoute = $isAdmin ? route('menu_admin') : route('menu_user');

        return view('esdeveniments', compact('events', 'backRoute', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('CrearEsdeveniments');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'guests' => 'required|integer|min:0',
            'max_qrs_per_usuari' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'confirmation_deadline' => 'required|date|before_or_equal:event_date',
        ], [
            'type.required' => 'El tipus d\'esdeveniment és obligatori.',
            'guests.required' => 'El número d\'invitats és obligatori.',
            'guests.integer' => 'El número d\'invitats ha de ser un número.',
            'max_qrs_per_usuari.required' => 'El màxim de QRs per usuari és obligatori.',
            'max_qrs_per_usuari.integer' => 'El màxim de QRs per usuari ha de ser un número.',
            'max_qrs_per_usuari.min' => 'El màxim de QRs per usuari ha de ser com a mínim 1.',
            'location.required' => 'La ubicació és obligatòria.',
            'event_date.required' => 'La data de l\'esdeveniment és obligatòria.',
            'event_date.after_or_equal' => 'La data de l\'esdeveniment no pot ser en el passat.',
            'start_time.required' => 'L\'hora d\'inici és obligatòria.',
            'confirmation_deadline.required' => 'La data límit de confirmació és obligatòria.',
            'confirmation_deadline.before_or_equal' => 'La data límit ha de ser abans o igual a la data de l\'esdeveniment.',
        ]);

        Esdeveniment::create([
            'ID_USER' => Auth::user()->Correu,
            'Nom' => $validated['type'],
            'Tipus' => $validated['type'],
            'Nº_Invitats' => $validated['guests'],
            'max_qrs_per_usuari' => $validated['max_qrs_per_usuari'],
            'Ubicacio' => $validated['location'],
            'Data_Esdeveniment' => $validated['event_date'],
            'Hora_Inici' => $validated['start_time'],
            'Data_Limit_Confirmacio' => $validated['confirmation_deadline'],
        ]);

        return redirect()->route('esdeveniment.index')
            ->with('success', 'Esdeveniment creat correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Esdeveniment $esdeveniment)
    {
        // Load event with users who have QR codes and their course info
        $esdeveniment->load('user', 'assistents.usuari.curs');

        // Get all users with QR codes, ordered by name, with course and permissions
        $users = \App\Models\User::with(['curs', 'permissos'])
            ->where('has_qr', true)
            ->orderBy('Nom')
            ->get();

        // Add is_admin flag to each user
        $users = $users->map(function ($user) {
            $user->is_admin = $user->permissos->where('PermCode', '11111')->isNotEmpty();
            return $user;
        });

        // Check if current user is admin
        $isAdmin = auth()->user()->permissos()->where('PermCode', '11111')->exists();

        $cursos = \App\Models\Curs::actius()->get();

        return view('esdeveniment_detall', compact('esdeveniment', 'users', 'cursos', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Esdeveniment $esdeveniment)
    {
        return view('CrearEsdeveniments', compact('esdeveniment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Esdeveniment $esdeveniment)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'guests' => 'required|integer|min:0',
            'max_qrs_per_usuari' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'confirmation_deadline' => 'required|date|before_or_equal:event_date',
        ]);

        // Check if max_qrs_per_usuari is being reduced
        $oldMax = $esdeveniment->max_qrs_per_usuari;
        $newMax = $validated['max_qrs_per_usuari'];

        $esdeveniment->update([
            'Nom' => $validated['type'],
            'Tipus' => $validated['type'],
            'Nº_Invitats' => $validated['guests'],
            'max_qrs_per_usuari' => $newMax,
            'Ubicacio' => $validated['location'],
            'Data_Esdeveniment' => $validated['event_date'],
            'Hora_Inici' => $validated['start_time'],
            'Data_Limit_Confirmacio' => $validated['confirmation_deadline'],
        ]);

        // If limit was reduced, clean up excess QRs
        if ($newMax < $oldMax) {
            // Get all users with their QR counts for this event
            $usersWithQrs = \App\Models\QrCode::where('esdeveniment_id', $esdeveniment->id)
                ->select('usuari_correu', \DB::raw('COUNT(*) as qr_count'))
                ->groupBy('usuari_correu')
                ->having('qr_count', '>', $newMax)
                ->get();

            // For each user with excess QRs, delete the newest ones
            foreach ($usersWithQrs as $userQr) {
                $excessCount = $userQr->qr_count - $newMax;

                // Delete the newest QRs (keep the oldest)
                \App\Models\QrCode::where('esdeveniment_id', $esdeveniment->id)
                    ->where('usuari_correu', $userQr->usuari_correu)
                    ->orderBy('created_at', 'desc')
                    ->limit($excessCount)
                    ->delete();
            }
        }

        return redirect()->route('esdeveniment.index')
            ->with('success', 'Esdeveniment actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Esdeveniment $esdeveniment)
    {
        $esdeveniment->delete();

        return redirect()->route('esdeveniment.index')
            ->with('success', 'Esdeveniment eliminat correctament!');
    }

    /**
     * Display user-friendly events list for non-admin users
     */
    public function userList()
    {
        $events = Esdeveniment::with('assistents')
            ->where('Data_Esdeveniment', '>=', now()->startOfDay())
            ->orderBy('Data_Esdeveniment', 'asc')
            ->get();

        return view('events.user-list', compact('events'));
    }

    /**
     * Show event registration form for user
     */
    public function userRegisterForm(Esdeveniment $event)
    {
        // If the event date has already passed, do not allow access
        if (now()->startOfDay()->gt($event->Data_Esdeveniment)) {
            return redirect()->route('events.user-list')
                ->with('error', 'Aquest event ja ha passat.');
        }

        // Check if deadline has passed
        $isDeadlinePassed = $event->Data_Limit_Confirmacio
            ? now()->isAfter($event->Data_Limit_Confirmacio)
            : false;

        // Check if user is already registered
        $userRegistration = $event->assistents()
            ->where('usuari_correu', auth()->user()->Correu)
            ->first();

        if ($userRegistration) {
            return redirect()->route('events.user-list')
                ->with('error', 'Ja estàs registrat en aquest event.');
        }

        return view('events.register', compact('event', 'isDeadlinePassed'));
    }

    /**
     * Store user registration for event
     */
    public function storeUserRegistration(Request $request, Esdeveniment $event)
    {
        // Do not allow registrations for events that have already taken place
        if (now()->startOfDay()->gt($event->Data_Esdeveniment)) {
            return redirect()->route('events.user-list')
                ->with('error', 'Aquest event ja ha passat.');
        }

        // Validate request
        $validated = $request->validate([
            'num_acompanyants' => 'required|integer|min:0|max:' . $event->capacitat_max_acompanyants,
            'notes' => 'nullable|string|max:500',
        ], [
            'num_acompanyants.required' => 'El número d\'acompanyants és obligatori.',
            'num_acompanyants.integer' => 'El número d\'acompanyants ha de ser un número.',
            'num_acompanyants.min' => 'No pots tenir un número negatiu d\'acompanyants.',
            'num_acompanyants.max' => 'No pots tenir més de ' . $event->capacitat_max_acompanyants . ' acompanyants.',
            'notes.max' => 'Les observacions no poden superar 500 caràcters.',
        ]);

        // Check if deadline has passed
        if ($event->Data_Limit_Confirmacio && now()->isAfter($event->Data_Limit_Confirmacio)) {
            return redirect()->route('events.user-list')
                ->with('error', 'El termini de registre per a aquest event ha tancat.');
        }

        // Check if user is already registered
        $existingRegistration = $event->assistents()
            ->where('usuari_correu', auth()->user()->Correu)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('events.user-list')
                ->with('error', 'Ja estàs registrat en aquest event.');
        }

        // Check event capacity if validation is enabled
        if ($event->validar_capacitat) {
            $totalCompanions = $event->assistents()->sum('num_acompanyants_confirmats');
            if (($totalCompanions + $validated['num_acompanyants']) > $event->capacitat_max_acompanyants) {
                return redirect()->route('events.user-register', $event->id)
                    ->with('error', 'No hi ha prou capacitat per al número d\'acompanyants sol·licitats.');
            }
        }

        // Create the registration
        \App\Models\EsdevenimentAssistent::create([
            'esdeveniment_id' => $event->id,
            'usuari_correu' => auth()->user()->Correu,
            'num_acompanyants_permesos' => $event->capacitat_max_acompanyants,
            'num_acompanyants_confirmats' => $validated['num_acompanyants'],
            'confirmat' => true,
            'data_confirmacio' => now(),
        ]);

        return redirect()->route('events.user-list')
            ->with('success', 'T\'has registrat correctament en el event "' . $event->Nom . '"');
    }
}
