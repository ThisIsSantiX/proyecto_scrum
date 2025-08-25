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
        $proyectos = Proyecto::all();
        return view('pages.proyectos.index', compact('proyectos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
         $users = User::all(); // Lista de usuarios para asignar como responsable
        return view('pages.proyectos.create', compact('users'));
    }

    /**
     * Guardar proyecto en BD
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:100',
            'descripcion'   => 'required|string',
            'id_owner'      => 'required|exists:users,id',
            'estado'        => 'required|in:activo,inactivo',
            'visibilidad'   => 'required|in:publico,privado',
            'progreso'      => 'nullable|numeric|min:0|max:100',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Proyecto::create([
                    'nombre'        => $request->nombre,
                    'descripcion'   => $request->descripcion,
                    'id_owner'      => $request->id_owner,
                    'estado'        => $request->estado === 'activo' ? 1 : 0,
                    'visibilidad'   => $request->visibilidad,
                    'progreso'      => $request->progreso ?? 0,
                    'fecha_inicio'  => $request->fecha_inicio,
                    'fecha_fin'     => $request->fecha_fin,
                    'uid'           => Str::uuid(),
                ]);
            });

            return redirect()->route('proyectos.index')
                ->with('success', 'Proyecto creado correctamente.');
        } catch (\Throwable $e) {
            Log::error('[store Proyecto] Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo crear el proyecto, inténtalo de nuevo.']);
        }
    }

    /**
     * Mostrar un proyecto especifico
     */
    public function show(Request $request)
    {
        $proyectos = Proyecto::where('estado', 1)->paginate(5);
        return response()->json($proyectos);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        return view('pages.proyectos.edit', compact('proyecto'));
    }

    /**
     * Actualizar proyecto en BD
     */
    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);

        $request->validate([
            'nombre'        => 'required|string|max:100',
            'descripcion'   => 'required|string',
            'id_owner'      => 'required|exists:users,id',
            'estado'        => 'required|in:activo,inactivo',
            'visibilidad'   => 'required|in:publico,privado',
            'progreso'      => 'nullable|numeric|min:0|max:100',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $data = $request->all();

        $data['estado'] = $request->estado === 'activo' ? 1 : 0;

        $proyecto->update($data);

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto actualizado correctamente.');
    }

   
    public function destroy($uid)
    {
        $proyecto = Proyecto::where('uid', $uid)->first();

        if (!$proyecto) {
            return response()->json(['success' => false, 'error' => 'Proyecto no encontrado.']);
        }

        $proyecto->estado = 0;
        $proyecto->save();

        return response()->json(['success' => true]);
    }
    
}
