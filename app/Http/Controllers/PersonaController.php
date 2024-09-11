<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;

class PersonaController extends Controller
{
    //
    public function index(Request $request)
    {
        // Obtener los parámetros de búsqueda y ordenamiento del request
        $search = $request->input('search');
        $sort = $request->input('sort', 'estado'); // Ordena por 'estado' si no se especifica otro criterio

        // Construir la consulta de personas
        $personas = Persona::query();

        // Si se ha ingresado un término de búsqueda, agregar las condiciones de búsqueda
        if ($search) {
            $personas->where('nombre', 'like', "%$search%")
                    ->orWhere('apellido', 'like', "%$search%")
                    ->orWhere('numero_carnet', 'like', "%$search%");
        }

        // Aplicar el criterio de ordenamiento
        $personas->orderBy($sort, 'desc');

        // Obtener los resultados de la consulta
        $personas = $personas->get();

        // Retornar la vista con los resultados
        return view('personas.index', compact('personas'));
    }


    public function create()
    {
        return view('personas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:80',
            'apellido' => 'required|max:80',
            'telefono' => 'required|integer',
            'numero_carnet' => 'required|max:20|unique:personas',
            'estado' => 'required|boolean',
        ]);

        Persona::create($request->all());

        return redirect()->route('personas.index')
                         ->with('success', 'Persona creada con éxito.');
    }
    // hasta aqui funciona el crear.

    //iniciamos editar
    public function edit(Persona $persona)
{
    return view('personas.edit', compact('persona'));
}
    //

    //iniciamos actualizar 
    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'nombre' => 'required|max:80',
            'apellido' => 'required|max:80',
            'telefono' => 'required|integer',
            'numero_carnet' => 'required|max:20',
            'estado' => 'required|boolean',
        ]);

        $persona->update($request->all());

        return redirect()->route('personas.index')
                        ->with('success', 'Persona actualizada con éxito.');
    }

    public function inactivate(Persona $persona)
    {
        $persona->estado = 0; // Cambiar el estado a inactivo
        $persona->save();

        return redirect()->route('personas.index')
                        ->with('success', 'Persona marcada como inactiva.');
    }

    public function activate(Persona $persona)
    {
        $persona->estado = 1; // Cambiar el estado a activo
        $persona->save();

        return redirect()->route('personas.index')
                        ->with('success', 'Persona rehabilitada.');
    }
    public function destroy(Persona $persona)
    {
        // Opción 1: Marcar como inactivo (actual)
        $persona->estado = 0; 
        $persona->save();

        // Opción 2: Eliminar físicamente
        $persona->delete();

        return redirect()->route('personas.index')
                        ->with('success', 'Persona actualizada o eliminada con éxito.');
    }

    //termina aqui
}
