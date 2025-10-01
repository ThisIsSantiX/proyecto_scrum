<?php

namespace App\Http\Controllers;

use App\Models\CriteriosAceptacion;
use App\Models\ProductBacklog;
use Exception;
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
            $historia = ProductBacklog::where('uid', $historiaUid)->first();

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
    public function edit() {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uid)
    {
        try {
            //buscar el criterio
            $criterio = CriteriosAceptacion::where('uid', $uid)->first();
            if (!$criterio) {
                return response()->json([
                    "success" => false,
                    "message" => "El criterio no se encontro"
                ], 400);
            }
            //validación
            $validacionData = $request->validate(["descripcion" => "required|max:255|string"]);
            $criterio->update($validacionData);
            return response()->json([
                'success' => true,
                'message' => 'Criterio actualizado exitosamente',
                'criterio' => $criterio
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el criterio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uid)
    {
        try {
            $criterio = DB::table('criterios_aceptacion')
                        ->where('uid',$uid)
                        ->first();
            if(!$criterio){
                return response()->json([
                    "success"=>false,
                    "message"=>"No se encontro el criterio"
                ], 404);
            }

            DB::table('criterios_aceptacion')
                ->where('uid',$uid)
                ->update(['estado'=>0,'updated_at'=>now()]);

            return response()->json([
                'success'=>true,
                'message'=>'Criterio eliminado correctamente'
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el criterio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
