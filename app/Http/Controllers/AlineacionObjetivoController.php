<?php

namespace App\Http\Controllers;

use App\Models\AlineacionObjetivo;
use App\Models\ObjetivoInstitucional;
use Illuminate\Http\Request;

class AlineacionObjetivoController extends Controller
{
    // Mostrar todas las alineaciones de un objetivo con paginación
    public function index(string $tipo, ObjetivoInstitucional $objetivo)
    {
        // Cargar alineaciones con la relación objetivo alineado y paginar resultados
        $alineaciones = AlineacionObjetivo::where('objetivo_id', $objetivo->id)
            ->with('objetivoAlineado')
            ->paginate(10); // <- aquí paginate en vez de get()

        return view('alineaciones.index', compact('tipo', 'objetivo', 'alineaciones'));
    }

    // Formulario para crear alineación
    public function create(string $tipo, ObjetivoInstitucional $objetivo)
    {
        // Posibles objetivos para alinear (puedes ajustar el filtro según tu lógica)
        $objetivosPosibles = ObjetivoInstitucional::where('id', '!=', $objetivo->id)->get();

        return view('alineaciones.create', compact('tipo', 'objetivo', 'objetivosPosibles'));
    }

    // Guardar alineación
    public function store(Request $request, string $tipo, ObjetivoInstitucional $objetivo)
    {
        $request->validate([
            'objetivo_alineado_id' => 'required|exists:objetivos_institucionales,id',
            'tipo_alineacion' => 'required|string|max:50',
        ]);

        // Evitar duplicados
        $exists = AlineacionObjetivo::where('objetivo_id', $objetivo->id)
            ->where('objetivo_alineado_id', $request->objetivo_alineado_id)
            ->where('tipo_alineacion', $request->tipo_alineacion)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['objetivo_alineado_id' => 'Esta alineación ya existe para este tipo.'])->withInput();
        }

        AlineacionObjetivo::create([
            'objetivo_id' => $objetivo->id,
            'objetivo_alineado_id' => $request->objetivo_alineado_id,
            'tipo_alineacion' => $request->tipo_alineacion,
        ]);

        return redirect()->route('objetivos.alineaciones.index', ['tipo' => $tipo, 'objetivo' => $objetivo->id])
                         ->with('success', 'Alineación creada correctamente.');
    }

    // Métodos futuros: edit, update, destroy
}
