<?php

namespace App\Http\Controllers;

use App\Models\miembros_equipo;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            $miembros = Proyecto::with('usuario:id,nombre,apellido,email,foto_url')
                ->where('id_proyecto', $uid)
                ->get()
                ->map(function ($miembro) {
                    return [
                        'id'       => $miembro->usuario->id,
                        'nombre'   => $miembro->usuario->nombre,
                        'apellido' => $miembro->usuario->apellido,
                        'email'    => $miembro->usuario->email,
                        'foto_url' => ($miembro->usuario->foto_url && 
                            !Str::startsWith($miembro->usuario->foto_url, ['http://', 'https://']) &&
                                Storage::disk('public')->exists($miembro->usuario->foto_url))
                                ? asset('storage/' . $miembro->usuario->foto_url) // archivo local existe
                                : (Str::startsWith($miembro->usuario->foto_url, ['http://', 'https://'])
                                    ? $miembro->usuario->foto_url                  // URL externa
                                    : "https://ui-avatars.com/api/?name=" 
                                        . urlencode($miembro->usuario->nombre . ' ' . $miembro->usuario->apellido) 
                                        . "&background=random&color=fff"),   // Generar avatar  



                    ];
                });

            // Retornar también al propietario como objeto
            $propietario = [
                'id'       => $proyecto->propietario->id,
                'nombre'   => $proyecto->propietario->nombre,
                'apellido' => $proyecto->propietario->apellido,
                'email'    => $proyecto->propietario->email,
                'foto_url' => $proyecto->propietario->foto_url
                    ? asset('storage/' . $proyecto->propietario->foto_url)  // NOTA: "storage/" aquí
                    : "https://ui-avatars.com/api/?name=" . urlencode($proyecto->propietario->nombre . ' ' . $proyecto->propietario->apellido) . "&background=random&color=fff",

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
                    'users.nombre',
                    'users.apellido',
                    'users.email',
                    'users.foto_url',
                )
                ->get()
                ->map(function ($u) {
                    return [
                        'id'       => $u->id,
                        'nombre'   => $u->nombre,
                        'apellido' => $u->apellido,
                        'email'    => $u->email,
                       'foto_url' => ($u->foto_url && Storage::disk('public')->exists($u->foto_url))
    ? asset('storage/' . $u->foto_url)  // genera la URL pública correcta
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
