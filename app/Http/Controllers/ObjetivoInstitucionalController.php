<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoInstitucional;
use App\Models\Plan;
use Illuminate\Http\Request;

class ObjetivoInstitucionalController extends Controller
{
    private array $tiposValidos = ['institucional', 'plan_nacional', 'ods'];

    private array $nombresTipos = [
        'institucional' => 'Objetivos Institucionales',
        'plan_nacional' => 'Objetivos del Plan Nacional de Desarrollo',
        'ods' => 'Objetivos de Desarrollo Sostenible (ODS)',
    ];

    private function validarTipo(string $tipo): void
    {
        $tipo = strtolower(trim($tipo));

        if (!in_array($tipo, $this->tiposValidos, true)) {
            abort(404, 'Tipo de objetivo no válido.');
        }
    }

    private function obtenerNombreTipo(string $tipo): string
    {
        return $this->nombresTipos[$tipo] ?? 'Objetivos';
    }

    public function index(string $tipo = 'institucional')
    {
        $tipoNormalizado = strtolower(trim($tipo));
        $this->validarTipo($tipoNormalizado);

        $objetivos = ObjetivoInstitucional::with('planes')
            ->where('tipo', $tipoNormalizado)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('objetivos.index', [
            'objetivos' => $objetivos,
            'tipo' => $tipoNormalizado,
            'nombreTipo' => $this->obtenerNombreTipo($tipoNormalizado),
        ]);
    }

    public function create(string $tipo)
    {
        $tipoNormalizado = strtolower(trim($tipo));
        $this->validarTipo($tipoNormalizado);

        return view('objetivos.create', [
            'planes' => Plan::orderBy('nombre')->get(),
            'tipo' => $tipoNormalizado,
            'nombreTipo' => $this->obtenerNombreTipo($tipoNormalizado),
        ]);
    }

    public function store(Request $request, string $tipo)
    {
        $tipoNormalizado = strtolower(trim($tipo));
        $this->validarTipo($tipoNormalizado);

        $messages = [
            'codigo.required'        => 'El código del objetivo es obligatorio.',
            'codigo.unique'          => 'El código ya está en uso.',
            'nombre.required'        => 'El nombre del objetivo es obligatorio.',
            'descripcion.required'   => 'La descripción es obligatoria.',
            'estado.required'        => 'El estado es obligatorio.',
            'estado.in'              => 'El estado debe ser "activo" o "inactivo".',
            'fecha_registro.date'    => 'La fecha de registro debe ser una fecha válida.',
            'planes.array'           => 'El campo planes debe ser un arreglo.',
            'planes.*.integer'       => 'Cada plan debe ser un número entero válido.',
            'planes.*.exists'        => 'El plan seleccionado no existe.',
        ];

        $validated = $request->validate([
            'codigo'          => 'required|unique:objetivos_institucionales,codigo',
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'required|string',
            'estado'          => 'required|in:activo,inactivo',
            'fecha_registro'  => 'nullable|date',
            'planes'          => 'nullable|array',
            'planes.*'        => 'integer|exists:planes,id',
        ], $messages);

        $validated['tipo'] = $tipoNormalizado;

        $objetivo = ObjetivoInstitucional::create($validated);

        if (!empty($validated['planes'])) {
            // Aquí especificamos bien la relación para evitar ambigüedades
            $objetivo->planes()->sync($validated['planes']);
        }

        return redirect()->route('objetivos.index', ['tipo' => $tipoNormalizado])
            ->with('success', 'Objetivo creado correctamente.');
    }

    public function edit(string $tipo, ObjetivoInstitucional $objetivo)
    {
        $tipoNormalizado = strtolower(trim($tipo));
        $this->validarTipo($tipoNormalizado);

        if ($objetivo->tipo !== $tipoNormalizado) {
            abort(404, 'El objetivo no corresponde al tipo solicitado.');
        }

        return view('objetivos.edit', [
            'objetivo'            => $objetivo,
            'planes'              => Plan::orderBy('nombre')->get(),
            'planesSeleccionados' => $objetivo->planes()->pluck('planes.id')->toArray(), // Aquí se especifica 'planes.id'
            'tipo'                => $tipoNormalizado,
            'nombreTipo'          => $this->obtenerNombreTipo($tipoNormalizado),
        ]);
    }

    public function update(Request $request, string $tipo, ObjetivoInstitucional $objetivo)
    {
        $tipoNormalizado = strtolower(trim($tipo));
        $this->validarTipo($tipoNormalizado);

        if ($objetivo->tipo !== $tipoNormalizado) {
            abort(404, 'El objetivo no corresponde al tipo solicitado.');
        }

        $messages = [
            'codigo.required'        => 'El código del objetivo es obligatorio.',
            'codigo.unique'          => 'El código ya está en uso.',
            'nombre.required'        => 'El nombre del objetivo es obligatorio.',
            'descripcion.required'   => 'La descripción es obligatoria.',
            'estado.required'        => 'El estado es obligatorio.',
            'estado.in'              => 'El estado debe ser "activo" o "inactivo".',
            'fecha_registro.date'    => 'La fecha de registro debe ser una fecha válida.',
            'planes.array'           => 'El campo planes debe ser un arreglo.',
            'planes.*.integer'       => 'Cada plan debe ser un número entero válido.',
            'planes.*.exists'        => 'El plan seleccionado no existe.',
        ];

        $validated = $request->validate([
            'codigo'          => 'required|unique:objetivos_institucionales,codigo,' . $objetivo->id,
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'required|string',
            'estado'          => 'required|in:activo,inactivo',
            'fecha_registro'  => 'nullable|date',
            'planes'          => 'nullable|array',
            'planes.*'        => 'integer|exists:planes,id',
        ], $messages);

        $validated['tipo'] = $tipoNormalizado;

        $objetivo->update($validated);

        if (!empty($validated['planes'])) {
            $objetivo->planes()->sync($validated['planes']);
        } else {
            $objetivo->planes()->detach();
        }

        return redirect()->route('objetivos.index', ['tipo' => $tipoNormalizado])
            ->with('success', 'Objetivo actualizado correctamente.');
    }

    public function destroy(string $tipo, ObjetivoInstitucional $objetivo)
    {
        $tipoNormalizado = strtolower(trim($tipo));
        $this->validarTipo($tipoNormalizado);

        if ($objetivo->tipo !== $tipoNormalizado) {
            abort(404, 'El objetivo no corresponde al tipo solicitado.');
        }

        $objetivo->planes()->detach();
        $objetivo->delete();

        return redirect()->route('objetivos.index', ['tipo' => $tipoNormalizado])
            ->with('success', 'Objetivo eliminado correctamente.');
    }

    public function show(string $tipo, ObjetivoInstitucional $objetivo)
    {
        $tipoNormalizado = strtolower(trim($tipo));
        $this->validarTipo($tipoNormalizado);

        if ($objetivo->tipo !== $tipoNormalizado) {
            abort(404, 'El objetivo no corresponde al tipo solicitado.');
        }

        $objetivo->load('planes', 'metas');

        return view('objetivos.show', [
            'objetivo'   => $objetivo,
            'tipo'       => $tipoNormalizado,
            'nombreTipo' => $this->obtenerNombreTipo($tipoNormalizado),
        ]);
    }
}
