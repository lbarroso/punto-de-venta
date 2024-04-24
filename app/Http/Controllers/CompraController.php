<?php

namespace App\Http\Controllers;
use App\Models\Compra;
use App\Models\Product;
use App\Models\Empresa;
use App\Models\Docdeta;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CompraController extends Controller
{

    /**
     * Display a listing of purchases within a specified date range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        $docord = !empty($request->session()->get('docord')) ? $request->session()->get('docord') : 0;

        if($request->fecha_inicio){

            $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);

            $compras = Compra::join('proveedores', 'compras.prvcve', '=', 'proveedores.id')
            ->whereBetween('compras.fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->orderBy('compras.created_at', 'desc')
            ->select('compras.*', 'proveedores.prvrazon as proveedor') // ejemplo de selección de columnas
            ->get();
            $total = Compra::whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])->sum('total');

        }else{

            $compras = Compra::join('proveedores', 'compras.prvcve', '=', 'proveedores.id')
            ->whereDate('compras.created_at', now()->toDateString())
            ->orderBy('compras.created_at', 'desc')
            ->select('compras.*', 'proveedores.prvrazon as proveedor') // ejemplo de selección de columnas
            ->get();

            $total = Compra::whereDate('created_at', now()->toDateString())->sum('total');
        }

        return view('compras.index', compact('compras','total'));

    } // 

    /**
     * Store a newly created purchase in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');

        $count = Docdeta::where('movcve', 52)->where('docord', 0)->count();

        if($count <= 0) return redirect()->route('compras.index');

        $request->validate([
            'fecha' => 'required|date',
            'prvcve' => 'required',
            'comentarios' => 'nullable|string'
        ]);

        $total = Docdeta::where('movcve', 52)
        ->where('docord', 0)
        ->sum('docimporte');
                
        // Actualizar el stock de los productos
        $docdetas = Docdeta::where('movcve', 52)
        ->where('docord', 0)
        ->get();

        // Actualizar stock de los productos
        foreach ($docdetas as $docdeta) {
            $product = Product::find($docdeta->product_id);
            // Sumar la cantidad al stock
            $product->increment('stock', $docdeta['doccant']);
        }

        // Guardar la compra
        $compra = new Compra();
        $compra->prvcve =$request->input('prvcve'); 
        $compra->fecha = $request->input('fecha');
        $compra->factura = $request->input('factura');
        $compra->total = $total;
        $compra->comentarios = $request->input('comentarios');
        $compra->user_name = Auth::user()->name;
        $compra->save();

        // last id
        $ID = $compra->id;

        // actualizar relacion
        Docdeta::where('movcve', 52)        
        ->where('docord', 0)
        ->update(['docord' => $ID]);        

        return redirect()->route('compras.index')->with('success', 'Compra guardada correctamente.');
    }

    // Entrada PDF
    function pdf(Request $request)
    {

        $docdetas = Docdeta::where('movcve', 52)
        ->where('docord', $request->id)
        ->get(); 

        $compra = Compra::find($request->id);

        $empresa = Empresa::find(1);

        $proveedor = Proveedor::find($compra->prvcve);

        return view('compras.pdf', compact('docdetas', 'compra','empresa','proveedor'));
    }


} // class
