<?php

namespace App\Http\Controllers;

use App\Models\CriteriosAceptacion;
use App\Models\product_backlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CriteriosAceptacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $historiaUid)
    {
        try {
            $historia = product_backlog::where('uid', $historiaUid)->first();

            if (!$historia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Historia no encontrada'
                ], 404);
            }

            $criterio = new CriteriosAceptacion();
            $criterio->id_item_backlog = $historia->id;
            $criterio->descripcion = $request->descripcion;
            $criterio->estado = 1; 
            $criterio->uid = Str::uuid();
            $criterio->save();

            return response()->json([
                'success' => true,
                'message' => 'Criterio creado correctamente',
                'criterio' => $criterio
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el criterio',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(CriteriosAceptacion $criteriosAceptacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CriteriosAceptacion $criteriosAceptacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CriteriosAceptacion $criteriosAceptacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CriteriosAceptacion $criteriosAceptacion)
    {
        //
    }
}
