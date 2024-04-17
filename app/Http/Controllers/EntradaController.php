<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Docdeta;
use App\Models\Entrada;
use Illuminate\Support\Facades\Auth;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        date_default_timezone_set('America/Mexico_City');
        
        $total = Docdeta::where('movcve', 52)        
        ->where('docord', 0)
        ->sum('docimporte');

        if($total <= 0 ) return redirect()->route('entrada.index');

        // Actualizar stock de productos
        $docdetas = Docdeta::where('movcve', 52)
        ->where('docord', 0)
        ->get();

        foreach ($docdetas as $docdeta) {
            $product = Product::find($docdeta->product_id);
            if ($product) {
                // Sumar la cantidad agregada del stock
                $product->stock += $docdeta['doccant'];
                $product->save();
            }
        }        

        // guardar entrada
        $entrada = new Entrada();
        $entrada->fecha = now();
        $entrada->prvcve = 1;
        $entrada->total = $total;
        $entrada->comentarios = "comentarios";
        $entrada->save();
        
        // último ID insertado
        $ID = $entrada->id;

        // relacionar
        Entrada::where('movcve', 52)
        ->where('docord', 0)
        ->update(['docord' => $ID]);        

        // EntradaController@index
        return redirect()->route('entrada.index')->with('docord', $ID);


    } // store

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
