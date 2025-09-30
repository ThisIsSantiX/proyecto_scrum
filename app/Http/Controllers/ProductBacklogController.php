<?php

namespace App\Http\Controllers;

use App\Models\product_backlog;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;



class ProductBacklogController extends Controller
{
    /**
     * Mostrar el backlog del proyecto
     */
    public function index($uid)
    {
        $proyecto = Proyecto::where('uid', $uid)->firstOrFail();

        $historias = DB::table('product_backlog')
            ->join('criterios_aceptacion', 'product_backlog.id', '=', 'criterios_aceptacion.id_item_backlog')
            ->where('product_backlog.id_proyecto', $proyecto->id)
            ->where('product_backlog.estado', 1) // Solo activas
            ->select(
                'product_backlog.id as historia_id',
                'product_backlog.titulo as historia_titulo',
                'product_backlog.descripcion as historia_descripcion',
                'product_backlog.prioridad',
                'criterios_aceptacion.id as criterio_id',
                'criterios_aceptacion.descripcion as criterio_descripcion',
                'criterios_aceptacion.estado as criterio_estado'
            )
            ->get();

        $sprints = DB::table('sprints')
            ->where('id_proyecto', $proyecto->id)
            ->get();

        $sprintBacklog = DB::table('sprint_backlog')
            ->get();

        return view('pages.proyectos.backlog.index', compact('proyecto', 'historias', 'sprints', 'sprintBacklog'));
    }


    // Método para mostrar el formulario de creación
    public function create()
    {
        // lógica para mostrar el formulario
    }

    public function store(Request $request, $uid)
    {
        try {
            // Buscar el proyecto por UID
            $proyecto = Proyecto::where('uid', $uid)->first();

            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado.'
                ], 404);
            }

            // Crear la historia de usuario directamente con datos del request
            $historia = product_backlog::create([
                'id_proyecto' => $proyecto->id,
                'creado_por' => Auth::id(),
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'prioridad' => $request->prioridad,
                'valor_historia' => $request->valor_historia,
                'progreso' => $request->progreso,
                'estado' => 1,
                'uid' => Str::uuid()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Historia de usuario creada exitosamente.',
                'historia' => [
                    'id' => $historia->id,
                    'titulo' => $historia->titulo,
                    'descripcion' => $historia->descripcion,
                    'prioridad' => $historia->prioridad,
                    'valor_historia' => $historia->valor_historia,
                    'progreso' => $historia->progreso,
                    'uid' => $historia->uid
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Por favor, inténtalo de nuevo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($uid)
    {
        try {
            // Buscar el proyecto por UID
            $proyecto = Proyecto::where('uid', $uid)->first();

            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado.'
                ], 404);
            }

            // Obtener las historias con sus criterios de aceptación
            $historiasRaw = DB::table('product_backlog')
                ->leftJoin('criterios_aceptacion', 'product_backlog.id', '=', 'criterios_aceptacion.id_item_backlog')
                ->leftJoin('users', 'product_backlog.creado_por', '=', 'users.id')
                ->where('product_backlog.id_proyecto', $proyecto->id)
                ->where('product_backlog.estado', 1) // Solo activas
                ->select(
                    'product_backlog.id as historia_id',
                    'product_backlog.titulo as historia_titulo',
                    'product_backlog.descripcion as historia_descripcion',
                    'product_backlog.prioridad',
                    'product_backlog.valor_historia',
                    'product_backlog.progreso',
                    'product_backlog.uid as historia_uid',
                    'product_backlog.created_at',
                    'users.username as creador_nombre',
                    'users.foto_url as foto_url',
                    'criterios_aceptacion.id as criterio_id',
                    'criterios_aceptacion.descripcion as criterio_descripcion',
                    'criterios_aceptacion.estado as criterio_estado',
                    'criterios_aceptacion.uid as criterio_uid',
                )
                ->orderBy('product_backlog.valor_historia', 'desc')
                ->get();

            // Agrupar historias con sus criterios
            $historiasAgrupadas = collect();
            $historiasProcesadas = [];

            foreach ($historiasRaw as $row) {
                $historiaId = $row->historia_id;

                if (!isset($historiasProcesadas[$historiaId])) {
                    $historiasProcesadas[$historiaId] = [
                        'id' => $row->historia_id,
                        'titulo' => $row->historia_titulo,
                        'descripcion' => $row->historia_descripcion,
                        'prioridad' => $row->prioridad,
                        'valor_historia' => $row->valor_historia,
                        'foto_url' => $row->foto_url,
                        'progreso' => $row->progreso,
                        'uid' => $row->historia_uid,
                        'creador_nombre' => $row->creador_nombre,
                        'fecha_creacion' => $row->created_at,
                        'criterios' => []
                    ];
                }

                // Agregar criterio si existe
                if ($row->criterio_id && $row->criterio_estado==1) {
                    $historiasProcesadas[$historiaId]['criterios'][] = [
                        'id' => $row->criterio_id,
                        'descripcion' => $row->criterio_descripcion,
                        'estado' => (bool) $row->criterio_estado,
                        'uid' => $row->criterio_uid,
                    ];
                }
            }

            // Convertir a array indexado
            $historias = array_values($historiasProcesadas);

            return response()->json([
                'success' => true,
                'message' => 'Historias obtenidas correctamente.',
                'historias' => $historias,
                'total' => count($historias)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las historias del backlog.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        // lógica para mostrar el formulario de edición
    }

    // Método para actualizar un recurso existente
    public function update(Request $request, $uid, $historiaUid)
    {
        try {
            // Buscar el proyecto
            $proyecto = Proyecto::where('uid', $uid)->first();
            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado.'
                ], 404);
            }

            // Buscar la historia
            $historia = product_backlog::where('uid', $historiaUid)
                ->where('id_proyecto', $proyecto->id)
                ->first();

            if (!$historia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Historia no encontrada.'
                ], 404);
            }

            // Validación
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:50',
                'descripcion' => 'required|string|max:255',
                'prioridad' => 'required|in:Alta,Media,Baja',
                'valor_historia' => 'required|integer|min:1|max:100',
                'progreso' => 'required|in:Por hacer,En progreso,Completado'
            ]);

            // Actualizar
            $historia->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Historia actualizada exitosamente.',
                'historia' => $historia
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la historia.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para eliminar un recurso
    public function destroy($uid)
    {
        try {
            // Buscar la historia por UID
            $historia = DB::table('product_backlog')->where('uid', $uid)->first();

            if (!$historia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Historia no encontrada.'
                ], 404);
            }

            // Marcar como eliminada (si usas borrado lógico con campo estado)
            DB::table('product_backlog')
                ->where('uid', $uid)
                ->update(['estado' => 0, 'updated_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Historia eliminada correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la historia.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
