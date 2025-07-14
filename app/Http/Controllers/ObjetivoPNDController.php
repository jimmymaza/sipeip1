<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoPND;
use Illuminate\Http\Request;

class ObjetivoPNDController extends Controller
{
    public function index()
    {
        $objetivos = ObjetivoPND::all();
        return view('objetivo_pnd.index', compact('objetivos'));
    }

    public function create()
    {
        return view('objetivo_pnd.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Codigo' => 'required|string|max:20',
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:1000',
            'Eje' => 'nullable|string|max:100',
        ]);

        ObjetivoPND::create($request->all());

        return redirect()->route('objetivo-pnd.index')->with('success', 'Objetivo PND creado correctamente.');
    }

    public function show(ObjetivoPND $objetivo)
    {
        return view('objetivo_pnd.show', compact('objetivo'));
    }

    public function edit(ObjetivoPND $objetivo)
    {
        return view('objetivo_pnd.edit', compact('objetivo'));
    }

    public function update(Request $request, ObjetivoPND $objetivo)
    {
        $request->validate([
            'Codigo' => 'required|string|max:20',
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:1000',
            'Eje' => 'nullable|string|max:100',
        ]);

        $objetivo->update($request->all());

        return redirect()->route('objetivo-pnd.index')->with('success', 'Objetivo PND actualizado correctamente.');
    }

    public function destroy(ObjetivoPND $objetivo)
    {
        $objetivo->delete();
        return redirect()->route('objetivo-pnd.index')->with('success', 'Objetivo PND eliminado.');
    }
}
