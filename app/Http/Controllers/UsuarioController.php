<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Mostrar listado paginado de usuarios
    public function index()
    {
        $usuarios = User::orderBy('IdUsuario', 'asc')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    // Mostrar formulario para crear nuevo usuario
    public function create()
    {
        $roles = Rol::orderBy('Nombre')->get();
        $instituciones = Institucion::orderBy('Nombre')->get();
        return view('usuarios.create', compact('roles', 'instituciones'));
    }

    // Guardar nuevo usuario en BD
    public function store(Request $request)
    {
        $request->validate([
            'Cedula' => 'required|string|unique:usuarios,Cedula',
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'Correo' => 'required|email|unique:usuarios,Correo',
            'IdRol' => 'required|exists:rol,IdRol',  // <-- Aquí corregí 'rol' a 'roles'
            'Clave' => 'required|confirmed|min:6',
            'Telefono' => 'nullable|string|max:20',
            'IdInstitucion' => 'nullable|exists:instituciones,IdInstitucion',
        ], [
            'IdRol.required' => 'El campo rol es obligatorio.',
            'Clave.required' => 'La contraseña es obligatoria.',
            'Clave.confirmed' => 'La confirmación de la contraseña no coincide.',
            'Clave.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = new User();
        $user->Cedula = $request->Cedula;
        $user->Nombre = $request->Nombre;
        $user->Apellido = $request->Apellido;
        $user->Correo = $request->Correo;
        $user->Telefono = $request->Telefono ?? null;
        $user->IdRol = $request->IdRol;
        $user->IdInstitucion = $request->IdInstitucion ?? null;
        $user->Clave = Hash::make($request->Clave);
        $user->FechaCreacion = now();  // Mejor usar now() directamente
        $user->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    // Mostrar formulario para editar usuario
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Rol::orderBy('Nombre')->get();
        $instituciones = Institucion::orderBy('Nombre')->get();
        return view('usuarios.edit', compact('usuario', 'roles', 'instituciones'));
    }

    // Actualizar usuario en BD
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'Cedula' => 'required|string|unique:usuarios,Cedula,' . $usuario->IdUsuario . ',IdUsuario',
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'Correo' => 'required|email|unique:usuarios,Correo,' . $usuario->IdUsuario . ',IdUsuario',
            'IdRol' => 'required|exists:rol,IdRol',  // Corregido a 'roles'
            'Clave' => 'nullable|confirmed|min:6',
            'Telefono' => 'nullable|string|max:20',
            'IdInstitucion' => 'nullable|exists:instituciones,IdInstitucion',
        ], [
            'IdRol.required' => 'El campo rol es obligatorio.',
            'Clave.confirmed' => 'La confirmación de la contraseña no coincide.',
            'Clave.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $usuario->Cedula = $request->Cedula;
        $usuario->Nombre = $request->Nombre;
        $usuario->Apellido = $request->Apellido;
        $usuario->Correo = $request->Correo;
        $usuario->Telefono = $request->Telefono ?? null;
        $usuario->IdRol = $request->IdRol;
        $usuario->IdInstitucion = $request->IdInstitucion ?? null;

        if ($request->filled('Clave')) {
            $usuario->Clave = Hash::make($request->Clave);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
