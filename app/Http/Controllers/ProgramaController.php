<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use App\Models\Plan; // Importa el modelo Plan
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    public function index()
    {
        // Ordena programas por fecha de creación ascendente (los más antiguos primero)
        $programas = Programa::orderBy('created_at', 'asc')->paginate(10);
        return view('programas.index', compact('programas'));
    }

    public function create()
    {
        // Obtiene todos los planes ordenados por nombre para enviarlos a la vista
        $planes = Plan::orderBy('nombre', 'asc')->get();
        return view('programas.create', compact('planes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:programas,codigo|max:50',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'plan_id' => 'required|exists:planes,id',  // Validar que plan_id exista en planes
        ]);

        Programa::create($request->all());

        return redirect()->route('programas.index')->with('success', 'Programa creado correctamente.');
    }

    public function show(Programa $programa)
    {
        return view('programas.show', compact('programa'));
    }

    public function edit(Programa $programa)
    {
        // Carga planes para mostrar en edición
        $planes = Plan::orderBy('nombre', 'asc')->get();
        return view('programas.edit', compact('programa', 'planes'));
    }

    public function update(Request $request, Programa $programa)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:programas,codigo,' . $programa->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'plan_id' => 'required|exists:planes,id',
        ]);

        $programa->update($request->all());

        return redirect()->route('programas.index')->with('success', 'Programa actualizado correctamente.');
    }

    public function destroy(Programa $programa)
    {
        $programa->delete();
        return redirect()->route('programas.index')->with('success', 'Programa eliminado correctamente.');
    }
}
