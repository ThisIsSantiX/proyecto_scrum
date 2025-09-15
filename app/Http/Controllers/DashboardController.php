<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $now = Carbon::now('America/Bogota');

        $fecha = $now->locale('es')->isoFormat('dddd, D [de] MMMM');
        $fecha = mb_convert_case($fecha, MB_CASE_TITLE, "UTF-8");

        $hora = $now->hour;

        if ($hora >= 6 && $hora < 12) {
            $saludo = "Buenos días";
        } elseif ($hora >= 12 && $hora < 19) {
            $saludo = "Buenas tardes";
        } else {
            $saludo = "Buenas noches";
        }


        return view('pages.dashboard.index', compact('fecha', 'saludo'));
    }

    public function getProyectos()
    {
        $userId = Auth::id();

        $proyectos = DB::table('proyectos')
            ->leftJoin('product_backlog', function($join) {
                $join->on('proyectos.id', '=', 'product_backlog.id_proyecto')
                    ->where('product_backlog.estado', '=', 1);
            })
            ->leftJoin('sprints', function($join) {
                $join->on('proyectos.id', '=', 'sprints.id_proyecto')
                    ->where('sprints.estado', '=', 1);
            })
            ->leftJoin('miembros_equipos', 'proyectos.id', '=', 'miembros_equipos.id_proyecto')
            ->select(
                'proyectos.id',
                'proyectos.uid',
                'proyectos.nombre as proyecto',
                DB::raw('COUNT(DISTINCT product_backlog.id) as total_elementos'),
                DB::raw('COUNT(DISTINCT sprints.id) as total_sprints')
            )
            ->where(function($q) use ($userId) {
                $q->where('proyectos.id_owner', $userId)
                ->orWhere('miembros_equipos.id_usuario', $userId);
            })
            ->where('proyectos.estado', 1)
            ->groupBy('proyectos.id', 'proyectos.uid', 'proyectos.nombre')
            ->get();

        return response()->json($proyectos);

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
