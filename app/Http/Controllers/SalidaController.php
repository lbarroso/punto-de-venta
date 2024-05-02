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

class SalidaController extends Controller
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

            $salidas = Salida::join('clientes', 'salidas.ctecve', '=', 'clientes.id')
            ->whereBetween('salidas.fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->orderBy('salidas.created_at', 'desc')
            ->select('salidas.*', 'clientes.ctenom as cliente') // ejemplo de selección de columnas
            ->paginate(15);

            $total = Salida::whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])->sum('total');

        }else{

            $salidas = Salida::join('clientes', 'salidas.ctecve', '=', 'clientes.id')
            ->whereDate('salidas.created_at', now()->toDateString())
            ->orderBy('salidas.created_at', 'desc')
            ->select('salidas.*', 'clientes.ctenom as cliente') // ejemplo de selección de columnas
            ->paginate(15);

            $total = Salida::whereDate('created_at', now()->toDateString())->sum('total');
        }

        return view('salidas.index', compact('salidas','total'));

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
        }        

        // guardar salida
        $salida = new Salida();
        $salida->fecha = now();
        $salida->ctecve = $request->input('ctecve');
        $salida->total = $total;
        $salida->user_name = Auth::user()->name;
        $salida->comentarios = $request->input('comentarios');
        $salida->save();
        
        // last Id
        $ID = $salida->id;

        // relacionar
        Docdeta::where('movcve', 53)
        ->where('docord', 0)
        ->update(['docord' => $ID]);        

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
