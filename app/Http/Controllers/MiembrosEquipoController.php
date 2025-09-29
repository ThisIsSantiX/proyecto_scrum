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
    public function getMiembros($uid)
    {
        try {
            // Buscar proyecto
            $proyecto = Proyecto::where('uid', $uid)->firstOrFail();

            // Traer miembros con la relación usuario
            $miembros = Proyecto::with('usuario:id,username,email,foto_url')
                ->where('id_proyecto', $uid)
                ->get()
                ->map(function ($miembro) {
                    return [
                        'id'       => $miembro->usuario->id,
                        'username'   => $miembro->usuario->username,
                        'email'    => $miembro->usuario->email,
                        'foto_url' => $miembro->usuario->foto_url
                            ? asset('storage/' . $miembro->usuario->foto_url)   // ✅ URL pública
                            : null,
                    ];
                });

            // Retornar también al propietario como objeto
            $propietario = [
                'id'       => $proyecto->propietario->id,
                'username'   => $proyecto->propietario->username,
                'email'    => $proyecto->propietario->email,
                'foto_url' => $proyecto->propietario->foto_url 
                    ? asset('storage/' . $proyecto->propietario->foto_url) 
                    : null,
                'rol'      => 'propietario',
            ];

            return response()->json([
                'success'     => true,
                'propietario' => $propietario,
                'miembros'    => $miembros,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($proyectoUid)
    {
        try {
            $proyecto = proyecto::where('uid', $proyectoUid)->first();
            if (!$proyecto) {
                return response()->json([
                    "message" => "No se encontro el proyecto"
                ], 404);
            }

            $miembros = DB::table('miembros_equipos')
                ->join('users', 'miembros_equipos.id_usuario', '=', 'users.id')
                ->join('proyectos', 'miembros_equipos.id_proyecto', '=', 'proyectos.id')
                ->where('proyectos.uid', $proyectoUid)
                ->select(
                    'users.id',
                    'users.username',
                    'users.email',
                    'users.foto_url',
                )
                ->get()
                ->map(function ($u) {
                    return [
                        'id'       => $u->id,
                        'username'   => $u->username,
                        'email'    => $u->email,
                        'foto_url' => $u->foto_url
                            ? asset('storage/' . $u->foto_url) 
                            : "https://ui-avatars.com/api/?name=" 
                                . urlencode($u->nombre . ' ' . $u->apellido) 
                                . "&background=random&color=fff",
                    ];
                });

            return response()->json([
                "miembros" => $miembros
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error: " . $e->getMessage()
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
