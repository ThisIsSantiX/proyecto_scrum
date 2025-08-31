<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SprintBacklog;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;

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
            'titulo' => 'required|string|max:255',
            'progreso' => 'required|string',
            'asignado_a' => 'required|array', // IDs de miembros_equipos
            'asignado_a.*' => 'integer'
        ]);

        try {
            DB::beginTransaction();

            // Insertamos el ítem del sprint backlog
            $sprintBacklogId = DB::table('sprint_backlog')->insertGetId([
                'id_sprint'       => $sprintId,
                'id_item_backlog' => $request->id_item_backlog,
                'titulo'          => $request->titulo,
                'estado'          => 1,
                'progreso'        => $request->progreso,
                'uid'             => Str::uuid(),
                'created_at'      => now(),
                'updated_at'      => now(),
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
    public function show($uid)
    {
        try {
            $items = DB::table('sprint_backlog as sb')
                ->select('sb.*')
                ->where('sb.id_proyecto', $uid)
                ->get();

            // Decodificar asignado_a y traer nombres
            $items->transform(function ($item) {
                $ids = json_decode($item->asignado_a, true) ?? [];
                $usuarios = DB::table('users')
                    ->whereIn('id', $ids)
                    ->select(DB::raw("CONCAT(name,' ',apellido) as nombre_completo"))
                    ->pluck('nombre_completo')
                    ->toArray();
                
                $item->responsables = implode(', ', $usuarios);
                return $item;
            });

            return response()->json($items);

        } catch (\Exception $e) {
            return response()->json([
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
}
