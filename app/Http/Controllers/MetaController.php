<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\ObjetivoInstitucional;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function index()
    {
        $metas = Meta::with(['objetivo', 'proyecto'])->get();
        return view('meta.index', compact('metas'));
    }

    public function create()
    {
        $objetivos = ObjetivoInstitucional::all();
        $proyectos = Proyecto::all();
        return view('meta.create', compact('objetivos', 'proyectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Descripcion'   => 'required|string|max:1000',
            'FechaInicio'   => 'required|date',
            'FechaFin'      => 'required|date|after_or_equal:FechaInicio',
            'IdObjetivo'    => 'required|exists:objetivo_institucionals,IdObjetivo',
            'IdProyecto'    => 'required|exists:proyectos,IdProyecto',
        ]);

        Meta::create([
            'Descripcion'  => $request->Descripcion,
            'FechaInicio'  => $request->FechaInicio,
            'FechaFin'     => $request->FechaFin,
            'IdObjetivo'   => $request->IdObjetivo,
            'IdProyecto'   => $request->IdProyecto,
        ]);

        return redirect()->route('meta.index')->with('success', 'Meta creada correctamente.');
    }

    public function show(Meta $meta)
    {
        $meta->load(['objetivo', 'proyecto']);
        return view('meta.show', compact('meta'));
    }

    public function edit(Meta $meta)
    {
        $objetivos = ObjetivoInstitucional::all();
        $proyectos = Proyecto::all();
        return view('meta.edit', compact('meta', 'objetivos', 'proyectos'));
    }

    public function update(Request $request, Meta $meta)
    {
        $request->validate([
            'Descripcion'   => 'required|string|max:1000',
            'FechaInicio'   => 'required|date',
            'FechaFin'      => 'required|date|after_or_equal:FechaInicio',
            'IdObjetivo'    => 'required|exists:objetivo_institucionals,IdObjetivo',
            'IdProyecto'    => 'required|exists:proyectos,IdProyecto',
        ]);

        $meta->update([
            'Descripcion'  => $request->Descripcion,
            'FechaInicio'  => $request->FechaInicio,
            'FechaFin'     => $request->FechaFin,
            'IdObjetivo'   => $request->IdObjetivo,
            'IdProyecto'   => $request->IdProyecto,
        ]);

        return redirect()->route('meta.index')->with('success', 'Meta actualizada correctamente.');
    }

    public function destroy(Meta $meta)
    {
        $meta->delete();
        return redirect()->route('meta.index')->with('success', 'Meta eliminada correctamente.');
    }
}
