<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Persona;

class SocioController extends Controller
{
    public function index()
    {
        $socios = Socio::orderBy('estado', 'desc')->get(); // Ordenar para que los activos aparezcan primero
        return view('socios.index', compact('socios'));
    }

    public function create()
    {
        $personas = Persona::all(); // Obtener personas para el dropdown
        return view('socios.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'red' => 'required|max:40',
            'codigo' => 'nullable|max:20|unique:socios',
            'ubicacion' => 'required|max:40',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|integer',
            'persona_id' => 'required|exists:personas,id',
        ]);

        // Crear el socio
        $socio = Socio::create($request->all());

        return redirect()->route('socios.index')
                         ->with('success', 'Socio creado con éxito.');
    }

    public function edit(Socio $socio)
    {
        $personas = Persona::all(); // Obtener personas para el dropdown
        return view('socios.edit', compact('socio', 'personas'));
    }

    public function update(Request $request, Socio $socio)
    {
        $request->validate([
            'red' => 'required|max:40',
            'codigo' => 'nullable|max:20|unique:socios,codigo,' . $socio->id,
            'ubicacion' => 'required|max:40',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|integer',
            'persona_id' => 'required|exists:personas,id',
        ]);

        // Actualizar el socio
        $socio->update($request->all());

        return redirect()->route('socios.index')
                         ->with('success', 'Socio actualizado con éxito.');
    }

    public function destroy(Socio $socio)
    {
        // Cambiar estado a inactivo en lugar de eliminar
        $socio->estado = 0; // Inactivo
        $socio->save();

        return redirect()->route('socios.index')
                         ->with('success', 'Socio marcado como inactivo.');
    }
}
