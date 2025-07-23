<?php

namespace App\Http\Controllers;

use App\Models\Cronograma;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Proyecto;
use App\Models\User;  // Modelo User para usuarios
use Illuminate\Http\Request;

class CronogramaController extends Controller
{
    public function index()
    {
        $cronogramas = Cronograma::with(['plan', 'programa', 'proyecto'])->get();
        return view('cronogramas.index', compact('cronogramas'));
    }

    public function create()
    {
        $planes = Plan::all();
        $programas = Programa::all();
        $proyectos = Proyecto::all();
        $usuarios = User::all(); // Obtener todos los usuarios para el select

        return view('cronogramas.create', compact('planes', 'programas', 'proyectos', 'usuarios'));
    }

    public function store(Request $request)
    {
        // Validación de datos, responsable debe ser un id válido de la tabla usuarios
        $validated = $request->validate([
            'actividad' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'responsable' => 'required|exists:usuarios,IdUsuario',  // Cambié 'id' por 'IdUsuario'
            'plan_id' => 'nullable|exists:planes,id',
            'programa_id' => 'nullable|exists:programas,id',
            'proyecto_id' => 'nullable|exists:proyectos,id',
            'estado' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string|max:500',
        ]);

        Cronograma::create($validated);

        return redirect()->route('cronogramas.index')->with('success', 'Cronograma creado correctamente.');
    }

    public function edit($id)
    {
        $cronograma = Cronograma::findOrFail($id);
        $planes = Plan::all();
        $programas = Programa::all();
        $proyectos = Proyecto::all();
        $usuarios = User::all(); // Para select en edición

        return view('cronogramas.edit', compact('cronograma', 'planes', 'programas', 'proyectos', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        // Validación para actualización, misma lógica que store
        $validated = $request->validate([
            'actividad' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'responsable' => 'required|exists:usuarios,IdUsuario',  // Cambié 'id' por 'IdUsuario'
            'plan_id' => 'nullable|exists:planes,id',
            'programa_id' => 'nullable|exists:programas,id',
            'proyecto_id' => 'nullable|exists:proyectos,id',
            'estado' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $cronograma = Cronograma::findOrFail($id);
        $cronograma->update($validated);

        return redirect()->route('cronogramas.index')->with('success', 'Cronograma actualizado correctamente.');
    }

    public function destroy($id)
    {
        Cronograma::destroy($id);
        return redirect()->route('cronogramas.index')->with('success', 'Cronograma eliminado correctamente.');
    }
}
