<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    public function index()
    {
        // Cambié get() por paginate(10) para paginación y que links() funcione en la vista
        $presupuestos = Presupuesto::with(['plan', 'programa', 'proyecto'])->paginate(10);
        return view('presupuestos.index', compact('presupuestos'));
    }

    public function create()
    {
        $planes = Plan::all();
        $programas = Programa::all();
        $proyectos = Proyecto::all();
        return view('presupuestos.create', compact('planes', 'programas', 'proyectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:planes,id',
            'programa_id' => 'required|exists:programas,id',
            'proyecto_id' => 'required|exists:proyectos,id',
            'monto' => 'required|numeric',
            'fuente_financiamiento' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'anio' => 'required|digits:4',
            'estado' => 'nullable|string|max:50',
        ]);

        // Evitar asignación masiva con $request->only()
        Presupuesto::create($request->only([
            'plan_id',
            'programa_id',
            'proyecto_id',
            'monto',
            'fuente_financiamiento',
            'descripcion',
            'anio',
            'estado',
        ]));

        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto creado correctamente.');
    }

    public function edit($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $planes = Plan::all();
        $programas = Programa::all();
        $proyectos = Proyecto::all();
        return view('presupuestos.edit', compact('presupuesto', 'planes', 'programas', 'proyectos'));
    }

    public function update(Request $request, $id)
    {
        $presupuesto = Presupuesto::findOrFail($id);

        $request->validate([
            'plan_id' => 'required|exists:planes,id',
            'programa_id' => 'required|exists:programas,id',
            'proyecto_id' => 'required|exists:proyectos,id',
            'monto' => 'required|numeric',
            'fuente_financiamiento' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'anio' => 'required|digits:4',
            'estado' => 'nullable|string|max:50',
        ]);

        $presupuesto->update($request->only([
            'plan_id',
            'programa_id',
            'proyecto_id',
            'monto',
            'fuente_financiamiento',
            'descripcion',
            'anio',
            'estado',
        ]));

        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto actualizado correctamente.');
    }

    public function destroy($id)
    {
        Presupuesto::destroy($id);
        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto eliminado correctamente.');
    }
}
