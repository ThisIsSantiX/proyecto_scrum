<?php

namespace App\Http\Controllers;
use App\Models\roles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    // Método para mostrar una lista de recursos
    public function index()
    {
        $roles = Roles::all();
        return view('pages.roles.index', compact('roles'));

    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        
    }

    // Método para guardar un nuevo recurso
    public function store(Request $request)
            {
                $request->validate([
                    'nombre' => 'required|string|max:50',
                    'estado' => 'required|in:0,1',
                ]);

                try {
                    DB::transaction(function () use ($request) {
                        Roles::create([
                            'nombre' => $request->nombre,
                            'estado' => (int)$request->estado,
                            'uid'    => Str::uuid(),
                        ]);
                    });
                } catch (\Exception $e) {
                    Log::error('Error Al Crear El Rol: ' . $e->getMessage());
                    return back()->withErrors('Ocurrió Un Error Al Crear El Rol. Por favor, Inténtelo De Nuevo.');
                }

                return redirect()->route('roles.index')
                    ->with('success', 'Rol Creado Correctamente.');
            }

    // Método para mostrar un recurso específico
    public function show( Request $request)
        {
            $query = Roles::where('estado', 1);

                // Filtro de búsqueda
                if ($request->has('search') && !empty($request->search)) {
                    $query->where('nombre', 'LIKE', '%' . $request->search . '%');
                }

                // Paginación: 5 roles por página
                $roles = $query->paginate(5);

                return response()->json($roles);
        }

    // Método para mostrar el formulario de edición
    public function edit($id)
        {
            // $roles = Roles::where('uid', $id)->firstOrFail();
            // return response()->json($roles);
        }

    // Método para actualizar un recurso existente
    public function update(Request $request, $uid)
        {
            $roles = Roles::where('uid', $uid)->firstOrFail();
            $request->validate([
                'nombre' => 'required|string|max:50',
            ]);
            $roles->update([
                'nombre' => $request->nombre,
            ]);
            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
        }

    // Método para eliminar un recurso
    public function destroy($uid)
        {
            $roles = Roles::where('uid', $uid)->first();

            if (!$roles) {
                return response()->json(['success' => false, 'error' => 'Rol No Encontrado.']);
            }

            $roles->estado = 0;
            $roles->save();

            return response()->json(['success' => true]);
        }

        public function showRoles()
        {
            $roles = roles::where('estado', 1)->get(); 
            return response()->json($roles);
        }
}
