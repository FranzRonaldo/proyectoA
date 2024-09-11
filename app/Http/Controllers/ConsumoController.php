<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Consumo;
use App\Models\Asistencia;
use App\Models\Actividad;
use Carbon\Carbon;

class ConsumoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sociosConConsumos = Socio::whereHas('consumos')
            ->with('persona')
            ->when($search, function($query, $search) {
                $query->whereHas('persona', function($query) use ($search) {
                    $query->where('apellido', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('consumos.index', compact('sociosConConsumos'));
    }

    public function create()
    {
        $socios = Socio::with(['persona', 'consumos' => function($query) {
            $query->orderBy('anio', 'desc')->orderBy('mes', 'desc');
        }])->get();

        // Preparar los datos con el siguiente mes y año y la lectura anterior
        $sociosData = [];
        foreach ($socios as $socio) {
            // Obtener el último consumo registrado si existe
            $ultimoConsumo = $socio->consumos->first();

            if ($ultimoConsumo) {
                // Calcular el próximo mes y año basado en el último consumo
                $nextMonth = $ultimoConsumo->mes == 12 ? 1 : $ultimoConsumo->mes + 1;
                $nextYear = $ultimoConsumo->mes == 12 ? $ultimoConsumo->anio + 1 : $ultimoConsumo->anio;
            } else {
                // Si no hay consumos previos, comenzar con el mes y año actuales
                $nextMonth = now()->month;
                $nextYear = now()->year;
            }

            // Agregar los datos a la estructura
            $sociosData[] = [
                'socio' => $socio,
                'mes' => $nextMonth,
                'anio' => $nextYear,
                'lectura_anterior' => $ultimoConsumo ? $ultimoConsumo->lectura_actual : null
            ];
        }

        return view('consumos.create', ['sociosData' => $sociosData]);
    }

    private function getNextMonthYear()
    {
        $nextMonthYear = [];
        $socios = Socio::with('consumos')->get();

        foreach ($socios as $socio) {
            $lastConsumo = $socio->consumos->last();
            if ($lastConsumo) {
                $month = $lastConsumo->mes;
                $year = $lastConsumo->anio;

                $month++;
                if ($month > 12) {
                    $month = 1;
                    $year++;
                }

                $nextMonthYear[$socio->id] = [
                    'mes' => $month,
                    'anio' => $year,
                    'lectura_anterior' => $lastConsumo->lectura_actual,
                ];
            } else {
                $nextMonthYear[$socio->id] = [
                    'mes' => date('n'),
                    'anio' => date('Y'),
                    'lectura_anterior' => ''
                ];
            }
        }

        return $nextMonthYear;
    }
   
    /*public function store(Request $request)
    {
        $validatedData = $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:' . date('Y'),
            'lectura_actual' => 'required|numeric|min:0',
        ]);

        $socio = Socio::findOrFail($request->socio_id);
        $ultimoConsumo = $socio->consumos()->latest()->first();
        $lectura_anterior = $ultimoConsumo ? $ultimoConsumo->lectura_actual : $request->lectura_anterior;

        $consumo = new Consumo($validatedData);
        $consumo->lectura_anterior = $lectura_anterior;
        $consumo->consumo = $consumo->lectura_actual - $lectura_anterior;

        $this->calcularMonto($consumo);
        $consumo->save();

        return redirect()->route('consumos.index')->with('success', 'Consumo registrado correctamente.');
    }*/

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:' . date('Y'),
            'lectura_actual' => 'required|numeric|min:0',
        ]);

        $socio = Socio::findOrFail($request->socio_id);
        $ultimoConsumo = $socio->consumos()->latest()->first();
        $lectura_anterior = $ultimoConsumo ? $ultimoConsumo->lectura_actual : $request->lectura_anterior;

        $consumo = new Consumo($validatedData);
        $consumo->lectura_anterior = $lectura_anterior;
        $consumo->consumo = $consumo->lectura_actual - $lectura_anterior;

        // Calcular monto incluyendo la multa por inasistencia
        $this->calcularMonto($consumo);
        $consumo->save();

        return redirect()->route('consumos.index')->with('success', 'Consumo registrado correctamente.');
    }

    /*public function calcularMonto(Consumo $consumo)
    {
        $lecturaAnterior = $consumo->lectura_anterior;
        $lecturaActual = $consumo->lectura_actual;
        $consumo->consumo = $lecturaActual - $lecturaAnterior;

        if ($consumo->consumo <= 10) {
            $consumo->monto_cobrar = $consumo->consumo * 1;
        } else {
            $consumo->monto_cobrar = (10 * 1) + (($consumo->consumo - 10) * 2);
        }

        // Verificar si el socio tiene multa por inasistencia a alguna actividad en el mes y año actuales
        $asistencias = Asistencia::where('socio_id', $consumo->socio_id)
            ->whereHas('actividad', function($query) use ($consumo) {
                $query->whereMonth('fecha', $consumo->mes)
                      ->whereYear('fecha', $consumo->anio);
            })
            ->get();

        foreach ($asistencias as $asistencia) {
            if (!$asistencia->asistio) {
                $consumo->monto_cobrar += $asistencia->actividad->multa;
            }
        }

        $consumo->save();
    }*/

    public function calcularMonto(Consumo $consumo)
    {
        // Cálculo del consumo
        $lecturaAnterior = $consumo->lectura_anterior;
        $lecturaActual = $consumo->lectura_actual;
        $consumo->consumo = $lecturaActual - $lecturaAnterior;

        if ($consumo->consumo <= 10) {
            $consumo->monto_cobrar = $consumo->consumo * 1; // Tarifa para los primeros 10 m3
        } else {
            $consumo->monto_cobrar = (10 * 1) + (($consumo->consumo - 10) * 2); // Tarifa para el exceso de 10 m3
        }

        // Verificar si el socio tiene multa por inasistencia a alguna actividad en el mes y año actuales
        $asistencias = Asistencia::where('socio_id', $consumo->socio_id)
            ->where('asistio', 0) // Solo asistencias donde el socio no asistió
            ->where('multa_aplicada', 0) // Asegurar que la multa no se ha aplicado aún
            ->whereHas('actividad', function($query) use ($consumo) {
                $query->whereMonth('fecha', $consumo->mes)
                      ->whereYear('fecha', $consumo->anio);
            })
            ->get();

        // Aplicar multa por cada actividad no asistida
        foreach ($asistencias as $asistencia) {
            $consumo->monto_cobrar += $asistencia->actividad->multa;

            // Marcar la multa como aplicada
            $asistencia->multa_aplicada = 1;
            $asistencia->save();
        }

        // Guardar el monto final del consumo
        $consumo->save();
    }

    /*public function marcarPago(Consumo $consumo, $estadoPago)
    {
        $consumo->estado_pago = $estadoPago;
        $consumo->save();
        return response()->json(['estado_pago' => $consumo->estado_pago]);
    }

    public function detallesPorSocio($socioId)
    {
        // Busca el socio con sus relaciones, si no lo encuentra lanza una excepción 404
        $socio = Socio::with('persona', 'consumos')->findOrFail($socioId);
    
        // Si llegas aquí, el socio existe, entonces recuperamos sus consumos
        $consumos = $socio->consumos;
    
        return view('consumos.detalle', compact('socio', 'consumos'));
    }
    */
    public function marcarPago(Consumo $consumo, $estadoPago)
    {
        $consumo->estado_pago = $estadoPago;
        $consumo->save();
        return response()->json(['estado_pago' => $consumo->estado_pago]);
    }

    public function detallesPorSocio($socioId)
    {
        // Busca el socio con sus relaciones, si no lo encuentra lanza una excepción 404
        $socio = Socio::with('persona', 'consumos')->findOrFail($socioId);
    
        // Si llegas aquí, el socio existe, entonces recuperamos sus consumos
        $consumos = $socio->consumos;
    
        return view('consumos.detalle', compact('socio', 'consumos'));
    }
}
