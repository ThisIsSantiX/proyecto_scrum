<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
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

        $query = Proyecto::select(
                'proyectos.*',
                'users.nombre as usuario_nombre',
                'users.email as usuario_email'
            )
            ->leftJoin('users', 'proyectos.id_owner', '=', 'users.id')
            ->where('proyectos.estado', 1)
            ->where('proyectos.id_owner', $userId); 

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('proyectos.nombre', 'LIKE', '%' . $request->search . '%')
                ->orWhere('users.nombre', 'LIKE', '%' . $request->search . '%');
            });
        }

        $proyectos = $query->get();
        
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
                'descripcion' => 'nullable|string|max:255',
                'fecha_inicio' => 'nullable|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'visibilidad' => 'required|integer|in:0,1'
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
            $proyecto = Proyecto::select(
                    'proyectos.*',
                    'users.nombre as usuario_nombre',
                    'users.email as usuario_email'
                )
                ->leftJoin('users', 'proyectos.id_owner', '=', 'users.id')
                ->where('proyectos.uid', $uid)
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

}
