<?php

namespace App\Http\Controllers;

use App\Models\Curs;
use Illuminate\Http\Request;

class CursController extends Controller
{
    /**
     * Mostrar lista de cursos
     */
    public function index()
    {
        $cursos = Curs::orderBy('orden')->get();
        return view('admin.cursos.index', compact('cursos'));
    }

    /**
     * Mostrar formulario para crear curso
     */
    public function create()
    {
        return view('admin.cursos.create');
    }

    /**
     * Guardar nuevo curso
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nivel' => 'nullable|string|max:255',
            'orden' => 'required|integer|min:0',
            'activo' => 'boolean',
        ]);

        Curs::create($validated);

        return redirect()->route('cursos.index')
            ->with('success', 'Curs creat correctament');
    }

    /**
     * Mostrar formulario para editar curso
     */
    public function edit(Curs $curs)
    {
        return view('admin.cursos.edit', compact('curs'));
    }

    /**
     * Actualizar curso
     */
    public function update(Request $request, Curs $curs)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nivel' => 'nullable|string|max:255',
            'orden' => 'required|integer|min:0',
            'activo' => 'boolean',
        ]);

        $curs->update($validated);

        return redirect()->route('cursos.index')
            ->with('success', 'Curs actualitzat correctament');
    }

    /**
     * Eliminar curso
     */
    public function destroy(Curs $curs)
    {
        // Verificar que no hay usuarios asignados
        if ($curs->usuaris()->count() > 0) {
            return redirect()->route('cursos.index')
                ->with('error', 'No es pot eliminar el curs perquè té usuaris assignats');
        }

        $curs->delete();

        return redirect()->route('cursos.index')
            ->with('success', 'Curs eliminat correctament');
    }

    /**
     * Toggle estado activo/inactivo
     */
    public function toggleActivo(Curs $curs)
    {
        $curs->update(['activo' => !$curs->activo]);

        return redirect()->route('cursos.index')
            ->with('success', 'Estat del curs actualitzat');
    }
}
