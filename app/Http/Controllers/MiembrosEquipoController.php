<?php

namespace App\Http\Controllers;

use App\Models\miembros_equipo;
use App\Models\proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiembrosEquipoController extends Controller
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
    public function store(Request $request)
    {
        // lógica para guardar el recurso
    }

    // Método para mostrar un recurso específico
    public function show($proyectoUid)
    {
        try{
            $proyecto = proyecto::where('uid',$proyectoUid);
            if(!$proyecto){
                return response()->json([
                    "message"=>"No se encontro el proyecto"
                ],404);
            }

            $miembros = DB::table('miembros_equipos')
                        ->join('users','miembros_equipos.id_usuario','=','users.id')
                        ->join('proyectos','miembros_equipos.id_proyecto','=','proyectos.id')
                        ->where('proyectos.uid',$proyectoUid)
                        ->select(
                            'users.id',
                            'users.nombre',
                            'users.apellido',
                            'users.email',
                            'users.foto_url',
                        )
                        ->get();

            return response()->json([
                "miembros"=>$miembros
            ]);

        }catch(\Exception $e){
            return response()->json([
                "message"=>"Error: ".$e->getMessage()
            ]);
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
