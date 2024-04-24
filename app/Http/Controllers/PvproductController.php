<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Docdeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PvproductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docord = !empty($request->session()->get('docord')) ? $request->session()->get('docord') : 0;
        
        // datatable:pvproducts.js
        if($request->ajax()){
            return response()->json(['data' => Docdeta::where('movcve', 51)
            ->where('user_id', Auth::user()->id)
            ->where('docord', $docord)
            ->get() ]);
        }
        
        $appUrl = env('APP_URL');

        // Mostrar ventana emergente ticket
        return view('pventa.index', compact('docord','appUrl'));
    } // index

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
     * registrando codigos
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');
        
        $codigo = trim($request->codigo);

        if($codigo[0] == '+'){
            $docdeta = new Docdeta();
            $docdeta->artdesc = "PRODUCTO SIN DESCRIPCION";
            $docdeta->artprventa = $codigo;
            $docdeta->docimporte = $codigo;
            $docdeta->user_id = Auth::user()->id;
            $docdeta->docsession = Auth::user()->name;
            $docdeta->save();
            return true;
        }
                
        $resultado = DB::select(" SELECT p.id, p.artcve, p.codbarras, p.artdesc, p.artpesoum, p.artpesogrm, p.artprcosto, p.artprventa, p.stock
        FROM products p
        LEFT JOIN codigos c ON p.id = c.product_id
        WHERE (p.id ='$codigo' OR p.artcve ='$codigo' OR p.codbarras = '$codigo') OR  c.codigo ='$codigo' LIMIT 1 ");

        $product = count($resultado) > 0 ? (object) $resultado[0] : false;

        // guardar datos en db        
        if($product)
        {
            $docdeta = new Docdeta();        
            $docdeta->product_id = $product->id;
            $docdeta->artcve = !empty($product->artcve) ? $product->artcve : false;
            $docdeta->codbarras = !empty($product->codbarras) ? $product->codbarras : false;
            $docdeta->artdesc = !empty($product->artdesc) ? $product->artdesc : false;
            $docdeta->artpesoum = !empty($product->artpesoum) ? $product->artpesoum : false;
            $docdeta->artpesogrm = !empty($product->artpesogrm) ? $product->artpesogrm : false;
            $docdeta->artprcosto = !empty($product->artprcosto) ? $product->artprcosto : 0;
            $docdeta->artprventa = !empty($product->artprventa) ? $product->artprventa : 0;
            $docdeta->docimporte = !empty($product->artprventa) ? $product->artprventa : 0;
            $docdeta->stock = !empty($product->stock) ? $product->stock : 0;
            $docdeta->user_id = Auth::user()->id;
            $docdeta->docsession = Auth::user()->name;
            // $docdeta->docsession = $sesionActual['_token'];
            $docdeta->save();
        }
        
        return false;
        
    } // store

    /**
     * crear registro
     * al dar clic en la descripcion del producto
     */
    public function docdetaStore(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');

        $id = !empty($request->id) ? $request->id : 0;

        $product = Product::find($id);

        $docdeta = new Docdeta();
        $docdeta->artdesc = $product->artdesc;
        $docdeta->product_id = $product->id;
        $docdeta->artcve = $product->artcve;
        $docdeta->codbarras = $product->codbarras;
        $docdeta->artpesoum = $product->artpesoum;
        $docdeta->artpesogrm = $product->artpesogrm;
        $docdeta->artprcosto = $product->artprcosto;
        $docdeta->artprventa = $product->artprventa;
        $docdeta->docimporte = $product->artprventa;
        $docdeta->stock = $product->stock;
        $docdeta->user_id = Auth::user()->id;
        $docdeta->docsession = Auth::user()->name;
        $docdeta->save();

    } // function

    /**
     * obtener todos los registros
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        // Busca el registro por su ID
        $docdeta = Docdeta::find($request->id);
        return response()->json($docdeta);
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
     * editar cantidad y artdescto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $docdeta = Docdeta::find($request->id);
        // Calcular el descuento
        $descuento = $docdeta->artprventa * ($request->input('artdescto') / 100);
        // Calcular el subtotal
        $subtotal = $docdeta->artprventa - $descuento;        
        $docimporte = $request->input('doccant') * $subtotal;

        $docdeta->update([
            'doccant' => $request->input('doccant'),
            'artdescto' => $request->input('artdescto'),
            'docimporte' =>  $docimporte
        ]);

        return response()->json(['success'=>'Producto Guardado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        
        $docdeta = Docdeta::find($request->id);

        $docdeta->delete();

        return response()->json(['success'=>'Producto eliminado']);

    }



} //
