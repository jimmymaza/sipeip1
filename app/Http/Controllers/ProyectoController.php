<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Plan;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    // Muestra la lista de proyectos con su plan asociado
    public function index()
    {
        // Trae todos los proyectos con su relación plan para evitar consultas N+1
        $proyectos = Proyecto::with('plan')->get();
        return view('proyectos.index', compact('proyectos'));
    }

    // Muestra formulario para crear un proyecto nuevo
    public function create()
    {
        $planes = Plan::all();
        return view('proyectos.create', compact('planes'));
    }

    // Almacena un proyecto nuevo en la base de datos
    public function store(Request $request)
    {
        // Validación de campos con mensajes personalizados
        $request->validate([
            'codigo' => 'required|string|max:20|unique:proyectos,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'estado' => 'required|in:activo,inactivo',
            'plan_id' => 'required|exists:planes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], [
            'codigo.required' => 'El código del proyecto es obligatorio.',
            'codigo.unique' => 'El código del proyecto ya existe.',
            'nombre.required' => 'El nombre del proyecto es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
            'plan_id.required' => 'Debe seleccionar un plan válido.',
            'plan_id.exists' => 'El plan seleccionado no es válido.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ]);

        // Crear el proyecto con los datos validados
        Proyecto::create($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado correctamente.');
    }

    // Muestra un proyecto específico con su plan
    public function show(Proyecto $proyecto)
    {
        $proyecto->load('plan');
        return view('proyectos.show', compact('proyecto'));
    }

    // Muestra formulario para editar proyecto existente
    public function edit(Proyecto $proyecto)
    {
        $planes = Plan::all();
        return view('proyectos.edit', compact('proyecto', 'planes'));
    }

    // Actualiza un proyecto existente
    public function update(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            // Permite mantener el mismo código del proyecto sin violar la regla unique
            'codigo' => 'required|string|max:20|unique:proyectos,codigo,' . $proyecto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'estado' => 'required|in:activo,inactivo',
            'plan_id' => 'required|exists:planes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], [
            'codigo.required' => 'El código del proyecto es obligatorio.',
            'codigo.unique' => 'El código del proyecto ya existe.',
            'nombre.required' => 'El nombre del proyecto es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
            'plan_id.required' => 'Debe seleccionar un plan válido.',
            'plan_id.exists' => 'El plan seleccionado no es válido.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ]);

        $proyecto->update($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    // Elimina un proyecto
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}
