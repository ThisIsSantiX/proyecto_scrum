<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SprintBacklog;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;


class SprintBacklogController extends Controller
{
    // Método para mostrar una lista de recursos
    public function index()
    {
        // lógica para mostrar todos los elementos
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        // lógica para mostrar el formulario
    }

    // Método para guardar un nuevo recurso


    // Guardar un nuevo item en el Sprint Backlog
    public function store(Request $request, $uid, $sprintId)
    {
        $request->validate([
            'id_item_backlog' => 'required|integer',
            'progreso' => 'required|string',
            // 'asignado_a' => 'required|array', // IDs de miembros_equipos
            // 'asignado_a.*' => 'integer'
        ],
        [
            'id_item_backlog.required' => 'La historia de usuario es requerida para agregarla al sprint.',
            'progreso.required' => 'Debe de selecionar un estado.' 
        ]
    );

        try {
            DB::beginTransaction();

            // Insertamos el ítem del sprint backlog
            $sprintBacklogId = DB::table('sprint_backlog')->insertGetId([
                'id_sprint'       => $sprintId,
                'id_item_backlog' => $request->id_item_backlog,
                'estado'          => 1,
                'progreso'        => $request->progreso,
                'uid'             => Str::uuid(),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            DB::table('product_backlog')
                ->where('id', $request->id_item_backlog)
                ->update([
                    'estado' => 0,
                    'updated_at' => now()
                ]);

            // Relacionar los usuarios (miembros del equipo)
            foreach ($request->asignado_a as $miembroId) {
                DB::table('sprint_backlog_miembros')->insert([
                    'id_sprint_backlog' => $sprintBacklogId,
                    'id_miembro_equipo' => $miembroId,
                    'uid' => Str::uuid(),
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Elemento agregado al Sprint Backlog correctamente'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Error al guardar el Sprint Backlog',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    // Mostrar todos los items de un proyecto
    public function show($uid, $sprintId)
    {
        try {
            // Obtener items del sprint backlog con información del product backlog
            $items = DB::table('sprint_backlog as sb')
                ->join('product_backlog as pb', 'sb.id_item_backlog', '=', 'pb.id')
                ->select(
                    'sb.id as sprint_item_id',
                    'sb.*',
                    'sb.uid as sprint_uid',
                    'pb.uid',
                    'pb.titulo',
                    'pb.descripcion',
                    'pb.prioridad',
                    'pb.valor_historia',
                    'pb.progreso'
                )
                ->where('sb.id_sprint', $sprintId)
                ->where('sb.estado', 1)
                ->get();

            // Obtener usuarios asignados desde sprint_backlog_miembros
            $items->transform(function ($item) {
                $usuarios = DB::table('sprint_backlog_miembros as sbm')
                    ->join('miembros_equipos as me', 'sbm.id_miembro_equipo', '=', 'me.id')
                    ->join('users as u', 'me.id_usuario', '=', 'u.id')
                    ->where('sbm.id_sprint_backlog', $item->id)
                    ->select(
                        'u.foto_url as foto_url',
                        DB::raw("CONCAT(u.nombre, ' ', u.apellido) as nombre_completo")
                    )
                    ->get();

                // 🔹 string con todos los nombres (como ya lo tenías)
                $item->responsables = $usuarios->pluck('nombre_completo')->implode(', ');

                // 🔹 array con nombre + foto (para que puedas mostrar la imagen)
                $item->responsables_detalle = $usuarios->map(function ($u) {
                    return [
                        'nombre'   => $u->nombre_completo,
                        'foto_url' => $u->foto_url,
                    ];
                });

                return $item;
            });


            return response()->json([
                'success' => true,
                'items' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los items del Sprint Backlog',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        // lógica para mostrar el formulario de edición
    }

    // Método para actualizar un recurso existente
    public function update(Request $request, $id)
    {
        // lógica para actualizar el recurso
    }

    // Método para eliminar un recurso
    public function destroy($id)
    {
        // lógica para eliminar el recurso
    }

    public function devolverHistoria($uid, $uidHistoria)
    {
        try {
            DB::beginTransaction();

            $historia = DB::table('sprint_backlog')
                ->where('uid', $uidHistoria)
                ->first();
            if (!$historia) {
                return response()->json([
                    "message" => "No se encontró la historia en el sprint backlog."
                ], 404);
            }

            //eliminar la asignacion del usuario
            DB::table('sprint_backlog_miembros')
                ->where('id_sprint_backlog', $historia->id)
                ->delete();

            //quitar la historia del sprint
            DB::table('sprint_backlog')
                ->where('id', $historia->id)
                ->update([
                    'estado' => 0,
                    'updated_at' => now()
                ]);

            //restaurar la historia al product backlog
            DB::table('product_backlog')
                ->where('id', $historia->id_item_backlog)
                ->update([
                    'estado' => 1,
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                "success" => true,
                "message" => "La historia fue devuelta al Product Backlog correctamente."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Error: " . $e->getMessage()
            ]);
        }
    }

    public function getSprintActivo($proyectoUID)
    {
        try {
            // Obtener proyecto
            $proyecto = DB::table('proyectos')->where('uid', $proyectoUID)->first();
            
            if (!$proyecto) {
                return response()->json(['success' => false, 'sprint' => null], 404);
            }

            // Buscar sprint con progreso = 'Iniciado'
            $sprint = DB::table('sprints')
                ->where('id_proyecto', $proyecto->id)
                ->where('progreso', 'Iniciado')
                ->where('estado', 1) // Activo
                ->first();

            if ($sprint) {
                return response()->json([
                    'success' => true,
                    'sprint' => $sprint
                ]);
            }

            return response()->json([
                'success' => true,
                'sprint' => null,
                'message' => 'No hay sprints iniciados'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'sprint' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene las estadísticas completas de un sprint
     */
    public function getEstadisticasSprint($proyectoUID, $sprintUID)
    {
        try {
            // Obtener proyecto
            $proyecto = DB::table('proyectos')->where('uid', $proyectoUID)->first();
            
            if (!$proyecto) {
                return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
            }

            // Obtener sprint
            $sprint = DB::table('sprints')
                ->where('uid', $sprintUID)
                ->where('id_proyecto', $proyecto->id)
                ->first();

            if (!$sprint) {
                return response()->json(['success' => false, 'message' => 'Sprint no encontrado'], 404);
            }

            // Obtener historias del sprint
            $historias = DB::table('product_backlog as pb')
                ->join('sprint_backlog as sb', 'pb.id', '=', 'sb.id_item_backlog')
                ->where('sb.id_sprint', $sprint->id)
                ->select(
                    'pb.*',
                    'sb.progreso as sprint_progreso',
                    'sb.id as sprint_backlog_id'
                )
                ->get()
                ->map(function($item) {
                    // Usar el progreso del sprint_backlog
                    $item->progreso = $item->sprint_progreso;
                    return $item;
                });

            // Calcular métricas
            $totalHistorias = $historias->count();
            $historiasCompletadas = $historias->where('progreso', 'Terminado')->count();
            $historiasEnProgreso = $historias->where('progreso', 'En progreso')->count();
            $historiasEnRevision = $historias->where('progreso', 'En revision')->count();
            $historiasPorHacer = $historias->where('progreso', 'Por hacer')->count();

            // Calcular velocity (suma de puntos de historias completadas)
            $velocity = $historias->where('progreso', 'Terminado')->sum('valor_historia');

            // Distribución por estado
            $porEstado = [
                'Por hacer' => $historiasPorHacer,
                'En progreso' => $historiasEnProgreso,
                'En revision' => $historiasEnRevision,
                'Terminado' => $historiasCompletadas
            ];

            // Distribución por prioridad
            $porPrioridad = [
                'Alta' => $historias->where('prioridad', 'Alta')->count(),
                'Media' => $historias->where('prioridad', 'Media')->count(),
                'Baja' => $historias->where('prioridad', 'Baja')->count()
            ];

            // Calcular burndown chart
            $burndown = $this->calcularBurndown($sprint, $historias);

            // Calcular velocity diario (simulado)
            $velocityDiario = $this->calcularVelocityDiario($sprint, $historias);

            return response()->json([
                'success' => true,
                'sprint' => $sprint,
                'historias' => $historias->values(),
                'total_historias' => $totalHistorias,
                'historias_completadas' => $historiasCompletadas,
                'historias_en_progreso' => $historiasEnProgreso,
                'historias_en_revision' => $historiasEnRevision,
                'historias_por_hacer' => $historiasPorHacer,
                'velocity' => $velocity,
                'por_estado' => $porEstado,
                'por_prioridad' => $porPrioridad,
                'burndown' => $burndown,
                'velocity_diario' => $velocityDiario
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calcula los datos del burndown chart
     */
    private function calcularBurndown($sprint, $historias)
    {
        $fechaInicio = Carbon::parse($sprint->fecha_inicio);
        $fechaFin = Carbon::parse($sprint->fecha_fin);
        $diasTotales = $fechaInicio->diffInDays($fechaFin);
        
        // Puntos totales del sprint
        $puntosTotal = $historias->sum('valor_historia');
        $puntosCompletados = $historias->where('progreso', 'Terminado')->sum('valor_historia');
        $puntosRestantes = $puntosTotal - $puntosCompletados;

        $labels = [];
        $ideal = [];
        $real = [];

        // Generar labels y línea ideal
        for ($i = 0; $i <= $diasTotales; $i++) {
            $fecha = $fechaInicio->copy()->addDays($i);
            $labels[] = $fecha->format('d/m');
            
            // Línea ideal (decremento lineal)
            $puntosIdeal = $puntosTotal - ($puntosTotal / $diasTotales) * $i;
            $ideal[] = round($puntosIdeal, 2);
        }

        // Línea real (simulada basándose en el progreso actual)
        $diasTranscurridos = $fechaInicio->diffInDays(Carbon::now());
        if ($diasTranscurridos > $diasTotales) {
            $diasTranscurridos = $diasTotales;
        }

        for ($i = 0; $i <= $diasTotales; $i++) {
            if ($i <= $diasTranscurridos) {
                // Calcular progreso proporcional hasta el día actual
                $progresoEstimado = ($puntosCompletados / max($diasTranscurridos, 1)) * $i;
                $real[] = max(0, round($puntosTotal - $progresoEstimado, 2));
            } else {
                // Proyección futura
                $real[] = null;
            }
        }

        // Asegurar que el último valor real sea el actual
        if ($diasTranscurridos < $diasTotales) {
            $real[$diasTranscurridos] = $puntosRestantes;
        }

        return [
            'labels' => $labels,
            'ideal' => $ideal,
            'real' => array_filter($real, function($v) { return $v !== null; })
        ];
    }

    /**
     * Calcula el velocity diario
     */
    private function calcularVelocityDiario($sprint, $historias)
    {
        $fechaInicio = Carbon::parse($sprint->fecha_inicio);
        $fechaFin = Carbon::parse($sprint->fecha_fin);
        $diasTotales = $fechaInicio->diffInDays($fechaFin);
        
        $labels = [];
        $valores = [];

        // Simulación de velocity diario
        // En un caso real, deberías tener un registro de cuándo se completó cada historia
        $puntosCompletados = $historias->where('progreso', 'Terminado')->sum('valor_historia');
        $diasTranscurridos = $fechaInicio->diffInDays(Carbon::now());
        
        if ($diasTranscurridos > $diasTotales) {
            $diasTranscurridos = $diasTotales;
        }

        for ($i = 0; $i <= min($diasTranscurridos, 10); $i++) {
            $fecha = $fechaInicio->copy()->addDays($i);
            $labels[] = $fecha->format('d/m');
            
            // Distribución aproximada de puntos completados por día
            if ($diasTranscurridos > 0) {
                $valores[] = round(($puntosCompletados / $diasTranscurridos) * ($i > 0 ? 1 : 0), 1);
            } else {
                $valores[] = 0;
            }
        }

        return [
            'labels' => $labels,
            'valores' => $valores
        ];
    }

    /**
     * Obtiene el resumen de múltiples sprints (para comparación)
     */
    public function getResumenSprints($proyectoUID)
    {
        try {
            $proyecto = DB::table('proyectos')->where('uid', $proyectoUID)->first();
            
            if (!$proyecto) {
                return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
            }

            $sprints = DB::table('sprints')
                ->where('id_proyecto', $proyecto->id)
                ->orderBy('fecha_inicio', 'desc')
                ->get();

            $resumen = [];

            foreach ($sprints as $sprint) {
                $historias = DB::table('product_backlog as pb')
                    ->join('sprint_backlog as sb', 'pb.id', '=', 'sb.id_item_backlog')
                    ->where('sb.id_sprint', $sprint->id)
                    ->select('pb.*', 'sb.progreso as sprint_progreso')
                    ->get();

                $completadas = $historias->where('sprint_progreso', 'Terminado')->count();
                $velocity = $historias->where('sprint_progreso', 'Terminado')->sum('valor_historia');

                $resumen[] = [
                    'nombre' => $sprint->nombre,
                    'uid' => $sprint->uid,
                    'progreso' => $sprint->progreso,
                    'total_historias' => $historias->count(),
                    'completadas' => $completadas,
                    'velocity' => $velocity,
                    'fecha_inicio' => $sprint->fecha_inicio,
                    'fecha_fin' => $sprint->fecha_fin
                ];
            }

            return response()->json([
                'success' => true,
                'sprints' => $resumen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
