<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docdeta;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DocdetaController extends Controller
{

    // entradas table
    public function entradaIndex(Request $request)
    {

        if($request->ajax()){
            return response()->json(['data' => Docdeta::where('movcve', 52)
            ->where('docord', 0)
            ->get() ]);
        }

        return view('entradasdocdeta.index');        
    }

    // salidas table
    public function salidaIndex(Request $request)
    {

        if($request->ajax()){
            return response()->json(['data' => Docdeta::where('movcve', 53)
            ->where('docord', 0)
            ->get() ]);
        }

        return view('salidasdocdeta.index');        
    }    

    // crear un nuevo registro en la tabla docdetas
    // movcve 52 entrada
    public function entradaAjaxProduct(Request $request)
    {

        date_default_timezone_set('America/Mexico_City');

        if($request->ajax()){

            // Validar los datos del formulario
            $validatedData = $request->validate([
                'codbarras' => 'required|string|max:255',
                'doccant' => 'required|numeric',
                'artprcosto' => 'required|numeric',
                'artganancia' => 'required|numeric',
                'artprventa' => 'required|numeric',
            ]);

            // importe
            $descto = $validatedData['doccant'] * $validatedData['artprcosto'] / 100;
            $artprcosto = $validatedData['artprcosto'] - $descto ;
            $importe = $validatedData['doccant'] * $artprcosto;

            // Calcular el descuento
            $descuento = $validatedData['artprcosto'] * ($request->input('artdescto') / 100);
            // Calcular el subtotal
            $subtotal = $validatedData['artprcosto'] - $descuento;

            $docimporte = $validatedData['doccant'] * $subtotal;

            // Crear un nuevo registro en la tabla DocDeta
            $docDeta = new Docdeta([
                'product_id' => $request->input('id'),
                'movcve' => 52,
                'artcve' => $request->input('artcve'),
                'codbarras' => $validatedData['codbarras'],
                'artdesc' => $request->input('artdesc'),
                'artprcosto' => $validatedData['artprcosto'],
                'artdescto' => $request->input('artdescto'),
                'artprventa' => $validatedData['artprventa'],
                'docimporte' => $docimporte,
                'artpesogrm' => $request->input('artpesogrm'),
                'artpesoum' => $request->input('artpesoum'),
                'artganancia' => $validatedData['artganancia'],
                'doccant' => $validatedData['doccant'],
                'stock' => $request->input('stock'),
                'docsession' => Auth::user()->name,
                'user_id' => Auth::user()->id,
            ]);
            
            $docDeta->save();

            // actualizar inventario precio venta
            if($request->input('updateArtprventa') == '1'){
                $product = Product::find($request->input('id'));
                $product->update([
                    'artprventa' => $request->input('artprventa')
                ]);
            }

            return response()->json(['success' => 'Producto añadido correctamente', 'data' => $docDeta]);

        }        
    }

    // crear un nuevo registro en la tabla docdetas
    // movcve 53 salida
    public function salidaAjaxProduct(Request $request)
    {

        date_default_timezone_set('America/Mexico_City');

        if($request->ajax()){

            // Validar los datos del formulario
            $validatedData = $request->validate([
                'codbarras' => 'required|string|max:255',
                'doccant' => 'required|numeric',
                'artprventa' => 'required|numeric',
            ]);

            // importe
            $descto = $validatedData['doccant'] * $validatedData['artprventa'] / 100;
            $artprventa = $validatedData['artprventa'] - $descto ;
            $importe = $validatedData['doccant'] * $artprventa;

            // Calcular el descuento
            $descuento = $validatedData['artprventa'] * ($request->input('artdescto') / 100);

            // Calcular el subtotal
            $subtotal = $validatedData['artprventa'] - $descuento;

            $docimporte = $validatedData['doccant'] * $subtotal;

            // Crear un nuevo registro en la tabla DocDeta
            $docDeta = new Docdeta([
                'product_id' => $request->input('id'),
                'movcve' => 53,
                'artcve' => $request->input('artcve'),
                'codbarras' => $validatedData['codbarras'],
                'artdesc' => $request->input('artdesc'),
                'artprcosto' => $request->input('artprcosto'),
                'artdescto' => $request->input('artdescto'),
                'artprventa' => $validatedData['artprventa'],
                'docimporte' => $docimporte,
                'artpesogrm' => $request->input('artpesogrm'),
                'artpesoum' => $request->input('artpesoum'),
                'artganancia' => $request->input('artganancia'),
                'doccant' => $validatedData['doccant'],
                'stock' => $request->input('stock'),
                'docsession' => Auth::user()->name,
                'user_id' => Auth::user()->id,
            ]);
            
            $docDeta->save();

            return response()->json(['success' => 'Producto añadido correctamente', 'data' => $docDeta]);

        }        
    }    

    /******************************
     * buscar codigo               *
     ******************************/
    public function findCode(Request $request)
    {

        if($request->ajax()){
            
            $searchTerm = trim($request->code);

            $product = Product::where('codbarras', $searchTerm)
            ->orWhere('artcve', $searchTerm)
            ->orWhere('id', $searchTerm)
            ->first();

            if (!$product) {
                response()->json(['data' => 'error']);
            }            

            return response()->json(['data' => $product]);

        }

    }

    // buscar producto
    public function entradaFindProduct(Request $request)
    {
        $texto = !empty($request->texto) ? $request->texto : 'xxx';

        if($request->ajax()){

            $products = Product::select('id', 'artdesc', 'codbarras', 'stock', 'artprventa', 'artpesoum', 'artpesogrm')
            ->where(function ($query) use ($texto) {
                $query->where('artdesc', 'like', '%' . $texto . '%')
                    ->orWhere('codbarras', 'like', '%' . $texto . '%');
            })
            ->where('artstatus', 'A')
            ->orderByRaw("CASE WHEN artdesc LIKE '$texto%' THEN 1 ELSE 2 END")
            ->orderBy('artdesc')
            ->get();     
          
            return response()->json(['data' => $products]);
        }
       
    }

    /**
     * agregar registro
     * clic en la descripcion del producto
     */
    public function entradaDocdetaStore(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');

        $id = !empty($request->id) ? $request->id : 0;

        $product = Product::find($id);
        
        /****************ya no es necerio*********
        $docdeta = new Docdeta();
        $docdeta->movcve = 52;
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
        ******************************************/

        return response()->json(['data' => $product]);

    } // function    

    // editar registro
    public function entradaProductShow(Request $request)
    {

        $docdeta = Docdeta::find($request->id);
        
        return response()->json($docdeta);        

    }

    // eliminar registro
    public function entradaProductDelete(Request $request)
    {

        $docdeta = Docdeta::find($request->id);
        $docdeta->delete();

        return response()->json(['success'=>'Producto eliminado']);    

    }    

    /**
     * editar cantidad y artdescto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function entradaProductUpdate(Request $request)
    {
        
        $docdeta = Docdeta::find($request->input('id'));
        // Calcular el descuento
        $descuento = $request->input('artprcosto') * ($request->input('artdescto') / 100);
        // Calcular el subtotal
        $subtotal = $request->input('artprcosto') - $descuento;        
        $docimporte = $request->input('doccant') * $subtotal;

        $docdeta->update([
            'doccant' => $request->input('doccant'),
            'artprcosto' => $request->input('artprcosto'),
            'artdescto' => $request->input('artdescto'),
            'docimporte' =>  $docimporte
        ]);

        return response()->json(['success'=>'Producto Guardado']);
    }    



    /**
     * editar cantidad y artdescto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function salidaProductUpdate(Request $request)
    {
        
        $docdeta = Docdeta::find($request->input('id'));
        // Calcular el descuento
        $descuento = $request->input('artprventa') * ($request->input('artdescto') / 100);
        // Calcular el subtotal
        $subtotal = $request->input('artprventa') - $descuento;     

        $docimporte = $request->input('doccant') * $subtotal;

        $docdeta->update([
            'doccant' => $request->input('doccant'),
            'artprventa' => $request->input('artprventa'),
            'artdescto' => $request->input('artdescto'),
            'docimporte' =>  $docimporte
        ]);

        return response()->json(['success'=>'Producto Guardado']);
    }     

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function entradaTotal(Request $request)
    {
        $docord = !empty($request->docord) ? $request->docord : 0;

        $total = Docdeta::where('movcve', 52)
        ->where('docord', $docord)
        ->sum('docimporte');
                
        if($request->ajax()) return response()->json(['total' => $total]);
        
        return $total;
    }    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function salidaTotal(Request $request)
    {
        $docord = !empty($request->docord) ? $request->docord : 0;

        $total = Docdeta::where('movcve', 53)
        ->where('docord', $docord)
        ->sum('docimporte');
                
        if($request->ajax()) return response()->json(['total' => $total]);
        
        return $total;
    }


} // class
