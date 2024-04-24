<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Product;
use App\Models\Docdeta;
use App\Models\Empresa;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ImporteLetra;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\DescendenteExport;
use Carbon\Carbon;

class VentaController extends Controller
{
    /**
     * Guardar venta y actualizar stock
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        date_default_timezone_set('America/Mexico_City');
        
        $total = Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->sum('docimporte');

        if($total <= 0 || $request->input('cash') < $total ) return redirect()->route('pvproducts.index', ['docord' => 0]);        

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
                
        if($request->ajax()) return response()->json(['total' => $total]);
        
        return $total;
    }

    // total articulos
    public function totalProducts(Request $request)
    {
        $id = !empty($request->id) ? $request->id : 0;

        $articulos = Docdeta::where('docord', $id)
        ->where('user_id', Auth::user()->id)
        ->where('movcve', 51)
        ->sum('doccant');
                
        if($request->ajax()) return response()->json(['articulos' => number_format($articulos,2)]);
        
        return $articulos;
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
            ->orderByRaw("CASE WHEN artdesc LIKE '$texto%' THEN 1 ELSE 2 END")
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
    public function dailySales(Request $request)
    {
        
        date_default_timezone_set('America/Mexico_City');

        if($request->fecha_inicio){

            $this->validate($request, [
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);
                        
            $ventas = Venta::whereBetween('pvfecha', [$request->fecha_inicio, $request->fecha_fin])->get();
            $total = Venta::whereBetween('pvfecha', [$request->fecha_inicio, $request->fecha_fin])->sum('pvtotal');
            $totales = Venta::selectRaw('pvtipopago, SUM(pvtotal) as total')
            ->whereBetween('pvfecha', [$request->fecha_inicio, $request->fecha_fin])
            ->groupBy('pvtipopago')
            ->get();

        }else{
            $ventas = Venta::whereDate('created_at', now()->toDateString())->get();
            $total = Venta::whereDate('created_at', now()->toDateString())->sum('pvtotal');
            $totales = Venta::selectRaw('pvtipopago, SUM(pvtotal) as total')
            ->whereDate('created_at', now()->toDateString())
            ->groupBy('pvtipopago')
            ->get();            
        }

        return view('pventa.ventas-diarias', compact('ventas','total', 'totales'));
    }


    // vista reporte
    function descendente()
    {
        return view('reports.descendente');
    }  

    //reporte descendente Excel
    public function descendenteExport(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'movcve' => 'required',
        ]);
        if($request->movcve==51) $titulo = "VentaMostrador";
        else if($request->movcve==52) $titulo = "Entradas";
        else $titulo = "Salidas";

        return Excel::download(new DescendenteExport($request->fecha_inicio, $request->fecha_fin, $request->movcve), 'Descendente'.$titulo.'.xlsx');
    }


    //reporte descendente Excel
    public function descendentePrint(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'movcve' => 'required',
        ]);

        if($request->movcve == 51) $titulo = "VentaMostrador";        
        else if($request->movcve == 52) $titulo = "Entradas";
        else $titulo = "Salidas";
    
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::createFromFormat('Y-m-d', $request->fecha_fin)->endOfDay();

        $movcve = $request->movcve;

        // ventas mostrador
        if($movcve == 51){
            
            $docdetas = DB::select("SELECT docdetas.codbarras, docdetas.artdesc, docdetas.artprcosto, docdetas.artprventa, docdetas.artdescto, SUM(docdetas.doccant) cant, SUM(docdetas.docimporte) importe
            FROM ventas
            INNER JOIN docdetas ON docdetas.docord = ventas.id
            WHERE ventas.pvfecha BETWEEN '$fechaInicio' AND '$fechaFin' AND docdetas.movcve =51
            GROUP BY docdetas.codbarras ORDER BY importe Desc");

            $total = Venta::whereBetween('pvfecha', [$fechaInicio, $fechaFin])->sum('pvtotal');

            $titulo ='VENTAS MOSTRADOR';
        }

        // entradas de proveedor
        if($movcve == 52){
            
            $docdetas = DB::select("SELECT docdetas.codbarras, docdetas.artdesc, docdetas.artprcosto, docdetas.artprventa, docdetas.artdescto, SUM(docdetas.doccant) cant, SUM(docdetas.docimporte) importe
            FROM compras
            INNER JOIN docdetas ON docdetas.docord = compras.id
            WHERE compras.fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND docdetas.movcve = 52
            GROUP BY docdetas.codbarras ORDER BY importe Desc");

            $total = Compra::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('total');

            $titulo ='ENTRADAS DE PROVEEDOR';
        }       

        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fechaInicio = $fecha_inicio->format('d/m/Y');

        $fecha_fin = Carbon::parse($request->fecha_fin);
        $fechaFin = $fecha_fin->format('d/m/Y');

        return view('exports.descendente-print', compact('docdetas','total','titulo', 'fechaInicio', 'fechaFin') );
    }    


}
