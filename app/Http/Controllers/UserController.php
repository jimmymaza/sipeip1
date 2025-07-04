<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $roles = [
        'Administrador',
        'Técnico de Planificación',
        'Revisor Institucional',
        'Autoridad Validante',
        'Usuario Externo',
        'Auditor / Control Interno',
        'Desarrollador / Soporte Técnico',
    ];

    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = $this->roles;
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|string|unique:users,cedula',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'rol' => 'required|string|in:' . implode(',', $this->roles),
            'password' => 'required|string|min:4',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado');
    }

    public function edit(User $usuario)
    {
        $roles = $this->roles;
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|string|unique:users,cedula,' . $usuario->id,
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'rol' => 'required|string|in:' . implode(',', $this->roles),
            'password' => 'nullable|string|min:4',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado');
    }
}
