<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\Indicador;
use App\Models\User;
use App\Models\Plan;
use App\Models\ObjetivoInstitucional; // Importar el modelo correcto
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function index()
    {
        $metas = Meta::with(['indicador', 'responsable', 'plan'])->paginate(10);
        return view('metas.index', compact('metas'));
    }

    public function create()
    {
        // Obtener los objetivos institucionales activos, puedes filtrar por tipo si quieres
        $objetivos = ObjetivoInstitucional::where('estado', 'activo')->get();

        $indicadores = Indicador::where('estado', 'activo')->get();
        $usuarios = User::all();
        $planes = Plan::where('estado', 'activo')->get();

        // Pasar la variable $objetivos a la vista para evitar error
        return view('metas.create', compact('objetivos', 'indicadores', 'usuarios', 'planes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'objetivo_id' => 'nullable|integer|exists:objetivos_institucionales,id',
            'plan_id' => 'required|exists:planes,id',
            'id_indicador' => 'required|exists:indicadores,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'valor_objetivo' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
            'usuario_responsable_id' => 'required|exists:usuarios,IdUsuario',
        ]);

        $validated['fecha_registro'] = now();

        Meta::create($validated);

        return redirect()->route('metas.index')->with('success', 'Meta creada correctamente.');
    }

    public function show(Meta $meta)
    {
        $meta->load(['indicador', 'responsable', 'plan']);
        return view('metas.show', compact('meta'));
    }

    public function edit(Meta $meta)
    {
        $objetivos = ObjetivoInstitucional::where('estado', 'activo')->get();
        $indicadores = Indicador::where('estado', 'activo')->get();
        $usuarios = User::all();
        $planes = Plan::where('estado', 'activo')->get();

        return view('metas.edit', compact('meta', 'objetivos', 'indicadores', 'usuarios', 'planes'));
    }

    public function update(Request $request, Meta $meta)
    {
        $validated = $request->validate([
            'objetivo_id' => 'nullable|integer|exists:objetivos_institucionales,id',
            'plan_id' => 'required|exists:planes,id',
            'id_indicador' => 'required|exists:indicadores,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'valor_objetivo' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
            'usuario_responsable_id' => 'required|exists:usuarios,IdUsuario',
        ]);

        $meta->update($validated);

        return redirect()->route('metas.index')->with('success', 'Meta actualizada correctamente.');
    }

    public function destroy(Meta $meta)
    {
        $meta->delete();
        return redirect()->route('metas.index')->with('success', 'Meta eliminada correctamente.');
    }
}
