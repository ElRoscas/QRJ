<?php

namespace App\Http\Controllers;

use App\Models\Esdeveniment;
use App\Models\EsdevenimentAssistent;
use App\Models\User;
use Illuminate\Http\Request;

class EsdevenimentAssistentController extends Controller
{
    /**
     * Mostrar gestión de asistentes para un evento
     */
    public function index(Esdeveniment $esdeveniment)
    {
        $esdeveniment->load(['assistents.usuari.curs']);
        $users = User::with('curs')->orderBy('Nom')->get();

        return view('admin.esdeveniments.assistents', compact('esdeveniment', 'users'));
    }

    /**
     * Asignar asistentes al evento
     */
    public function store(Request $request, Esdeveniment $esdeveniment)
    {
        $validated = $request->validate([
            'usuaris' => 'required|array',
            'usuaris.*' => 'exists:usuari,Correu',
            'num_acompanyants' => 'nullable|array',
            'num_acompanyants.*' => 'integer|min:0|max:10',
        ]);

        $numAcompanyants = $request->input('num_acompanyants', []);

        foreach ($validated['usuaris'] as $correuUsuari) {
            $acompanyants = $numAcompanyants[$correuUsuari] ?? $esdeveniment->capacitat_max_acompanyants;

            EsdevenimentAssistent::updateOrCreate(
                [
                    'esdeveniment_id' => $esdeveniment->id,
                    'usuari_correu' => $correuUsuari,
                ],
                [
                    'num_acompanyants_permesos' => $acompanyants,
                ]
            );
        }

        return redirect()->route('esdeveniments.assistents.index', $esdeveniment)
            ->with('success', 'Assistents assignats correctament');
    }

    /**
     * Actualizar número de acompañantes permitidos
     */
    public function update(Request $request, Esdeveniment $esdeveniment, EsdevenimentAssistent $assistent)
    {
        $validated = $request->validate([
            'num_acompanyants_permesos' => 'required|integer|min:0|max:10',
        ]);

        $assistent->update($validated);

        return redirect()->route('esdeveniments.assistents.index', $esdeveniment)
            ->with('success', 'Acompanyants actualitzats');
    }

    /**
     * Eliminar asistente del evento
     */
    public function destroy(Esdeveniment $esdeveniment, EsdevenimentAssistent $assistent)
    {
        $assistent->delete();

        return redirect()->route('esdeveniments.assistents.index', $esdeveniment)
            ->with('success', 'Assistent eliminat');
    }

    /**
     * Asignación masiva con mismo número de acompañantes
     */
    public function assignMassive(Request $request, Esdeveniment $esdeveniment)
    {
        $validated = $request->validate([
            'usuaris' => 'required|array',
            'usuaris.*' => 'exists:usuari,Correu',
            'num_acompanyants_global' => 'required|integer|min:0|max:10',
        ]);

        foreach ($validated['usuaris'] as $correuUsuari) {
            EsdevenimentAssistent::updateOrCreate(
                [
                    'esdeveniment_id' => $esdeveniment->id,
                    'usuari_correu' => $correuUsuari,
                ],
                [
                    'num_acompanyants_permesos' => $validated['num_acompanyants_global'],
                ]
            );
        }

        return redirect()->route('esdeveniments.assistents.index', $esdeveniment)
            ->with('success', count($validated['usuaris']) . ' assistents assignats amb ' . $validated['num_acompanyants_global'] . ' acompanyants cadascun');
    }
}
