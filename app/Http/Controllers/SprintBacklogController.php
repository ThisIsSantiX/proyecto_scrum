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
            'progreso' => 'required|string',
            // 'asignado_a' => 'required|array', // IDs de miembros_equipos
            // 'asignado_a.*' => 'integer'
        ]);

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
}
