<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actividad;

class ActividadController extends Controller
{
    //

    /**
     * Muestra una lista de las actividades.
     */
    public function index()
    {
        $actividades = Actividad::all();
        return view('actividades.index', compact('actividades'));
    }

    /**
     * Muestra el formulario para crear una nueva actividad.
     */
    public function create()
    {
        return view('actividades.create');
    }

    /**
     * Almacena una nueva actividad en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_actividad' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'multa' => 'nullable|numeric', // Añadir validación para 'multa'
        ]);

        Actividad::create([
            'nombre_actividad' => $request->nombre_actividad,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'multa' => $request->multa ?? 0, // Valor por defecto si 'multa' no está presente
        ]);

        return redirect()->route('actividades.index')
                         ->with('success', 'Actividad creada con éxito.');
    }

    /**
     * Muestra el formulario para editar una actividad existente.
     */
    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('actividades.edit', compact('actividad'));
    }

    /**
     * Actualiza una actividad existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_actividad' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'multa' => 'nullable|numeric', // Añadir validación para 'multa'
        ]);

        $actividad = Actividad::findOrFail($id);
        $actividad->update([
            'nombre_actividad' => $request->nombre_actividad,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'multa' => $request->multa ?? 0, // Valor por defecto si 'multa' no está presente
        ]);

        return redirect()->route('actividades.index')
                         ->with('success', 'Actividad actualizada con éxito.');
    }

    /**
     * Elimina una actividad de la base de datos.
     */
    public function destroy($id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->delete();

        return redirect()->route('actividades.index')
                         ->with('success', 'Actividad eliminada con éxito.');
    }
}
