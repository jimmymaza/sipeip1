<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoInstitucional;
use Illuminate\Http\Request;

class ObjetivoInstitucionalController extends Controller
{
    public function index()
    {
        $objetivos = ObjetivoInstitucional::all();
        return view('objetivo_institucional.index', compact('objetivos'));
    }

    public function create()
    {
        return view('objetivo_institucional.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:1000',
        ]);

        ObjetivoInstitucional::create([
            'Descripcion' => $request->Descripcion,
            'IdPlan' => $request->IdPlan, // si aplica
        ]);

        return redirect()->route('objetivo-institucional.index')->with('success', 'Objetivo institucional creado correctamente.');
    }

    public function show(ObjetivoInstitucional $objetivo)
    {
        return view('objetivo_institucional.show', compact('objetivo'));
    }

    public function edit(ObjetivoInstitucional $objetivo)
    {
        return view('objetivo_institucional.edit', compact('objetivo'));
    }

    public function update(Request $request, ObjetivoInstitucional $objetivo)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:1000',
        ]);

        $objetivo->update([
            'Descripcion' => $request->Descripcion,
        ]);

        return redirect()->route('objetivo-institucional.index')->with('success', 'Objetivo institucional actualizado correctamente.');
    }

    public function destroy(ObjetivoInstitucional $objetivo)
    {
        $objetivo->delete();
        return redirect()->route('objetivo-institucional.index')->with('success', 'Objetivo institucional eliminado.');
    }
}
