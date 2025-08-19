<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    
    public function index()
    {
        
        $proyectos = \App\Models\Proyecto::all(); 
        return view('pages.proyectos.index', compact('proyectos'));
    }

    public function create()
    {
       
        return view('pages.proyectos.create');
        

    }

    // Método para guardar un nuevo recurso
    public function store(Request $request)
    {
        // lógica para guardar el recurso
    }

    // Método para mostrar un recurso específico
    public function show($id)
    {
        // lógica para mostrar un solo elemento
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
