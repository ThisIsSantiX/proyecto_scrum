<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\proyecto_invitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ProyectoReciente;

class ProyectoController extends Controller
{
    /**
     * Mostrar listado de proyectos
     */
    public function index()
    {
        return view('pages.proyectos.index');
    }
    /**
     * Guardar proyecto en BD
     */
    // Función show (ya actualizada)
    public function show(Request $request)
    {
        $userId = auth()->id();

        $query = DB::table('proyectos')
            ->select(
                'proyectos.*',
                'users.username as usuario_username',
                'users.email as usuario_email'
            )
            ->leftJoin('users', 'proyectos.id_owner', '=', 'users.id')
            ->leftJoin('miembros_equipos', 'proyectos.id', '=', 'miembros_equipos.id_proyecto')
            ->where('proyectos.estado', 1)
            ->where(function($q) use ($userId) {
                $q->where('proyectos.id_owner', $userId)
                ->orWhere('miembros_equipos.id_usuario', $userId);
            });

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('proyectos.nombre', 'LIKE', '%' . $request->search . '%')
                ->orWhere('users.username', 'LIKE', '%' . $request->search . '%');
            });
        }

        $proyectos = $query->distinct()->get();

        return response()->json([
            'success' => true,
            'data' => $proyectos
        ]);
    }



    // Función store
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:50',
            ], [
                'nombre.required' => 'El nombre del proyecto es obligatorio.',
                'nombre.max' => 'El nombre del proyecto no debe exceder los 50 caracteres.'
            ]);

            $proyecto = new Proyecto();
            $proyecto->nombre = $request->nombre;
            $proyecto->descripcion = $request->descripcion;
            $proyecto->id_owner = auth()->id(); // Usuario autenticado
            $proyecto->estado = 1; // Activo por defecto
            $proyecto->uid = Str::uuid(); // Generar UUID único
            $proyecto->visibilidad = $request->visibilidad;
            $proyecto->progreso = $request->progreso;
            $proyecto->fecha_inicio = $request->fecha_inicio;
            $proyecto->fecha_fin = $request->fecha_fin;

            $proyecto->save();

            return response()->json([
                'success' => true,
                'message' => 'Proyecto creado exitosamente',
                'data' => $proyecto
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }

    // Función detailsProyecto
    public function detailsProyecto($uid)
    {
        try {
            $proyecto = DB::table('proyectos')
                ->leftJoin('users', 'proyectos.id_owner', '=', 'users.id')
                ->leftJoin('product_backlog', function($join) {
                    $join->on('proyectos.id', '=', 'product_backlog.id_proyecto')
                        ->where('product_backlog.estado', '=', 1);
                })
                ->leftJoin('sprints', function($join) {
                    $join->on('proyectos.id', '=', 'sprints.id_proyecto')
                        ->where('sprints.estado', '=', 1);
                })
                ->select(
                    'proyectos.*',
                    'users.username as usuario_username',
                    'users.email as usuario_email',
                    DB::raw('COUNT(DISTINCT product_backlog.id) as total_elementos'),
                    DB::raw('COUNT(DISTINCT sprints.id) as total_sprints')
                )
                ->where('proyectos.uid', $uid)
                ->groupBy(
                    'proyectos.id',
                    'proyectos.uid',
                    'proyectos.nombre',
                    'proyectos.descripcion',
                    'proyectos.id_owner',
                    'proyectos.estado',
                    'proyectos.visibilidad',
                    'proyectos.progreso',
                    'proyectos.fecha_inicio',
                    'proyectos.fecha_fin',
                    'proyectos.created_at',
                    'proyectos.updated_at',
                    'users.username',
                    'users.email'
                )
                ->first();

            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $proyecto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }


    // Función edit
    public function edit($uid)
    {
        try {
            $proyecto = Proyecto::where('uid', $uid)->first();

            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $proyecto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }

    // Función update
    public function update(Request $request)
    {
        try {
            $request->validate([
                'uid' => 'required|exists:proyectos,uid', // Validamos uid
                'nombre' => 'required|string|max:50',
                'descripcion' => 'nullable|string|max:255',
                'fecha_inicio' => 'nullable|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'visibilidad' => 'required|integer|in:0,1',
                'progreso' => 'nullable|string|max:20'
            ]);

            // Buscar proyecto por uid
            $proyecto = Proyecto::where('uid', $request->uid)->firstOrFail();

            // Verificar permisos
            if ($proyecto->id_owner != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para editar este proyecto'
                ], 403);
            }

            // Actualizar campos
            $proyecto->nombre = $request->nombre;
            $proyecto->descripcion = $request->descripcion;
            $proyecto->visibilidad = $request->visibilidad;
            $proyecto->progreso = $request->progreso ?? $proyecto->progreso;
            $proyecto->fecha_inicio = $request->fecha_inicio;
            $proyecto->fecha_fin = $request->fecha_fin;

            $proyecto->save();

            return response()->json([
                'success' => true,
                'message' => 'Proyecto actualizado exitosamente',
                'data' => $proyecto
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }


    // Función destroy
    public function destroy($uid)
    {
        try {
            // Buscar proyecto por uid
            $proyecto = Proyecto::where('uid', $uid)->firstOrFail();

            // Verificar que el usuario tenga permisos para eliminar
            if ($proyecto->id_owner != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para eliminar este proyecto'
                ], 403);
            }

            // Soft delete - cambiar estado a 0 en lugar de eliminar físicamente
            $proyecto->estado = 0;
            $proyecto->save();

            // O si prefieres eliminación física:
            // $proyecto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proyecto eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proyecto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function board()
    {
        return view('pages.proyectos.backlog.board.index');
    }

    public function enviarInvitacion(Request $request, $idProyecto)
    {
        $request->validate(
            [
                "email" => "required|email|exists:users,email"
            ],
            [
                "email.required" => "Ingrese un correo.",
                "email.email" => "Ingrese un correo valido.",
                "email.exists" => "El correo electronico no existe."
            ]
        );
        DB::beginTransaction();
        try {
            $proyecto = Proyecto::findOrFail($idProyecto);

            $usuarioActual = Auth::user();
            // $tienePermisos = DB::table('miembros_equipo')
            //     ->where('id_proyecto',$idProyecto)
            //     ->where('id_usuario', $usuarioActual->id)
            //     ->where('id_rol',);

            $usuarioInvitado = User::where('email', $request->email)->first();

            $yaEsMiembro = DB::table('miembros_equipos')
                ->where('id_proyecto', $idProyecto)
                ->where('id_usuario', $usuarioInvitado->id)
                ->exists();
            if ($yaEsMiembro) {
                return response()->json([
                    "message" => "El usuario ya es miembro del proyecto"
                ], 400);
            }

            $invitacionPendiente = proyecto_invitaciones::where('proyecto_id', $idProyecto)
                ->where('usuario_invitado', $usuarioInvitado->id)
                ->where('estadoInvitacion', 'pendiente')
                ->where(function ($q) {
                    $q->whereNull('expira_en')
                        ->orWhere('expira_en', '>', now());
                })
                ->exists();

            if ($invitacionPendiente) {
                return response()->json([
                    'message' => 'El usuario ya tiene una invitacion pendiente para este proyecto'
                ], 400);
            }

            $invitacion = proyecto_invitaciones::create([
                'proyecto_id' => $idProyecto,
                'invitado_por' => $usuarioActual->id,
                'usuario_invitado' => $usuarioInvitado->id,
                'estadoInvitacion' => 'pendiente',
                'uid' => Str::uuid(),
                'estado' => 1,
                'expira_en' => now()->addDays(7)
            ]);

            Db::commit();

            return response()->json([
                'message' => 'Invitacion enviada exitosamente',
                'invitacion' => [
                    'usuario' => $usuarioInvitado->username,
                    'email' => $usuarioInvitado->email,
                    'proyecto' => $proyecto->nombre
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Error: " . $e->getMessage()
            ]);
        }
    }

    //obtener invitaciones
    public function misInvitaciones()
    {
        try {
            $user = Auth::user();

            $invitaciones = proyecto_invitaciones::with(['proyecto', 'invitadoPor'])
                ->where('usuario_invitado', $user->id)
                ->pendientes()
                ->orderBy('created_at', 'desc')
                ->get();

            // Agregar información adicional del proyecto
            $invitaciones->each(function ($invitacion) {
                $invitacion->proyecto->makeHidden(['created_at', 'updated_at']);
                $invitacion->invitadoPor->makeHidden(['created_at', 'updated_at']);
            });

            return response()->json([
                'invitaciones' => $invitaciones
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error: ' . $e->getMessage()
            ], 500);
        }
    }

    //responder a las invitaciones
    public function responderInvitacion(Request $request, $uid)
    {
        $request->validate([
            'accion' => 'required|in:aceptar,rechazar'
        ]);

        Db::beginTransaction();
        try {
            $user = Auth::user();

            $invitacion = proyecto_invitaciones::where('uid', $uid)
                ->where('usuario_invitado', $user->id)
                ->where('estadoInvitacion', 'pendiente')
                ->first();

            if (!$invitacion) {
                return response()->json([
                    'message' => 'La invitacion no encontrada o ya procesada'
                ], 404);
            }

            if ($invitacion->estaVencida()) {
                return response()->json([
                    'message' => 'La invitación ha expirado'
                ], 400);
            }

            if ($request->accion === 'aceptar') {
                $yaEsMiembro = DB::table('miembros_equipos')
                    ->where('id_proyecto', $invitacion->id_proyecto)
                    ->where('id_usuario', $user->id)
                    ->exists();
                if (!$yaEsMiembro) {
                    //agregamos el usuario al proyecto
                    DB::table('miembros_equipos')->insert([
                        'id_usuario' => $user->id,
                        'estado' => 1,
                        'uid' => Str::uuid(),
                        'id_proyecto' => $invitacion->proyecto_id
                    ]);
                }
                $invitacion->estadoInvitacion = 'aceptada';
                $mensaje = 'Te has unido al proyecto exitosamente';
            } else {
                $invitacion->estadoInvitacion = 'rechazada';
                $mensaje = 'Invitacion rechazada';
            }

            $invitacion->save();
            DB::commit();

            return response()->json([
                'message' => $mensaje,
                'proyecto' => $invitacion->proyecto->nombre
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'error: ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function proyectosRecientes()
    {
        try {
            $proyectos = ProyectoReciente::with(['propietario', 'miembros.usuario'])
                ->recientes()
                ->take(5) // últimos 5 proyectos
                ->get();

            return response()->json([
                'success' => true,
                'data' => $proyectos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener proyectos recientes: ' . $e->getMessage()
            ], 500);
        }  
    }

}
