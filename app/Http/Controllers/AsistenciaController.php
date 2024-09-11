<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Socio;
use App\Models\Actividad;
use App\Models\Consumo;

class AsistenciaController extends Controller
{
    // Mostrar la lista de asistencias
    public function index()
    {
        $asistencias = Asistencia::with('socio', 'actividad')->get();
        $actividades = Actividad::all();
        $socios = Socio::all();
        return view('asistencias.index', compact('asistencias', 'actividades', 'socios'));
    }

    // Mostrar el formulario de creación de asistencia
    public function create()
    {
        $socios = Socio::where('estado', 1)->get(); // Solo socios activos
        $actividades = Actividad::all();
        return view('asistencias.create', compact('socios', 'actividades'));
    }

    // Almacenar una nueva asistencia (modificado para manejar múltiples socios)
    public function store(Request $request)
    {
        $request->validate([
            'actividad_id' => 'required|exists:actividades,id',
            'socio_ids' => 'required|array',
            'socio_ids.*' => 'exists:socios,id',
            'asistio' => 'required|boolean'
        ]);

        $actividad_id = $request->actividad_id;
        $asistio = $request->asistio;

        foreach ($request->socio_ids as $socioId) {
            Asistencia::updateOrCreate(
                ['socio_id' => $socioId, 'actividad_id' => $actividad_id],
                ['asistio' => $asistio]
            );
        }

        return redirect()->route('asistencias.index')->with('success', 'Socios añadidos a la actividad exitosamente.');
    }

    // Mostrar el formulario de edición de asistencia
    public function edit($id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $socios = Socio::all();
        $actividades = Actividad::all();
        return view('asistencias.edit', compact('asistencia', 'socios', 'actividades'));
    }

    // Actualizar una asistencia existente
/*
    public function update(Request $request, $id)
    {
        // Obtener la asistencia y actualizarla
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->update([
            'asistio' => $request->asistio,
        ]);

        // Verificar si la asistencia es para una actividad que tiene una multa
        if ($asistencia->actividad->multa) {
            // Obtener el consumo correspondiente al socio y al mes de la actividad
            $consumo = Consumo::where('socio_id', $asistencia->socio_id)
                                ->where('mes', $asistencia->actividad->mes)
                                ->where('anio', $asistencia->actividad->anio)
                                ->first();

            if ($consumo) {
                // Si el socio asistió, quitar la multa
                if ($request->asistio == 1) {
                    $consumo->monto_cobrar -= $asistencia->actividad->multa;
                }
                // Si el socio no asistió, agregar la multa
                else {
                    $consumo->monto_cobrar += $asistencia->actividad->multa;
                }
                // Guardar los cambios en el consumo
                $consumo->save();
            }
        }

        return redirect()->route('asistencias.index')
                        ->with('success', 'Asistencia actualizada correctamente');
    }
*/
    /*
    public function update(Request $request, $id)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'actividad_id' => 'required|exists:actividades,id',
            'asistio' => 'required|boolean',
        ]);

        $asistencia = Asistencia::findOrFail($id);
        $asistencia->update([
            'socio_id' => $request->input('socio_id'),
            'actividad_id' => $request->input('actividad_id'),
            'asistio' => $request->input('asistio'),
            'multa_aplicada' => $request->input('asistio') ? 0 : 1
        ]);

        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada exitosamente.');
    }*/
/*
    public function update(Request $request, $id)
{
    $asistencia = Asistencia::find($id);
    $asistencia->asistio = $request->input('asistio');
    $asistencia->save();

    // Verifica si la asistencia cambió a "asistió"
    if ($asistencia->asistio) {
        // Obtener el consumo relacionado
        $consumo = Consumo::where('socio_id', $asistencia->socio_id)
                          ->where('mes', $asistencia->actividad->mes)
                          ->where('anio', $asistencia->actividad->anio)
                          ->first();
                          
        if ($consumo) {
            // Restar la multa del monto a cobrar
            $consumo->monto_cobrar -= $asistencia->actividad->multa;
            $consumo->save();
        }
    }

    return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente');
}
*/
/*
public function update(Request $request, $id)
{
    $asistencia = Asistencia::find($id);
    $asistencia->asistio = $request->input('asistio');
    
    // Obtener la multa de la actividad
    $multa = $asistencia->actividad->multa;

    // Obtener el consumo relacionado
    $consumo = Consumo::where('socio_id', $asistencia->socio_id)
                      ->where('mes', $asistencia->actividad->mes)
                      ->where('anio', $asistencia->actividad->anio)
                      ->first();
    
    if ($consumo) {
        // Si cambió de "no asistió" a "asistió", eliminar la multa
        if ($asistencia->asistio && $asistencia->multa_aplicada) {
            $consumo->monto_cobrar -= $multa;
            $asistencia->multa_aplicada = false; // Marcar como no aplicada
        } 
        // Si cambió de "asistió" a "no asistió", agregar la multa
        elseif (!$asistencia->asistio && !$asistencia->multa_aplicada) {
            $consumo->monto_cobrar += $multa;
            $asistencia->multa_aplicada = true; // Marcar como aplicada
        }

        $consumo->save(); // Guardar el cambio en el consumo
    }

    $asistencia->save(); // Guardar el cambio en la asistencia
    
    return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente');
}
*/
// este me esta funcionando pero lo estoy cambiando a otro ----
/*
public function update(Request $request, $id)
{
    $asistencia = Asistencia::findOrFail($id);

    // Actualiza los campos de la asistencia
    $asistencia->socio_id = $request->input('socio_id');
    $asistencia->actividad_id = $request->input('actividad_id');
    $asistencia->asistio = $request->input('asistio');

    // Si no asistió, se aplica multa, si asistió, se quita la multa
    if ($request->input('asistio') == 0) {
        $asistencia->multa_aplicada = 1;
    } else {
        $asistencia->multa_aplicada = 0;
    }

    $asistencia->save();

    return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente');
}

*/

public function update(Request $request, $id)
{
    $asistencia = Asistencia::findOrFail($id);

    // Actualiza los campos de la asistencia
    $asistencia->socio_id = $request->input('socio_id');
    $asistencia->actividad_id = $request->input('actividad_id');
    $asistencia->asistio = $request->input('asistio');

    // Si no asistió, se aplica la multa, si asistió, se quita la multa
    if ($request->input('asistio') == 0) {
        $asistencia->multa_aplicada = 1;
    } else {
        $asistencia->multa_aplicada = 0;
    }

    // Guardar los cambios de asistencia
    $asistencia->save();

    // Aplicar la multa en el consumo correspondiente
    $this->aplicarMultaConsumo($asistencia);

    return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente y multa reflejada en consumos');
}

public function aplicarMultaConsumo($asistencia)
{
    // Obtener el consumo del socio para el mes y año de la actividad
    $consumo = Consumo::where('socio_id', $asistencia->socio_id)
                      ->where('mes', $asistencia->actividad->mes)
                      ->where('anio', $asistencia->actividad->anio)
                      ->first();

    if ($consumo) {
        // Obtener el monto de la multa de la actividad
        $multa = $asistencia->actividad->multa;

        if ($asistencia->multa_aplicada == 1) {
            // Si la multa está aplicada, sumar al monto de cobrar
            $consumo->monto_cobrar += $multa;
        } else {
            // Si la multa no está aplicada, restar del monto de cobrar
            $consumo->monto_cobrar -= $multa;
        }

        // Guardar los cambios en el consumo
        $consumo->save();
    }
}


/*
public function update(Request $request, $id)
{
    $asistencia = Asistencia::find($id);
    $asistencia->asistio = $request->input('asistio');
    
    // Obtener la multa de la actividad
    $multa = $asistencia->actividad->multa;

    // Obtener el consumo relacionado
    $consumo = Consumo::where('socio_id', $asistencia->socio_id)
                      ->where('mes', $asistencia->actividad->mes)
                      ->where('anio', $asistencia->actividad->anio)
                      ->first();
    
    if ($consumo) {
        // Verifica si asistió y la multa estaba aplicada previamente
        if ($asistencia->asistio && $asistencia->multa_aplicada) {
            $consumo->monto_cobrar -= $multa;
            $asistencia->multa_aplicada = false; // Cambiar el estado de la multa
        } 
        // Si cambió a "no asistió" y no se ha aplicado la multa aún
        elseif (!$asistencia->asistio && !$asistencia->multa_aplicada) {
            $consumo->monto_cobrar += $multa;
            $asistencia->multa_aplicada = true; // Aplicar la multa
        }

        $consumo->save(); // Guardar cambios en el consumo
    }

    $asistencia->save(); // Guardar cambios en la asistencia
    
    return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente');
}
*/
    // Registrar asistencia para una actividad específica
    public function registrarAsistencia(Request $request, $actividadId)
    {
        // Obtener los datos del formulario, como si el socio asistió o no
        $asistencias = $request->input('asistencias');

        foreach ($asistencias as $socioId => $asistio) {
            $asistencia = Asistencia::updateOrCreate(
                ['socio_id' => $socioId, 'actividad_id' => $actividadId],
                ['asistio' => $asistio, 'multa_aplicada' => $asistio == 0 ? 1 : 0]
            );
        }

        return redirect()->back()->with('success', 'Asistencias registradas correctamente.');
    }
    /*
    public function actualizarAsistencia(Request $request, $actividad_id)
    {
        $asistencia = Asistencia::where('socio_id', $request->socio_id)
                                ->where('actividad_id', $actividad_id)
                                ->firstOrFail();

        // Actualizar si asistió o no
        $asistencia->asistio = $request->asistio;
        $asistencia->save();

        // Buscar el consumo del socio para ese mes y año
        $consumo = Consumo::where('socio_id', $request->socio_id)
                        ->where('mes', Carbon::parse($asistencia->actividad->fecha)->month)
                        ->where('anio', Carbon::parse($asistencia->actividad->fecha)->year)
                        ->first();

        if ($consumo) {
            // Si no asistió, aplicar la multa
            if (!$request->asistio) {
                $consumo->monto_cobrar += $asistencia->actividad->multa;
            } else {
                // Si asistió, remover la multa
                $consumo->monto_cobrar -= $asistencia->actividad->multa;
            }
            $consumo->save();
        }
    }*/
/*
    public function actualizarAsistencia(Request $request, $id)
{
    // Actualizar la asistencia del socio
    $asistencia = Asistencia::find($id);
    $asistencia->asistio = $request->input('asistio');
    $asistencia->save();

    // Verificar si el socio no asistió, agregar la multa
    $consumo = Consumo::where('socio_id', $asistencia->socio_id)
        ->where('mes', $asistencia->actividad->mes)
        ->where('anio', $asistencia->actividad->anio)
        ->first();

    if ($asistencia->asistio) {
        // Si asistió, eliminar la multa del monto a cobrar
        $consumo->monto_cobrar -= $asistencia->actividad->multa;
    } else {
        // Si no asistió, agregar la multa
        $consumo->monto_cobrar += $asistencia->actividad->multa;
    }

    $consumo->save();

    return redirect()->back()->with('success', 'Asistencia actualizada correctamente');
}
*/
/*
public function actualizarAsistencia(Request $request, $id)
{
    // Encontrar la asistencia por ID
    $asistencia = Asistencia::findOrFail($id);

    // Actualizar el estado de la asistencia
    $asistencia->asistio = $request->input('asistio');
    $asistencia->save();

    // Obtener el consumo correspondiente al socio y al mes/año de la actividad
    $consumo = Consumo::where('socio_id', $asistencia->socio_id)
                      ->where('mes', Carbon::parse($asistencia->actividad->fecha)->month)
                      ->where('anio', Carbon::parse($asistencia->actividad->fecha)->year)
                      ->first();

    // Verifica si existe un consumo asociado
    if ($consumo) {
        // Si asistió, quitar la multa si ya fue aplicada
        if ($asistencia->asistio && $consumo->monto_cobrar >= $asistencia->actividad->multa) {
            $consumo->monto_cobrar -= $asistencia->actividad->multa;
        } 
        // Si no asistió, añadir la multa
        elseif (!$asistencia->asistio) {
            $consumo->monto_cobrar += $asistencia->actividad->multa;
        }
        // Guardar el cambio en el consumo
        $consumo->save();
    }

    return redirect()->back()->with('success', 'Asistencia actualizada correctamente y consumo ajustado.');
}
*/

public function actualizarAsistencia(Request $request, $id)
{
    // Validar la entrada
    $request->validate([
        'asistio' => 'required|boolean',
    ]);

    // Encontrar la asistencia por ID
    $asistencia = Asistencia::findOrFail($id);

    // Guardar el estado anterior
    $wasAttended = $asistencia->asistio;
    $wasMultaApplied = $asistencia->multa_aplicada;

    // Actualizar el estado de asistencia
    $asistencia->asistio = $request->input('asistio');
    $asistencia->save();

    // Extraer mes y año de la fecha de la actividad
    $actividadFecha = Carbon::parse($asistencia->actividad->fecha);
    $mes = $actividadFecha->month;
    $anio = $actividadFecha->year;

    // Obtener el consumo correspondiente
    $consumo = Consumo::where('socio_id', $asistencia->socio_id)
                      ->where('mes', $mes)
                      ->where('anio', $anio)
                      ->first();

    if ($consumo) {
        if (!$wasAttended && $asistencia->asistio) {
            // Caso: De "no asistió" a "asistió"
            if ($wasMultaApplied) {
                $consumo->monto_cobrar -= $asistencia->actividad->multa;
                $asistencia->multa_aplicada = false;
                $asistencia->save();
            }
        } elseif ($wasAttended && !$asistencia->asistio) {
            // Caso: De "asistió" a "no asistió"
            if (!$wasMultaApplied) {
                $consumo->monto_cobrar += $asistencia->actividad->multa;
                $asistencia->multa_aplicada = true;
                $asistencia->save();
            }
        }
        $consumo->save();
    } else {
        // Opcional: Manejar el caso donde no se encuentra un consumo correspondiente
        return redirect()->back()->with('error', 'No se encontró un consumo correspondiente para ajustar.');
    }

    return redirect()->back()->with('success', 'Asistencia actualizada correctamente y consumo ajustado.');
}

    // Eliminar una asistencia
    public function destroy($id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->delete();
        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada exitosamente.');
    }

}

