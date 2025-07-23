<?php

namespace App\Http\Controllers;

use App\Models\Vinculacion;
use App\Models\ObjetivoInstitucional;
use App\Models\Indicador;
use App\Models\Meta;
use Illuminate\Http\Request;

class VinculacionController extends Controller
{
    public function index()
    {
        $vinculaciones = Vinculacion::with(['objetivoInstitucional', 'indicador', 'meta'])->get();
        return view('vinculaciones.index', compact('vinculaciones'));
    }

    public function create()
    {
        $objetivos = ObjetivoInstitucional::all();
        $indicadores = Indicador::all();
        $metas = Meta::all();
        return view('vinculaciones.create', compact('objetivos', 'indicadores', 'metas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'nullable|string|max:255',
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'objetivo_institucional_id' => 'nullable|exists:objetivos_institucionales,id',
            'indicador_id' => 'nullable|exists:indicadores,id',
            'meta_id' => 'nullable|exists:metas,id',
        ]);

        Vinculacion::create($validated);

        return redirect()->route('vinculaciones.index')->with('success', 'Vinculación creada correctamente.');
    }

    public function edit(Vinculacion $vinculacion)
    {
        $objetivos = ObjetivoInstitucional::all();
        $indicadores = Indicador::all();
        $metas = Meta::all();
        return view('vinculaciones.edit', compact('vinculacion', 'objetivos', 'indicadores', 'metas'));
    }

    public function update(Request $request, Vinculacion $vinculacion)
    {
        $validated = $request->validate([
            'tipo' => 'nullable|string|max:255',
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'objetivo_institucional_id' => 'nullable|exists:objetivos_institucionales,id',
            'indicador_id' => 'nullable|exists:indicadores,id',
            'meta_id' => 'nullable|exists:metas,id',
        ]);

        $vinculacion->update($validated);

        return redirect()->route('vinculaciones.index')->with('success', 'Vinculación actualizada correctamente.');
    }

    public function destroy(Vinculacion $vinculacion)
    {
        $vinculacion->delete();

        return redirect()->route('vinculaciones.index')->with('success', 'Vinculación eliminada correctamente.');
    }
}
