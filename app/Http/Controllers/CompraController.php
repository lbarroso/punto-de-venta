<?php

namespace App\Http\Controllers;
use App\Models\Compra;
use App\Models\Product;
use App\Models\Empresa;
use App\Models\Docdeta;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\InventoryController;

class CompraController extends Controller
{

    // Constructor para instanciar el controlador de inventario
    public function __construct(InventoryController $inventoryController)
    {
        $this->inventoryController = $inventoryController;
    }

    /**
     * Display a listing of purchases within a specified date range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        date_default_timezone_set('America/Mexico_City');

        $compras = Compra::join('proveedores', 'compras.prvcve', '=', 'proveedores.id')
        ->whereDate('compras.created_at', now()->toDateString())
        ->orderBy('compras.created_at', 'desc')
        ->select('compras.*', 'proveedores.prvrazon as proveedor') // ejemplo de selección de columnas
        ->paginate(10);   

        return view('compras.index', compact('compras'));

    } // 

    // compras
    public function history(Request $request){
        
        date_default_timezone_set('America/Mexico_City');

        if ($request->isMethod('post')) {
            // Guarda los criterios de búsqueda en la sesión
            $request->session()->put('search', $request->all());
        }
    
        $search = $request->session()->get('search');
    
        $compras = Compra::join('proveedores', 'compras.prvcve', '=', 'proveedores.id')
        ->whereBetween('compras.fecha', [ $search['fecha_inicio'], $search['fecha_fin'] ])
        ->orderBy('compras.created_at', 'asc')
        ->select('compras.*', 'proveedores.prvrazon as proveedor') // ejemplo de selección de columnas
        ->paginate(10);

        $fecha_inicio = Carbon::parse($search['fecha_inicio']);
        $fecha_inicio = $fecha_inicio->format('d/m/Y');

        $fecha_fin = Carbon::parse( $search['fecha_fin']);
        $fecha_fin = $fecha_fin->format('d/m/Y');

        return view('compras.index', compact('compras','fecha_inicio','fecha_fin'));
    }

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

        /***Actualizar stock de los productos***/
        foreach ($docdetas as $docdeta) {

            $product = Product::find($docdeta->product_id);
            
            // Sumar la cantidad al stock
            $product->increment('stock', $docdeta['doccant']);

            // Datos para añadir al inventario
            $inventoryData = [
                'product_id' => $docdeta['product_id'],
                'quantity' => $docdeta['doccant'],
                'entry_date' => $request->input('fecha_entrada')
            ];

            // Llamada al método addToInventory
            $success = $this->inventoryController->addToInventory($inventoryData);
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
        ->update(['docord' => $ID, 'referencia' => $request->input('factura'), 'created_at' => $request->input('fecha') ]);

        return redirect()->route('compras.index')->with('success', 'Compra guardada correctamente.');
    } // store


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
