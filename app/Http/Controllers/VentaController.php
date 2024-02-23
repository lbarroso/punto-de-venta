<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Product;
use Illuminate\Http\Request;

class VentaController extends Controller
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

        $total = Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->sum('importe'); 
        
        if($total <= 0 ) return redirect()->route('pvproducts.index', ['docord' => 0]);

        // Actualizar el stock de los productos vendidos
        $docdetas = Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->get();

        foreach ($docdetas as $docdeta) {
            $product = Product::find($docdeta->product_id);
            if ($product) {
                // Restar la cantidad vendida del stock
                $product->stock -= $docdeta['doccant'];
                $product->save();
            }
        }

        // guardar venta registrada
        $venta = new Venta();        
        $venta->fecha = now();
        $venta->ctecve = 1;
        $venta->pvtotal = $total;
        $venta->pvcash = $request->input('pvcash');
        $venta->user_id = Auth::user()->id;
        $venta->pvtipopago = $request->input('pvtipopago');
        $venta->save();

        // Obtener el último ID insertado
        $ID = $venta->id;

        // guardar
        Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->update(['docord' => $ID]);

        return redirect()->route('pvproducts.index', ['docord' => $ID]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
