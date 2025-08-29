<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;

class SprintController extends Controller
{

    private $estados = [
        'planificado' => 0,
        'activo'      => 1,
        'completado'  => 2,
        'cancelado'   => 3,
    ];
    
    // Método para mostrar una lista de recursos
    public function index()
    {
        // lógica para mostrar todos los elementos
        $sprints = Sprint::all(); 
        return view('pages.sprints.index', compact('sprints')); 
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        // lógica para mostrar el formulario
        return view('pages.sprints.create'); 
    }

    // Método para guardar un nuevo recurso
    public function store(Request $request)
    {
        // lógica para guardar el recurso
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'objetivo'     => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio', 
            'progreso'     => 'required|string',
            'estado'       => 'required|in:planificado,activo,completado,cancelado', 
            'id_proyecto'  => 'required|integer|exists:proyectos,id',
        ]);

        Sprint::create([
            'nombre'       => $request->nombre,
            'objetivo'     => $request->objetivo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'progreso'     => $request->progreso,
            'estado'       => $this->estados[$request->estado],
            'id_proyecto'  => $request->id_proyecto,
            'uid'          => uniqid("spr_"),
        ]);

        return redirect()->route('sprints.index')->with('success', 'Sprint creado correctamente.');
    }

    // Método para mostrar un recurso específico
    public function show($id)
    {
        // lógica para mostrar un solo elemento
        $sprint = Sprint::findOrFail($id);
        return view('pages.sprints.detalle', compact('sprint'));
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        // lógica para mostrar el formulario de edición
        $sprint = Sprint::findOrFail($id); 
        return view('pages.sprints.edit', compact('sprint'));
    }

    // Método para actualizar un recurso existente
    public function update(Request $request, $id)
    {
        // lógica para actualizar el recurso
        $sprint = Sprint::findOrFail($id); 

        $request->validate([
            'nombre'       => 'required|string|max:100',
            'objetivo'     => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'progreso'     => 'required|string',
            'estado'       => 'required|in:planificado,activo,completado,cancelado',
            'id_proyecto'  => 'required|integer|exists:proyectos,id',
        ]);

        $sprint->update([
            'nombre'       => $request->nombre,
            'objetivo'     => $request->objetivo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'progreso'     => $request->progreso,
            'estado'       => $this->estados[$request->estado],
            'id_proyecto'  => $request->id_proyecto,
        ]);

        return redirect()->route('sprints.index')->with('success', 'Sprint actualizado correctamente.');
    }

    // Método para eliminar un recurso
    public function destroy($id)
    {
        // lógica para eliminar el recurso
        $sprint = Sprint::findOrFail($id);

        return redirect()->route('sprints.index')->with('success', 'Sprint eliminado correctamente.');
    }
}
