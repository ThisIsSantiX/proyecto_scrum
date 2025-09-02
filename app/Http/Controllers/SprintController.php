<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Exception;


class SprintController extends Controller
{

    // Método para mostrar una lista de recursos
    public function index()
    {

    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        // lógica para mostrar el formulario
        return view('pages.sprints.create'); 
    }

    // Método para guardar un nuevo recurso
    public function store(Request $request, $uid)
    {
        try {
            // Obtener el proyecto por UID
            $proyecto = DB::table('proyectos')->where('uid', $uid)->first();
            
            if (!$proyecto) {
                return response()->json([
                    'error' => 'Proyecto no encontrado'
                ], 404);
            }
            
            // Validar datos
            $request->validate([
                'nombre' => 'required|string|max:50',
                'objetivo' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio'
            ], [
                'nombre.required' => 'El nombre del sprint es requerido',
                'nombre.max' => 'El nombre del sprint no puede exceder 50 caracteres',
                'objetivo.required' => 'El objetivo del sprint es requerido',
                'fecha_inicio.required' => 'La fecha de inicio es requerida',
                'fecha_fin.required' => 'La fecha de fin es requerida',
                'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio'
            ]);
            
            // Calcular progreso inicial basado en fechas
            $progreso = $this->calcularProgreso($request->fecha_inicio, $request->fecha_fin);
            
            // Crear sprint
            $sprintId = DB::table('sprints')->insertGetId([
                'nombre' => $request->nombre,
                'objetivo' => $request->objetivo,
                'id_proyecto' => $proyecto->id,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'progreso' => $progreso,
                'estado' => 1, // Por hacer
                'uid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Obtener el sprint creado
            $sprint = DB::table('sprints')->where('id', $sprintId)->first();
            
            return response()->json([
                'success' => true,
                'message' => 'Sprint creado correctamente',
                'sprint' => $sprint
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos inválidos',
                'errors' => $e->errors()
            ], 422);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al crear sprint: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para mostrar un recurso específico
    public function show($uid)
    {
        try {
            // Obtener el proyecto por UID
            $proyecto = DB::table('proyectos')->where('uid', $uid)->first();
            
            if (!$proyecto) {
                return response()->json([
                    'error' => 'Proyecto no encontrado'
                ], 404);
            }
            
            // Obtener sprints del proyecto
            $sprints = DB::table('sprints')
                        ->where('id_proyecto', $proyecto->id)
                        ->where('estado', 1) 
                        ->orderBy('created_at', 'asc')
                        ->get();
            
            return response()->json($sprints);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener sprints: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        // lógica para mostrar el formulario de edición
        $sprint = Sprint::findOrFail($id); 
        return view('pages.sprints.edit', compact('sprint'));
    }

    // Método para actualizar un sprint por UID
    public function update(Request $request, $uid)
    {
        try {
            // Obtener el proyecto por UID
            $proyecto = DB::table('proyectos')->where('uid', $uid)->first();
            
            if (!$proyecto) {
                return response()->json([
                    'error' => 'Proyecto no encontrado'
                ], 404);
            }
            
            // Validar datos
            $request->validate([
                'uid' => 'required|string|exists:sprints,uid',
                'nombre' => 'required|string|max:50',
                'objetivo' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio'
            ], [
                'uid.required' => 'UID del sprint es requerido',
                'uid.exists' => 'El sprint no existe',
                'nombre.required' => 'El nombre del sprint es requerido',
                'nombre.max' => 'El nombre del sprint no puede exceder 50 caracteres',
                'objetivo.required' => 'El objetivo del sprint es requerido',
                'fecha_inicio.required' => 'La fecha de inicio es requerida',
                'fecha_fin.required' => 'La fecha de fin es requerida',
                'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio'
            ]);
            
            // Verificar que el sprint pertenece al proyecto
            $sprint = DB::table('sprints')
                    ->where('uid', $request->uid)
                    ->where('id_proyecto', $proyecto->id)
                    ->first();
            
            if (!$sprint) {
                return response()->json([
                    'error' => 'Sprint no encontrado en este proyecto'
                ], 404);
            }
            
            // Calcular progreso basado en fechas
            $progreso = $this->calcularProgreso($request->fecha_inicio, $request->fecha_fin);
            
            // Actualizar sprint
            $updated = DB::table('sprints')
                        ->where('uid', $request->uid)
                        ->update([
                            'nombre' => $request->nombre,
                            'objetivo' => $request->objetivo,
                            'fecha_inicio' => $request->fecha_inicio,
                            'fecha_fin' => $request->fecha_fin,
                            'progreso' => $progreso,
                            'updated_at' => now()
                        ]);
            
            if ($updated) {
                // Obtener el sprint actualizado
                $sprintActualizado = DB::table('sprints')->where('uid', $request->uid)->first();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Sprint actualizado correctamente',
                    'sprint' => $sprintActualizado
                ]);
            } else {
                return response()->json([
                    'error' => 'No se pudo actualizar el sprint'
                ], 500);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos inválidos',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar sprint:',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Método para eliminar un recurso
    public function destroy(Request $request, $uidProyecto)
    {
        try {
            // Obtener el proyecto por UID
            $proyecto = DB::table('proyectos')->where('uid', $uidProyecto)->first();
            
            if (!$proyecto) {
                return response()->json([
                    'error' => 'Proyecto no encontrado'
                ], 404);
            }

            // Validar datos
            $request->validate([
                'uid' => 'required|string|exists:sprints,uid'
            ], [
                'uid.required' => 'UID del sprint es requerido',
                'uid.exists' => 'El sprint no existe'
            ]);

            // Verificar que el sprint pertenece al proyecto
            $sprint = DB::table('sprints')
                    ->where('uid', $request->uid)
                    ->where('id_proyecto', $proyecto->id)
                    ->first();

            if (!$sprint) {
                return response()->json([
                    'error' => 'Sprint no encontrado en este proyecto'
                ], 404);
            }

            // Cambiar estado en lugar de eliminar
            $updated = DB::table('sprints')
                        ->where('uid', $request->uid)
                        ->update([
                            'estado' => 0, // marcamos como inactivo
                            'updated_at' => now()
                        ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sprint desactivado correctamente'
                ]);
            } else {
                return response()->json([
                    'error' => 'No se pudo desactivar el sprint'
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al desactivar sprint',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    private function calcularProgreso($fechaInicio, $fechaFin)
    {
        $inicio = \Carbon\Carbon::parse($fechaInicio);
        $fin = \Carbon\Carbon::parse($fechaFin);
        $hoy = \Carbon\Carbon::now();
        
        if ($hoy->lt($inicio)) {
            return 'Por hacer';
        } elseif ($hoy->gt($fin)) {
            return 'Completado';
        } else {
            return 'En progreso';
        }
    }

    public function showItems($id)
    {
        // Items del product backlog activos
        $backlog = DB::table('product_backlog')
            ->where('id_proyecto', $id)
            ->where('estado', 1)
            ->get();

        $equipo = DB::table('miembros_equipos as me')
            ->join('users as u', 'u.id', '=', 'me.id_usuario')
            ->select(
                'me.id',
                'me.id_proyecto',
                'me.id_usuario',
                'me.id_rol',
                'me.estado',
                DB::raw("CONCAT(u.nombre, ' ', u.apellido) as nombre_completo")
            )
            ->where('me.id_proyecto', $id)
            ->where('me.estado', 1)
            ->get();

        $sprints = DB::table('sprints')
            ->where('id_proyecto', $id)
            ->where('estado', 1)
            ->get();



        return response()->json([
            'backlog' => $backlog,
            'equipo' => $equipo,
            'sprints' => $sprints
        ]);
    }

    public function startSprint(Request $request, $uid, $sprintUid)
    {
        $request->validate([
            'fecha_inicio' => ['required','date'],
            'fecha_fin'    => ['required','date','after_or_equal:fecha_inicio'],
        ]);

        try {
            // Proyecto
            $proyecto = DB::table('proyectos')->where('uid', $uid)->first();
            if (!$proyecto) {
                return response()->json(['success'=>false,'message'=>'Proyecto no encontrado.'], 404);
            }

            // Sprint dentro del proyecto (ajusta columna id_proyecto/proyecto_id según tu esquema)
            $sprint = DB::table('sprints')
                ->where('uid', $sprintUid)
                ->where(function($q) use ($proyecto) {
                    $q->where('id_proyecto', $proyecto->id);
                })
                ->first();

            if (!$sprint) {
                return response()->json(['success'=>false,'message'=>'Sprint no encontrado.'], 404);
            }

            // Validar que tenga Sprint Backlog
            $itemsCount = DB::table('sprint_backlog')->where('id_sprint', $sprint->id)->count();
            if ($itemsCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes iniciar un sprint sin Sprint Backlog asignado.'
                ], 422);
            }

            // Iniciar sprint (ajusta campos: estado/status, fecha_inicio/fin)
            DB::table('sprints')->where('id', $sprint->id)->update([
                'estado'       => 0,
                'progreso'     => 'iniciado',
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin'    => $request->fecha_fin,
                'updated_at'   => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sprint iniciado correctamente.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar el sprint.',
                'error'   => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }



}
