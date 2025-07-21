<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\ObjetivoInstitucional;
use App\Models\Proyecto;
use App\Models\Institucion;
use App\Models\Rol;

// Importa el facade de DomPDF correctamente según versión Laravel y paquete instalado
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        $instituciones = Institucion::all();
        $roles = Rol::all();

        return view('reportes.index', compact('instituciones', 'roles'));
    }

    public function generar(Request $request)
    {
        $tipo = $request->input('tipo');
        $action = $request->input('action'); // 'filtrar' o 'pdf'

        $tipos_validos = [
            'usuarios',
            'planes',
            'objetivos_institucionales',
            'proyectos',
            'instituciones',
            'roles',
        ];

        if (!in_array($tipo, $tipos_validos)) {
            abort(404, 'Tipo de reporte no válido');
        }

        // Obtener datos filtrados
        $datos = $this->consultarDatos($tipo, $request->all());

        $instituciones = Institucion::all();
        $roles = Rol::all();

        $titulos = [
            'usuarios' => 'Usuarios',
            'planes' => 'Planes',
            'objetivos_institucionales' => 'Objetivos Institucionales',
            'proyectos' => 'Proyectos',
            'instituciones' => 'Instituciones',
            'roles' => 'Roles',
        ];

        $titulo = $titulos[$tipo] ?? ucfirst($tipo);

        if ($action === 'pdf') {
            // Generar y descargar PDF directamente
            $pdf = Pdf::loadView('reportes.resultados_pdf', compact('datos', 'tipo', 'instituciones', 'roles', 'titulo'));
            return $pdf->download("reporte_{$tipo}_" . date('Ymd_His') . ".pdf");
        }

        return view('reportes.resultados', compact('datos', 'tipo', 'instituciones', 'roles', 'titulo'));
    }

    /**
     * Construye consulta y devuelve datos según tipo y filtros.
     */
    private function consultarDatos(string $tipo, array $filtros)
    {
        switch ($tipo) {
            case 'usuarios':
                $query = User::query();
                if (!empty($filtros['institucion_id'])) {
                    $query->where('IdInstitucion', $filtros['institucion_id']);
                }
                if (!empty($filtros['rol_id'])) {
                    $query->where('IdRol', $filtros['rol_id']);
                }
                if (!empty($filtros['fecha_desde'])) {
                    $query->whereDate('FechaCreacion', '>=', $filtros['fecha_desde']);
                }
                if (!empty($filtros['fecha_hasta'])) {
                    $query->whereDate('FechaCreacion', '<=', $filtros['fecha_hasta']);
                }
                return $query->get();

            case 'planes':
                $query = Plan::query();
                if (!empty($filtros['estado'])) {
                    $query->where('estado', $filtros['estado']);
                }
                if (!empty($filtros['fecha_desde'])) {
                    $query->whereDate('fecha_inicio', '>=', $filtros['fecha_desde']);
                }
                if (!empty($filtros['fecha_hasta'])) {
                    $query->whereDate('fecha_fin', '<=', $filtros['fecha_hasta']);
                }
                return $query->get();

            case 'objetivos_institucionales':
                $query = ObjetivoInstitucional::query();
                if (!empty($filtros['estado'])) {
                    $query->where('estado', $filtros['estado']);
                }
                return $query->get();

            case 'proyectos':
                $query = Proyecto::query();
                if (!empty($filtros['estado'])) {
                    $query->where('estado', $filtros['estado']);
                }
                if (!empty($filtros['fecha_desde'])) {
                    $query->whereDate('fecha_inicio', '>=', $filtros['fecha_desde']);
                }
                if (!empty($filtros['fecha_hasta'])) {
                    $query->whereDate('fecha_fin', '<=', $filtros['fecha_hasta']);
                }
                return $query->get();

            case 'instituciones':
                $query = Institucion::query();
                if (!empty($filtros['estado'])) {
                    $query->where('estado', $filtros['estado']);
                }
                return $query->get();

            case 'roles':
                $query = Rol::query();
                if (!empty($filtros['nombre_rol'])) {
                    $query->where('nombre_rol', 'like', '%' . $filtros['nombre_rol'] . '%');
                }
                return $query->get();

            default:
                return collect();
        }
    }
}
