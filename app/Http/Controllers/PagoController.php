<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Consumo;

class PagoController extends Controller
{
    //
    // Mostrar la lista de pagos
    public function index()
    {
        $pagos = Pago::with('consumo')->get();
        return view('pagos.index', compact('pagos'));
    }

    // Mostrar el formulario de creación de pago
    public function create()
    {
        $consumos = Consumo::all(); // O filtra los consumos según sea necesario
        return view('pagos.create', compact('consumos'));
    }

    // Almacenar un nuevo pago
    public function store(Request $request)
    {
        $request->validate([
            'consumo_id' => 'required|exists:consumos,id',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'estado' => 'required|string'
        ]);

        $pago = new Pago($request->all());
        $pago->save();

        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    // Mostrar el formulario de edición de pago
    public function edit($id)
    {
        $pago = Pago::findOrFail($id);
        $consumos = Consumo::all(); // O filtra los consumos según sea necesario
        return view('pagos.edit', compact('pago', 'consumos'));
    }

    // Actualizar un pago existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'consumo_id' => 'required|exists:consumos,id',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'estado' => 'required|string'
        ]);

        $pago = Pago::findOrFail($id);
        $pago->update($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    // Eliminar un pago
    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }
}
