<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|unique:rol,Nombre',
            'Descripcion' => 'required|string',
        ]);

        Rol::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol creado con éxito');
    }

    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nombre' => 'required|string|unique:rol,Nombre,' . $id . ',IdRol',
            'Descripcion' => 'required|string',
        ]);

        $rol = Rol::findOrFail($id);
        $rol->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol actualizado con éxito');
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado con éxito');
    }
}
