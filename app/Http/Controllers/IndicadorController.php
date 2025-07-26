<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use App\Models\Vinculacion;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    public function index()
    {
        // Cargar indicadores con vinculacion y metas, sin usuarioResponsable
        $indicadores = Indicador::with(['vinculacion', 'metas'])->paginate(10);
        return view('indicadores.index', compact('indicadores'));
    }

    public function create()
    {
        $vinculaciones = Vinculacion::all();
        // No se cargan usuarios ya que eliminamos ese campo
        return view('indicadores.create', compact('vinculaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alineacion' => 'required|exists:vinculaciones,id',
            //'id_usuario_responsable' => 'required|exists:usuarios,IdUsuario', // eliminado
            'codigo' => 'required|string|max:50|unique:indicadores,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'nullable|string|max:50',
            'estado' => 'required|in:activo,inactivo',
            'fecha_registro' => 'required|date',
        ]);

        Indicador::create($request->only([
            'id_alineacion',
            //'id_usuario_responsable', // eliminado
            'codigo',
            'nombre',
            'descripcion',
            'unidad_medida',
            'estado',
            'fecha_registro',
        ]));

        return redirect()->route('indicadores.index')->with('success', 'Indicador creado correctamente.');
    }

    public function show(Indicador $indicador)
    {
        // Cargar relaciones necesarias sin usuarioResponsable
        $indicador->load('vinculacion', 'metas');
        return view('indicadores.show', compact('indicador'));
    }

    public function edit(Indicador $indicador)
    {
        $vinculaciones = Vinculacion::all();
        // No se cargan usuarios para editar
        return view('indicadores.edit', compact('indicador', 'vinculaciones'));
    }

    public function update(Request $request, Indicador $indicador)
    {
        $request->validate([
            'id_alineacion' => 'required|exists:vinculaciones,id',
            //'id_usuario_responsable' => 'required|exists:usuarios,IdUsuario', // eliminado
            'codigo' => 'required|string|max:50|unique:indicadores,codigo,' . $indicador->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'nullable|string|max:50',
            'estado' => 'required|in:activo,inactivo',
            'fecha_registro' => 'required|date',
        ]);

        $indicador->update($request->only([
            'id_alineacion',
            //'id_usuario_responsable', // eliminado
            'codigo',
            'nombre',
            'descripcion',
            'unidad_medida',
            'estado',
            'fecha_registro',
        ]));

        return redirect()->route('indicadores.index')->with('success', 'Indicador actualizado correctamente.');
    }

    public function destroy(Indicador $indicador)
    {
        $indicador->delete();
        return redirect()->route('indicadores.index')->with('success', 'Indicador eliminado correctamente.');
    }
}
