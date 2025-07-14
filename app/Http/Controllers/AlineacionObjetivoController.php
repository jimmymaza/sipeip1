<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlineacionObjetivo;
use App\Models\ObjetivoInstitucional;
use App\Models\ObjetivoPND;
use App\Models\ObjetivoODS;

class AlineacionObjetivoController extends Controller
{
    public function index()
    {
        $alineaciones = AlineacionObjetivo::with(['objetivoInstitucional', 'objetivoPND', 'objetivoODS'])->get();
        return view('alineacion.index', compact('alineaciones'));
    }

    public function create()
    {
        $objetivosInstitucionales = ObjetivoInstitucional::all();
        $objetivosPND = ObjetivoPND::all();
        $objetivosODS = ObjetivoODS::all();

        return view('alineacion.create', compact('objetivosInstitucionales', 'objetivosPND', 'objetivosODS'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'objetivo_institucional_id' => 'required|exists:objetivo_institucionals,IdObjetivo',
            'objetivo_pnd_id'           => 'required|exists:objetivo_pnds,id',
            'objetivo_ods_id'           => 'required|exists:objetivo_o_d_s,id',
        ]);

        AlineacionObjetivo::create($request->all());

        return redirect()->route('alineacion.index')->with('success', 'Alineación creada correctamente.');
    }

    public function show(AlineacionObjetivo $alineacion)
    {
        $alineacion->load(['objetivoInstitucional', 'objetivoPND', 'objetivoODS']);
        return view('alineacion.show', compact('alineacion'));
    }

    public function edit(AlineacionObjetivo $alineacion)
    {
        $objetivosInstitucionales = ObjetivoInstitucional::all();
        $objetivosPND = ObjetivoPND::all();
        $objetivosODS = ObjetivoODS::all();

        return view('alineacion.edit', compact('alineacion', 'objetivosInstitucionales', 'objetivosPND', 'objetivosODS'));
    }

    public function update(Request $request, AlineacionObjetivo $alineacion)
    {
        $request->validate([
            'objetivo_institucional_id' => 'required|exists:objetivo_institucionals,IdObjetivo',
            'objetivo_pnd_id'           => 'required|exists:objetivo_pnds,id',
            'objetivo_ods_id'           => 'required|exists:objetivo_o_d_s,id',
        ]);

        $alineacion->update($request->all());

        return redirect()->route('alineacion.index')->with('success', 'Alineación actualizada correctamente.');
    }

    public function destroy(AlineacionObjetivo $alineacion)
    {
        $alineacion->delete();
        return redirect()->route('alineacion.index')->with('success', 'Alineación eliminada correctamente.');
    }
}
