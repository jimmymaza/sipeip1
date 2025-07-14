<?php

namespace App\Http\Controllers;

use App\Models\Revision;
use App\Models\User;
use App\Models\Plan;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class RevisionController extends Controller
{
    public function index()
    {
        $revisiones = Revision::with(['usuario', 'plan', 'proyecto'])->get();
        return view('revision.index', compact('revisiones'));
    }

    public function create()
    {
        $usuarios = User::all();
        $planes = Plan::all();
        $proyectos = Proyecto::all();
        return view('revision.create', compact('usuarios', 'planes', 'proyectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Comentario' => 'required|string',
            'FechaRevision' => 'required|date',
            'IdUsuario' => 'required|exists:users,Cedula',
            'IdPlan' => 'required|exists:plan,IdPlan',
            'IdProyecto' => 'required|exists:proyecto,IdProyecto',
        ]);

        Revision::create($request->all());

        return redirect()->route('revision.index')->with('success', 'Revisión creada correctamente.');
    }

    public function show(Revision $revision)
    {
        $revision->load(['usuario', 'plan', 'proyecto']);
        return view('revision.show', compact('revision'));
    }

    public function edit(Revision $revision)
    {
        $usuarios = User::all();
        $planes = Plan::all();
        $proyectos = Proyecto::all();
        return view('revision.edit', compact('revision', 'usuarios', 'planes', 'proyectos'));
    }

    public function update(Request $request, Revision $revision)
    {
        $request->validate([
            'Comentario' => 'required|string',
            'FechaRevision' => 'required|date',
            'IdUsuario' => 'required|exists:users,Cedula',
            'IdPlan' => 'required|exists:plan,IdPlan',
            'IdProyecto' => 'required|exists:proyecto,IdProyecto',
        ]);

        $revision->update($request->all());

        return redirect()->route('revision.index')->with('success', 'Revisión actualizada correctamente.');
    }

    public function destroy(Revision $revision)
    {
        $revision->delete();
        return redirect()->route('revision.index')->with('success', 'Revisión eliminada correctamente.');
    }
}
