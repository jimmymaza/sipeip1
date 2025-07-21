<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\ObjetivoInstitucional;
use App\Models\Plan;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    // Mostrar listado paginado de metas
    public function index()
    {
        $metas = Meta::with(['objetivo', 'plan'])->paginate(10);
        return view('metas.index', compact('metas'));
    }

    // Mostrar formulario para crear nueva meta
    public function create()
    {
        $objetivos = ObjetivoInstitucional::where('estado', 'activo')->get();
        $planes = Plan::where('estado', 'activo')->get();
        return view('metas.create', compact('objetivos', 'planes'));
    }

    // Guardar nueva meta en BD
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:metas,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:activo,inactivo',
            'objetivo_id' => 'required|exists:objetivos_institucionales,id',
            'plan_id' => 'nullable|exists:planes,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        Meta::create($request->all());

        return redirect()->route('metas.index')->with('success', 'Meta creada correctamente.');
    }

    // Mostrar formulario para editar una meta
    public function edit(Meta $meta)
    {
        $objetivos = ObjetivoInstitucional::where('estado', 'activo')->get();
        $planes = Plan::where('estado', 'activo')->get();
        return view('metas.edit', compact('meta', 'objetivos', 'planes'));
    }

    // Actualizar meta en BD
    public function update(Request $request, Meta $meta)
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:metas,codigo,' . $meta->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:activo,inactivo',
            'objetivo_id' => 'required|exists:objetivos_institucionales,id',
            'plan_id' => 'nullable|exists:planes,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $meta->update($request->all());

        return redirect()->route('metas.index')->with('success', 'Meta actualizada correctamente.');
    }

    // Eliminar una meta
    public function destroy(Meta $meta)
    {
        $meta->delete();
        return redirect()->route('metas.index')->with('success', 'Meta eliminada correctamente.');
    }

    // Opcional: mostrar detalles de una meta
    public function show(Meta $meta)
    {
        $meta->load(['objetivo', 'plan']);
        return view('metas.show', compact('meta'));
    }
}
