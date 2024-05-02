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
        $entrada->prvcve = $request->input('prvcve');
        $entrada->total = $total;
        $entrada->comentarios = $request->input('comentarios');
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


}
