<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\Indicador;
use App\Models\User; // Agregar el modelo User
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function index()
    {
        $metas = Meta::with('indicador')->paginate(10);
        return view('metas.index', compact('metas'));
    }

    public function create()
    {
        $indicadores = Indicador::where('estado', 'activo')->get();
        $usuarios = User::all();  // Agregado para enviar usuarios
        return view('metas.create', compact('indicadores', 'usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_indicador' => 'required|exists:indicadores,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'valor_objetivo' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
            'usuario_responsable_id' => 'required|exists:users,id', // validar responsable
        ]);

        Meta::create($validated);

        return redirect()->route('metas.index')->with('success', 'Meta creada correctamente.');
    }

    public function show(Meta $meta)
    {
        $meta->load('indicador');
        return view('metas.show', compact('meta'));
    }

    public function edit(Meta $meta)
    {
        $indicadores = Indicador::where('estado', 'activo')->get();
        $usuarios = User::all();  // Agregado para enviar usuarios a la vista
        return view('metas.edit', compact('meta', 'indicadores', 'usuarios'));
    }

    public function update(Request $request, Meta $meta)
    {
        $validated = $request->validate([
            'id_indicador' => 'required|exists:indicadores,id',
            'anio' => 'required|integer|min:2000|max:2100',
            'valor_objetivo' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo',
            'usuario_responsable_id' => 'required|exists:users,id', // validar responsable
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
