<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\Daily_scrum;

class DailyScrumController extends Controller
{
    public function index()
    {
        try {
            $dailies = Daily_scrum::with(['proyecto:id,id,nombre', 'sprint:id,id,nombre'])
                ->where('estado', 1)
                ->get();

            // Mapear para incluir los nombres directamente
            $dailies = $dailies->map(function($daily) {
                return [
                    'uid' => $daily->uid,
                    'fecha' => $daily->fecha,
                    'duracion' => $daily->duracion,
                    'URL' => $daily->URL,
                    'id_proyectos' => $daily->id_proyectos,
                    'id_sprints' => $daily->id_sprints,
                    'observaciones' => $daily->observaciones,
                    'bloqueos_detectados' => $daily->bloqueos_detectados,
                    'acuerdos' => $daily->acuerdos,
                    'proyecto_nombre' => $daily->proyecto ? $daily->proyecto->nombre : null,
                    'sprint_nombre' => $daily->sprint ? $daily->sprint->nombre : null,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $dailies
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las reuniones.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fecha' => 'required|date',
                'duracion' => 'required|integer|min:1',
                'URL' => 'nullable|url',
                'id_proyectos' => 'required|exists:proyectos,id',
                'id_sprints' => 'required|exists:sprints,id',
                'observaciones' => 'nullable|string',
                'bloqueos_detectados' => 'nullable|string',
                'acuerdos' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $daily = Daily_scrum::create([
                'fecha' => $request->fecha,
                'duracion' => $request->duracion,
                'URL' => $request->URL,
                'id_proyectos' => $request->id_proyectos,
                'id_sprints' => $request->id_sprints,
                'observaciones' => $request->observaciones,
                'bloqueos_detectados' => $request->bloqueos_detectados,
                'acuerdos' => $request->acuerdos,
                'estado' => 1,
                'uid' => uniqid()
            ]);

            // Cargar las relaciones
            $daily->load(['proyecto', 'sprint']);

            return response()->json([
                'success' => true,
                'message' => 'Reunión creada correctamente',
                'data' => $daily
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la reunión.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($uid)
    {
        try {
            $daily = Daily_scrum::with(['proyecto', 'sprint'])
                ->where('uid', $uid)
                ->where('estado', 1)
                ->first();

            if (!$daily) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la reunión'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $daily
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la reunión.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit()
    {
        //
    }

    public function update(Request $request, $uid)
    {
        try {
            $daily = Daily_scrum::where('uid', $uid)
                ->where('estado', 1)
                ->first();

            if (!$daily) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la reunión'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'fecha' => 'required|date',
                'duracion' => 'required|integer|min:1|max:15',
                'URL' => 'nullable|url',
                'id_proyectos' => 'required|exists:proyectos,id',
                'id_sprints' => 'required|exists:sprints,id',
                'observaciones' => 'nullable|string',
                'bloqueos_detectados' => 'nullable|string',
                'acuerdos' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $daily->update([
                'fecha' => $request->fecha,
                'duracion' => $request->duracion,
                'URL' => $request->URL,
                'id_proyectos' => $request->id_proyectos,
                'id_sprints' => $request->id_sprints,
                'observaciones' => $request->observaciones,
                'bloqueos_detectados' => $request->bloqueos_detectados,
                'acuerdos' => $request->acuerdos
            ]);

            // Recargar el modelo con las relaciones
            $daily->load(['proyecto', 'sprint']);

            return response()->json([
                'success' => true,
                'message' => 'Reunión actualizada correctamente',
                'data' => $daily
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la reunión.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($uid)
    {
        try {
            $daily = Daily_scrum::where('uid', $uid)
                ->where('estado', 1)
                ->first();

            if (!$daily) {
                return response()->json([
                    "success" => false,
                    "message" => "No se encontró la reunión"
                ], 404);
            }

            $daily->update([
                'estado' => 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reunión eliminada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la reunión.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
