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
        $events = Esdeveniment::with('user')
            ->orderBy('Data_Esdeveniment', 'desc')
            ->get();

        return view('esdeveniments', compact('events'));
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
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'confirmation_deadline' => 'required|date|before_or_equal:event_date',
        ], [
            'type.required' => 'El tipus d\'esdeveniment és obligatori.',
            'guests.required' => 'El número d\'invitats és obligatori.',
            'guests.integer' => 'El número d\'invitats ha de ser un número.',
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
        return view('esdeveniment.show', compact('esdeveniment'));
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
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'confirmation_deadline' => 'required|date|before_or_equal:event_date',
        ]);

        $esdeveniment->update([
            'Nom' => $validated['type'],
            'Tipus' => $validated['type'],
            'Nº_Invitats' => $validated['guests'],
            'Ubicacio' => $validated['location'],
            'Data_Esdeveniment' => $validated['event_date'],
            'Hora_Inici' => $validated['start_time'],
            'Data_Limit_Confirmacio' => $validated['confirmation_deadline'],
        ]);

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
}
