<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use App\Models\Vinculacion;  // Aquí usas Vinculacion porque en tu modelo el campo es id_alineacion que apunta a vinculaciones
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function index()
    {
        // Carga la relación vinculacion (alineacion) y metas
        $indicadores = Indicador::with(['vinculacion', 'metas'])->paginate(10);
        return view('indicadores.index', compact('indicadores'));
    }

    public function create()
    {
        // Obtiene todas las vinculaciones para el select
        $vinculaciones = Vinculacion::all();
        return view('indicadores.create', compact('vinculaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alineacion' => 'required|exists:vinculaciones,id',
            'codigo' => 'required|string|max:50|unique:indicadores,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'nullable|string|max:50',
            'estado' => 'required|in:activo,inactivo',
            'fecha_registro' => 'required|date',
        ]);

        Indicador::create($request->all());

        return redirect()->route('indicadores.index')->with('success', 'Indicador creado correctamente.');
    }

    public function show(Indicador $indicador)
    {
        $indicador->load('vinculacion', 'metas');
        return view('indicadores.show', compact('indicador'));
    }

    public function edit(Indicador $indicador)
    {
        $vinculaciones = Vinculacion::all();
        return view('indicadores.edit', compact('indicador', 'vinculaciones'));
    }

    public function update(Request $request, Indicador $indicador)
    {
        $request->validate([
            'id_alineacion' => 'required|exists:vinculaciones,id',
            'codigo' => 'required|string|max:50|unique:indicadores,codigo,' . $indicador->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'nullable|string|max:50',
            'estado' => 'required|in:activo,inactivo',
            'fecha_registro' => 'required|date',
        ]);

        $indicador->update($request->all());

        return redirect()->route('indicadores.index')->with('success', 'Indicador actualizado correctamente.');
    }

    public function destroy(Indicador $indicador)
    {
        $indicador->delete();
        return redirect()->route('indicadores.index')->with('success', 'Indicador eliminado correctamente.');
    }
}
