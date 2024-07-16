<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Docdeta;
use App\Models\Salida;
use App\Models\Empresa;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Http\Controllers\InventoryController;

class SalidaController extends Controller
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

        $salidas = Salida::join('clientes', 'salidas.ctecve', '=', 'clientes.id')
        ->whereDate('salidas.created_at', now()->toDateString())
        ->orderBy('salidas.created_at', 'desc')
        ->select('salidas.*', 'clientes.ctenom as cliente') // ejemplo de selección de columnas
        ->paginate(10);

        return view('salidas.index', compact('salidas'));

    }

    // salidas
    public function history(Request $request){
        
        date_default_timezone_set('America/Mexico_City');

        if ($request->isMethod('post')) {
            // Guarda los criterios de búsqueda en la sesión
            $request->session()->put('search', $request->all());
        }
    
        $search = $request->session()->get('search');
    
        $salidas = Salida::join('clientes', 'salidas.ctecve', '=', 'clientes.id')
        ->where(function($query) use ($search) {
            $query->whereBetween('salidas.fecha', [ $search['fecha_inicio'], $search['fecha_fin'] ])
                  ->orWhere('salidas.id', $search['docord']);
        })
        ->orderBy('salidas.created_at', 'desc')
        ->select('salidas.*', 'clientes.ctenom as cliente') // ejemplo de selección de columnas
        ->paginate(10);

        $fecha_inicio = Carbon::parse($search['fecha_inicio']);
        $fecha_inicio = $fecha_inicio->format('d/m/Y');

        $fecha_fin = Carbon::parse( $search['fecha_fin']);
        $fecha_fin = $fecha_fin->format('d/m/Y');

        return view('salidas.index', compact('salidas','fecha_inicio','fecha_fin'));

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
        
        $total = Docdeta::where('movcve', 53)
        ->where('docord', 0)
        ->sum('docimporte');

        $count = DocDeta::where('movcve', 53)
        ->where('docord', 0)
        ->count();        

        if($count <= 0 ) return redirect()->route('salidas.index');

        // Actualizar stock de productos
        $docdetas = Docdeta::where('movcve', 53)
        ->where('docord', 0)
        ->get();

        foreach ($docdetas as $docdeta) {
            $product = Product::find($docdeta->product_id);
            if ($product) {
                // restar del stock
                $product->stock -= $docdeta['doccant'];
                $product->save();
            }
            
            // Llamada al método addToInventory
            $this->inventoryController->removeFromInventory($docdeta->product_id, $docdeta['doccant']);

        }        

        // guardar salida
        $salida = new Salida();
        $salida->fecha = $request->input('fecha');
        $salida->ctecve = $request->input('ctecve');
        $salida->total = $total;
        $salida->user_name = Auth::user()->name;
        $salida->comentarios = $request->input('comentarios');
        $salida->save();
        
        // last Id
        $ID = $salida->id;
        
        $cliente = Cliente::find($request->input('ctecve'));

        // relacionar
        Docdeta::where('movcve', 53)
        ->where('docord', 0)
        ->update(['docord' => $ID, 'created_at' => $request->input('fecha'), 'referencia' => $cliente->ctenom ]);        

        // EntradaController@index
        return redirect()->route('salidas.index')->with('docord', $ID);

    }

    // Entrada PDF
    function pdf(Request $request)
    {

        date_default_timezone_set('America/Mexico_City');
        
        $fecha  = date('d-m-Y\TH:i:s');

        $docdetas = Docdeta::where('movcve', 53)
        ->where('docord', $request->id)
        ->orderBy('artdesc')
        ->get();

        $articulos = Docdeta::where('docord', $request->id)
        ->where('movcve', 53)
        ->sum('doccant');        

        $salida = Salida::find($request->id);

        $empresa = Empresa::find(1);

        $cliente = Cliente::find($salida->ctecve);

        $pdf = Pdf::loadView('salidas.pdf',['docdetas' => $docdetas, 'salida'=>$salida, 'empresa'=>$empresa, 'cliente'=>$cliente, 'articulos'=>$articulos]);
        
        return $pdf->stream('salida'. $request->id .'-'.$fecha .'.pdf');
    }    

    // ticket
    public function ticket(Request $request)
    {

        $id = !empty($request->id) ? $request->id : 0;

        $empresa = Empresa::find(1);

        $total = Docdeta::where('movcve', 53)
        ->where('docord', $id)
        ->sum('docimporte');

        $docdetas = Docdeta::where('movcve', 53)
        ->where('docord', $id)
        ->get();
        
        $articulos = Docdeta::where('docord', $request->id)
        ->where('movcve', 53)
        ->sum('doccant');   

        $salida = Salida::find($id);        

        return view('salidas.ticket', compact('docdetas','total','empresa','id','articulos','salida') );
    }    

} // class
