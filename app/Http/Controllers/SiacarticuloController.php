<?php

namespace App\Http\Controllers;

use App\Models\Siacarticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiacarticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articulos = DB::connection('pgsql')->select(" SELECT * FROM articulos WHERE artcve=201020");             
        dd($articulos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siacarticulo  $siacarticulo
     * @return \Illuminate\Http\Response
     */
    public function show(Siacarticulo $siacarticulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siacarticulo  $siacarticulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Siacarticulo $siacarticulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siacarticulo  $siacarticulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siacarticulo $siacarticulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siacarticulo  $siacarticulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siacarticulo $siacarticulo)
    {
        //
    }
}
