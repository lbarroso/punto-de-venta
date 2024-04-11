<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Product;
use App\Models\Docdeta;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ImporteLetra;
use Illuminate\Support\Facades\DB;

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
     * Guardar venta y actualizar stock
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $total = Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->sum('docimporte');

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
        $venta->pvfecha = now();
        $venta->ctecve = 1;
        $venta->pvtotal = $total;
        $venta->pvcash = $request->input('cash');
        $venta->user_id = Auth::user()->id;
        $venta->user_name = Auth::user()->name;
        $venta->pvtipopago = !empty($request->input('tipopago')) ? $request->input('tipopago') : 'efectivo';
        $venta->save();

        // Obtener el último ID insertado
        $ID = $venta->id;

        // guardar
        Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->update(['docord' => $ID]);

        // confirmar venta
        return redirect()->route('pvproducts.index')->with('docord', $ID);
    } // function

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function ventaTotal(Request $request)
    {
        $id = !empty($request->id) ? $request->id : 0;

        $total = Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', $id)
        ->sum('docimporte');
                
        if($request->ajax()) return response()->json(['total' => number_format($total,2)]);
        
        return $total;
    }

    /**
     * importe total
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function ventaCash(Request $request)
    {        
        $total = Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->sum('docimporte');

        $cash = $request->cash - $total;

        return response()->json(['cash' => number_format($cash,2) ]);
    }

    // ticket
    public function ticket(Request $request)
    {

        $id = !empty($request->id) ? $request->id : 0;

        $empresa = Empresa::find(1);

        $total = Docdeta::where('movcve', 51)
        ->where('docord', $id)
        ->sum('docimporte');

        $docdetas = Docdeta::where('movcve', 51)
        ->where('docord', $id)
        ->get();
        
        $articulos = Docdeta::where('docord', $id)->sum('doccant');

        $venta = Venta::find($id);

        return view('pventa.ticket', compact('docdetas','total','empresa','id','articulos','venta') );
    }

    // buscar producto
    public function buscar(Request $request)
    {
        $texto = !empty($request->texto) ? $request->texto : 'xxx';

        if($request->ajax()){

            $products = Product::select('id', 'artdesc', 'codbarras', 'stock', 'artprventa', 'artpesoum', 'artpesogrm')
            ->where(function ($query) use ($texto) {
                $query->where('artdesc', 'like', '%' . $texto . '%')
                    ->orWhere('codbarras', 'like', '%' . $texto . '%');
            })
            ->where('artstatus', 'A')
            ->orderBy('artdesc')
            ->get();     

            return response()->json(['data' => $products]);
        }
       
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
