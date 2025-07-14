<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoODS;
use Illuminate\Http\Request;

class ObjetivoODSController extends Controller
{
    public function index()
    {
        $objetivos = ObjetivoODS::all();
        return view('objetivo_ods.index', compact('objetivos'));
    }

    public function create()
    {
        return view('objetivo_ods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Numero' => 'required|integer|min:1|max:17',
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:1000',
        ]);

        ObjetivoODS::create($request->all());

        return redirect()->route('objetivo-ods.index')->with('success', 'Objetivo ODS creado correctamente.');
    }

    public function show(ObjetivoODS $objetivo)
    {
        return view('objetivo_ods.show', compact('objetivo'));
    }

    public function edit(ObjetivoODS $objetivo)
    {
        return view('objetivo_ods.edit', compact('objetivo'));
    }

    public function update(Request $request, ObjetivoODS $objetivo)
    {
        $request->validate([
            'Numero' => 'required|integer|min:1|max:17',
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:1000',
        ]);

        $objetivo->update($request->all());

        return redirect()->route('objetivo-ods.index')->with('success', 'Objetivo ODS actualizado correctamente.');
    }

    public function destroy(ObjetivoODS $objetivo)
    {
        $objetivo->delete();
        return redirect()->route('objetivo-ods.index')->with('success', 'Objetivo ODS eliminado.');
    }
}
