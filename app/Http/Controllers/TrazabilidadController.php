<?php

namespace App\Http\Controllers;

use App\Models\Trazabilidad;
use App\Models\User;
use Illuminate\Http\Request;

class TrazabilidadController extends Controller
{
    public function index()
    {
        $trazabilidades = Trazabilidad::with('usuarioResponsable')->get();
        return view('trazabilidad.index', compact('trazabilidades'));
    }

    public function create()
    {
        $usuarios = User::all();
        return view('trazabilidad.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'EntidadAfectada' => 'required|string',
            'IdEntidad' => 'required|integer',
            'Accion' => 'required|string',
            'UsuarioResponsable' => 'required|exists:users,Cedula',
            'Fecha' => 'required|date',
        ]);

        Trazabilidad::create($request->all());

        return redirect()->route('trazabilidad.index')->with('success', 'Registro de trazabilidad creado.');
    }

    public function show(Trazabilidad $trazabilidad)
    {
        $trazabilidad->load('usuarioResponsable');
        return view('trazabilidad.show', compact('trazabilidad'));
    }

    public function edit(Trazabilidad $trazabilidad)
    {
        $usuarios = User::all();
        return view('trazabilidad.edit', compact('trazabilidad', 'usuarios'));
    }

    public function update(Request $request, Trazabilidad $trazabilidad)
    {
        $request->validate([
            'EntidadAfectada' => 'required|string',
            'IdEntidad' => 'required|integer',
            'Accion' => 'required|string',
            'UsuarioResponsable' => 'required|exists:users,Cedula',
            'Fecha' => 'required|date',
        ]);

        $trazabilidad->update($request->all());

        return redirect()->route('trazabilidad.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(Trazabilidad $trazabilidad)
    {
        $trazabilidad->delete();
        return redirect()->route('trazabilidad.index')->with('success', 'Registro eliminado.');
    }
}
