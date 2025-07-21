<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstitucionController extends Controller
{
    public function index()
    {
        $instituciones = Institucion::orderBy('IdInstitucion', 'asc')->paginate(10);
        return view('instituciones.index', compact('instituciones'));
    }

    public function create()
    {
        $subsectores = Institucion::select('Subsector')->distinct()->orderBy('Subsector')->pluck('Subsector');
        return view('instituciones.create', compact('subsectores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => ['required', 'string', 'max:255'],
            'Codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('instituciones')->where(function ($query) use ($request) {
                    return $query->where('Nombre', $request->Nombre)
                                 ->where('Subsector', $request->Subsector);
                }),
            ],
            'Subsector' => 'required|string|max:100',
            'NivelGobierno' => 'required|in:Nacional,Provincial,Cantonal',
            'Estado' => 'required|in:1,0',
        ]);

        $data = $request->all();
        $data['Estado'] = (int)$data['Estado'];

        Institucion::create($data);

        return redirect()->route('instituciones.index')->with('success', 'Institución creada correctamente');
    }

    public function edit($id)
    {
        $institucion = Institucion::findOrFail($id);
        $subsectores = Institucion::select('Subsector')->distinct()->orderBy('Subsector')->pluck('Subsector');
        return view('instituciones.edit', compact('institucion', 'subsectores'));
    }

    public function update(Request $request, $id)
    {
        $institucion = Institucion::findOrFail($id);

        $request->validate([
            'Nombre' => ['required', 'string', 'max:255'],
            'Codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('instituciones')->where(function ($query) use ($request) {
                    return $query->where('Nombre', $request->Nombre)
                                 ->where('Subsector', $request->Subsector);
                })->ignore($institucion->IdInstitucion, 'IdInstitucion'),
            ],
            'Subsector' => 'required|string|max:100',
            'NivelGobierno' => 'required|string|max:100',
            'Estado' => 'required|in:1,0',
        ]);

        $data = $request->all();
        $data['Estado'] = (int)$data['Estado'];

        $institucion->update($data);

        return redirect()->route('instituciones.index')->with('success', 'Institución actualizada correctamente.');
    }

    public function destroy($id)
    {
        $institucion = Institucion::findOrFail($id);
        $institucion->delete();

        return redirect()->route('instituciones.index')->with('success', 'Institución eliminada correctamente');
    }
}
