<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Muestra la lista paginada de planes con sus relaciones cargadas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener planes con la relación 'objetivos' paginados, sin 'metas'
        $planes = Plan::with('objetivos')->paginate(10);

        return view('planes.index', compact('planes'));
    }

    /**
     * Muestra el formulario para crear un nuevo plan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('planes.create');
    }

    /**
     * Valida y guarda un nuevo plan en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo'       => 'required|string|max:50|unique:planes,codigo',
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'estado'       => 'required|in:activo,inactivo',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        ]);

        try {
            Plan::create($validated);
            return redirect()->route('planes.index')->with('success', 'Plan creado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error al guardar el plan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Muestra el formulario para editar un plan existente.
     *
     * @param  Plan  $plan
     * @return \Illuminate\View\View
     */
    public function edit(Plan $plan)
    {
        return view('planes.edit', compact('plan'));
    }

    /**
     * Valida y actualiza un plan existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Plan  $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'codigo'       => 'required|string|max:50|unique:planes,codigo,' . $plan->id,
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'estado'       => 'required|in:activo,inactivo',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        ]);

        try {
            $plan->update($validated);
            return redirect()->route('planes.index')->with('success', 'Plan actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error al actualizar el plan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Elimina un plan de la base de datos.
     *
     * @param  Plan  $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Plan $plan)
    {
        try {
            $plan->delete();
            return redirect()->route('planes.index')->with('success', 'Plan eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error al eliminar el plan: ' . $e->getMessage()]);
        }
    }

    /**
     * Muestra los detalles de un plan con sus relaciones cargadas.
     *
     * @param  Plan  $plan
     * @return \Illuminate\View\View
     */
    public function show(Plan $plan)
    {
        // Cargar solo 'objetivos', sin 'metas'
        $plan->load('objetivos');

        return view('planes.show', compact('plan'));
    }
}
