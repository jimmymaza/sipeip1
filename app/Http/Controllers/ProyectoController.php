<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::all();
        return view('proyecto.index', compact('proyectos'));
    }

    public function create()
    {
        return view('proyecto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombreProyecto'    => 'required|string|max:255',
            'Estado'            => 'required|string|max:50',
            'FechaCreacion'     => 'required|date',
            'FechaActualizacion'=> 'nullable|date|after_or_equal:FechaCreacion',
        ]);

        Proyecto::create($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Proyecto $proyecto)
    {
        return view('proyecto.show', compact('proyecto'));
    }

    public function edit(Proyecto $proyecto)
    {
        return view('proyecto.edit', compact('proyecto'));
    }

    public function update(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'NombreProyecto'    => 'required|string|max:255',
            'Estado'            => 'required|string|max:50',
            'FechaCreacion'     => 'required|date',
            'FechaActualizacion'=> 'nullable|date|after_or_equal:FechaCreacion',
        ]);

        $proyecto->update($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}
