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
        // Carga relaciones para evitar consultas N+1
        $vinculaciones = Vinculacion::with(['objetivoInstitucional', 'indicador', 'meta'])->get();
        return view('vinculaciones.index', compact('vinculaciones'));
    }

    public function create()
    {
        $objetivos = ObjetivoInstitucional::where('estado', 'activo')->get();

        $indicadores = collect();
        $metas = collect();

        if ($objetivos->isNotEmpty()) {
            $indicadores = Indicador::where('estado', 'activo')
                ->whereIn('objetivo_institucional_id', $objetivos->pluck('id'))
                ->get();

            if ($indicadores->isNotEmpty()) {
                $metas = Meta::where('estado', 'activo')
                    ->whereIn('id_indicador', $indicadores->pluck('id'))
                    ->get();
            }
        }

        return view('vinculaciones.create', compact('objetivos', 'indicadores', 'metas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
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
        $objetivos = ObjetivoInstitucional::where('estado', 'activo')->get();

        $indicadores = collect();
        $metas = collect();

        if ($objetivos->isNotEmpty()) {
            $indicadores = Indicador::where('estado', 'activo')
                ->whereIn('objetivo_institucional_id', $objetivos->pluck('id'))
                ->get();

            if ($indicadores->isNotEmpty()) {
                $metas = Meta::where('estado', 'activo')
                    ->whereIn('id_indicador', $indicadores->pluck('id'))
                    ->get();
            }
        }

        return view('vinculaciones.edit', compact('vinculacion', 'objetivos', 'indicadores', 'metas'));
    }

    public function update(Request $request, Vinculacion $vinculacion)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
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
