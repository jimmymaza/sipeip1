<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;

class InstitucionController extends Controller
{
    // Listar instituciones paginadas
    public function index()
    {
        $instituciones = Institucion::orderBy('IdInstitucion', 'asc')->paginate(10);
        return view('instituciones.index', compact('instituciones'));
    }

    // Mostrar formulario para crear institución
    public function create()
    {
        return view('instituciones.create');
    }

    // Guardar nueva institución
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|unique:instituciones,Nombre',
            'Codigo' => 'required|unique:instituciones,Codigo',
            'Subsector' => 'required',
            'NivelGobierno' => 'required|in:Nacional,Provincial,Cantonal',
            'Estado' => 'required|in:Activo,Inactivo',
        ]);

        Institucion::create($request->all());

        return redirect()->route('instituciones.index')->with('success', 'Institución creada correctamente');
    }

    // Mostrar formulario para editar institución
    public function edit($id)
    {
        $institucion = Institucion::findOrFail($id);
        return view('instituciones.edit', compact('institucion'));
    }

    // Actualizar institución existente
    public function update(Request $request, $id)
    {
        $institucion = Institucion::findOrFail($id);

        $request->validate([
            'Nombre' => 'required|unique:instituciones,Nombre,' . $institucion->IdInstitucion . ',IdInstitucion',
            'Codigo' => 'required|unique:instituciones,Codigo,' . $institucion->IdInstitucion . ',IdInstitucion',
            'Subsector' => 'required',
            'NivelGobierno' => 'required|in:Nacional,Provincial,Cantonal',
            'Estado' => 'required|in:Activo,Inactivo',
        ]);

        $institucion->update($request->all());

        return redirect()->route('instituciones.index')->with('success', 'Institución actualizada correctamente');
    }

    // Eliminar institución
    public function destroy($id)
    {
        $institucion = Institucion::findOrFail($id);
        $institucion->delete();

        return redirect()->route('instituciones.index')->with('success', 'Institución eliminada correctamente');
    }
}
