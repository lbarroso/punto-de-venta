<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Proveedor;
use App\Models\Product;
use App\Models\Codigo;
use App\Models\Empresa;
use App\Service\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Excel;
use App\Exports\PosicionExport;
use App\Exports\CatalogoExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * cargar todo
     */
    public function index(Request $request)
    {
        
        if($request->ajax()){
               
            return response()->json(['data' => Product::with('category')->Where('artstatus','A')->orderByDesc('id')->get()]);

        }

        return view('products.index');        
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
    public function store(Request $request, ProductService $service)
    {
        $validator = $service->validationStore($request);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()],400);
        }        

        //
        $data = $request->all();

        Product::create($data);

        return response()->json(['success'=>'Producto Guardado']);        
    }

    /**
     * agregar nuevo producto
     *
     * formulario personalizado formcreate.blade.php
     * 
     */    
    public function productStore(Request $request)
    {
        
        $reglas = [
            'artdesc' => 'required|max:255|unique:products,artdesc',
            'category_id' => 'required',
            'artprventa' => 'required|gt:artprcosto'
        ];
        
        $request->validate($reglas);

        $data = $request->all();

        Product::create($data);
        
        return redirect()->route('products.index')->with('success', 'Nuevo producto agregado correctamente');
    } // productStore

    /**
     * formulario 
     *
     * agregar nuevo producto
     * 
     */    
    public function productCreate()
    {

        return view('products.formcreate');

    } // productCreate   


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        $product->update($data);

        return response()->json(['success'=>'Producto Guardado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return response()->json(['success'=>'Producto eliminado']);        
    }

    /**
     * listado categorias llamada desde product.js
     */
    public function categories(){
        return response()->json(Category::orderBy('name')->get());
    }

    /**
     * listado proveedores llamada desde product.js
     */
    public function proveedores(){
        return response()->json(Proveedor::orderBy('prvrazon')->get());
    }

    /**
     * codigo barras duplicado
     */
    public function existeCodigo($codbarras)
    {
        if(strlen($codbarras) == 0 || $codbarras == ' ') return false;

        $productoExistente = Product::where('codbarras', $codbarras)->exists();

        if ($productoExistente) {
            return "El código '$codbarras' ya existe en otro producto. <br>";
        } else return false;
        

    }

    /**
     * producto duplicado
     */
    public function existeProducto($artdesc)
    {
        if($artdesc == ' ' || strlen($artdesc) == 0) return 'Debe escribir la descripción del producto.';

        $productoExistente = Product::where('artdesc', $artdesc)->exists();

        if ($productoExistente) {
            return "El producto '$artdesc' ya existe en otro producto.";
            
        } else return false;
        
    }


    /**
     * form product validate
     */
    public function productValidate(Request $request)
    {
        // request from view products/formcreate
        $error = $this->existeCodigo(trim($request->codbarras));        
        $error .= $this->existeProducto(trim($request->artdesc));                
        $error .= ((float)$request->artprcosto > (float)$request->artprventa) ?  'El precio de costo No puede ser mayor que de venta' : false;
        if($error == false) echo 'success';
        else echo $error;

    } // function
    
    // reporte posicion excel
    public function posicionExport()    
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha  = date('Y-m-d\TH:i:s');
        return Excel::download(new PosicionExport, 'posicionAlmacen'.$fecha.'.xls');
        // return (new PosicionExport)->download('PosicionExport.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        // return (new posicionExport)->store('invoices.xlsx', 's3');
        // return new CatalogoExport();
    }
    
    // claves genericas
    public function productCodes(Request $request)
    {    
                
        return response()->json( Codigo::Where('product_id',$request->id)->orderBy('id')->get() );
    }

    // crear code
    public function storeCodes(Request $request)
    {

        $data = $request->all();
        Codigo::create($data);    

        return response()->json( Codigo::Where('product_id',$request->product_id)->orderBy('id')->get() );
    }

    // eleminar clave generica
    public function deleteCodes(Request $request)
    {    
        
        $codigo = Codigo::find($request->id);
        $codigo->delete();

        return response()->json( Codigo::Where('product_id',$request->product_id)->orderBy('id')->get() );
    }    


    // vista reportes diarios
    function reportsDiarios()
    {        
        return view('reports.diarios');
    }    

    // vista reportes diarios
    function reportsDescendente()
    {
        return view('reports.inventarios');
    }        

    // Catalogo Pdf
    public function downloadDompdf( )
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha  = date('d-m-Y\TH:i:s');

        $empresa = Empresa::find(1);

        $products = Product::select('products.codbarras','products.artseccion', 'products.artdesc', 'products.artpesoum', 'products.stock', 'media.id', \DB::raw('media.name AS image'), 'categories.name')
        ->leftJoin('media', 'products.id', '=', 'media.model_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.artstatus', 'A')
        ->where('stock', '>', 20)
        ->orderBy('products.category_id')
        ->orderBy('products.artcve')
        ->groupBy('products.artcve') // Agrupar por products.artcve para evitar duplicados
        ->get();

       // familias
       $categories = Product::select('name')        
       ->join('categories', 'products.category_id', '=', 'categories.id')
       ->where('stock', '>', 20)    
       ->orderBy('categories.name')
       ->distinct()
       ->get();           
       
        // novedades
        $releases = false;       
        
        $pdf = Pdf::loadView('pdf.catalogo',['products' => $products, 'categories'=>$categories, 'empresa'=>$empresa, 'releases'=>$releases]);
        
        return $pdf->stream('CatalogDigital'.$fecha.'.pdf');
    }    

} // class
