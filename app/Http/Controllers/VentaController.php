<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Product;
use App\Models\Docdeta;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ImporteLetra;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\DescendenteExport;
use Carbon\Carbon;
use App\Http\Controllers\InventoryController;

class VentaController extends Controller
{

    // Constructor para instanciar el controlador de inventario
    public function __construct(InventoryController $inventoryController)
    {
        $this->inventoryController = $inventoryController;
    }


    /**
     * Guardar venta y actualizar stock
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Establecer zona horaria
        date_default_timezone_set('America/Mexico_City');

        $user = Auth::user();
        
        // Calcular el total de la venta
        $total = Docdeta::where('movcve', 51)
            ->where('user_id', $user->id)
            ->where('docord', 0)
            ->sum('docimporte');

        // Verificar si hay productos en la venta y si el efectivo es suficiente
        $count = Docdeta::where('movcve', 51)
            ->where('user_id', $user->id)
            ->where('docord', 0)
            ->count();
    
        if ($count == 0 || (float)$request->input('cash') < $total) {
            return redirect()->route('pvproducts.index', ['docord' => 0])
                ->with('error', 'La cantidad en efectivo es insuficiente para completar la venta.');
        }
    
        // Iniciar una transacción para asegurar consistencia en la base de datos        
        DB::beginTransaction();
    
        try {
            // Actualizar el stock de los productos vendidos
            $docdetas = Docdeta::where('movcve', 51)
                ->where('user_id', $user->id)
                ->where('docord', 0)
                ->get();
    
            foreach ($docdetas as $docdeta) {
                $product = Product::find($docdeta->product_id);
                if ($product) {
                    // Restar la cantidad vendida del stock
                    $product->decrement('stock', $docdeta['doccant']);
                    // Llamada al método removeFromInventory del InventoryController
                    // $this->inventoryController->removeFromInventory($docdeta->product_id, $docdeta['doccant']);
                }
            }
    
            // Guardar venta registrada
            $venta = Venta::create([
                'pvfecha' => now(),
                'ctecve' => 1,
                'pvtotal' => $total,
                'pvcash' => $request->input('cash'),
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'pvtipopago' => $request->input('tipopago', 'efectivo'),
            ]);
    
            // Obtener el último ID insertado
            $ID = $venta->id;
    
            // Actualizar los registros de detalle de documento
            Docdeta::where('movcve', 51)
                ->where('user_id', $user->id)
                ->where('docord', 0)
                ->update(['docord' => $ID]);
    
            DB::commit();
    
            return redirect()->route('pvproducts.index')->with('docord', $ID);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pvproducts.index', ['docord' => 0])
                ->with('error', 'Error al guardar la venta: ' . $e->getMessage());
        }
    }

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
		
		$query = Venta::query();
		$totalQuery = Venta::query();

		if (!empty($request->id)) {
			$query->where('id', $request->id);
			$totalQuery->where('id', $request->id);
		} elseif ($request->fecha_inicio) {
			$this->validate($request, [
				'fecha_inicio' => 'required|date',
				'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
			]);

			$query->whereBetween('pvfecha', [$request->fecha_inicio, $request->fecha_fin]);
			$totalQuery->whereBetween('pvfecha', [$request->fecha_inicio, $request->fecha_fin]);
		} else {
			$today = now()->toDateString();
			$query->whereDate('pvfecha', $today);
			$totalQuery->whereDate('pvfecha', $today);
		}

        // Paginar el resultado de ventas (10 por página)
        $ventas = $query->paginate(15);        

		$total = $totalQuery->where('pvstatus', 'A')->sum('pvtotal');

		$totales = $totalQuery->selectRaw('pvtipopago, SUM(pvtotal) as total')
			->where('pvstatus', 'A')
			->groupBy('pvtipopago')
			->get();

		return view('pventa.ventas-diarias', compact('ventas', 'total', 'totales'));
    
	} // fin metodo

    // reporte de ventas en pantalla
    public function SalesReport(Request $request){

        date_default_timezone_set('America/Mexico_City');

        $this->validate($request, [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);
        
        $docdetas = DB::select("SELECT docdetas.status, docdetas.codbarras, ventas.pvtipopago, ventas.pvfecha, docdetas.artdesc, docdetas.artprcosto, docdetas.artprventa, docdetas.artdescto,
        SUM(docdetas.doccant) cant, SUM(docdetas.docimporte) importe
        FROM ventas
        INNER JOIN docdetas ON docdetas.docord = ventas.id
        WHERE ventas.pvfecha BETWEEN '$request->fecha_inicio' AND '$request->fecha_fin' AND docdetas.movcve = 51
        GROUP BY docdetas.codbarras 
        ORDER BY ventas.pvfecha");        

        $total = Venta::whereBetween('pvfecha', [$request->fecha_inicio, $request->fecha_fin])->where('pvstatus','A')->sum('pvtotal');

        $totales = Venta::selectRaw('pvtipopago, SUM(pvtotal) as total')
        ->whereBetween('pvfecha', [$request->fecha_inicio, $request->fecha_fin])
        ->where('pvstatus','A')
        ->groupBy('pvtipopago')
        ->get();

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaInicio = $fechaInicio->format('d/m/Y');

        $fechaFin = Carbon::parse($request->fecha_fin);
        $fechaFin = $fechaFin->format('d/m/Y');

        return view('exports.ventas-print', compact('docdetas','total', 'totales', 'fechaInicio', 'fechaFin'));

    }

    // vista reporte
    function ventas()
    {
        return view('reports.ventas');
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
            GROUP BY docdetas.codbarras 
            ORDER BY importe Desc, cant Desc");

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

    // descuento sobre venta
    public function desctoVenta(Request $request){
        
        $docdetas = Docdeta::where('movcve', 51)
        ->where('user_id', Auth::user()->id)
        ->where('docord', 0)
        ->get();

        foreach ($docdetas as $row) {
            $docdeta = Docdeta::find($row->id);
            $docdeta->artdescto = $request->input('porcentaje');
            
            $subtotal = $row->artprventa * ($request->input('porcentaje') / 100);
            $artprventa = $row->artprventa - $subtotal;
            $docdeta->docimporte = $artprventa * $row->doccant;
            $docdeta->save();
        }

        return redirect('pvproducts');

    }

    // cancelar venta
    public function cancelar(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        $user = User::where('email','cancelar@sistemasloop.com')->first();

        // Asumiendo que guardas la contraseña de manera segura y necesitas verificarla
        if (\Hash::check($request->input('password'), $user->password)) {
            $venta->pvstatus = 'C'; // 'C' podría ser tu código de 'Cancelado'
            $venta->save();

            $docdetas = Docdeta::where('movcve', 51)
            ->where('docord', $id)
            ->get();
            
            foreach ($docdetas as $docdeta) {
                $product = Product::find($docdeta->product_id);
                if ($product) {
                    // restablece el stock
                    $product->stock += $docdeta['doccant'];
                    $product->save();
                }
            }            

            // actualizar relacion
            Docdeta::where('movcve', 51)
            ->where('docord', $id)
            ->update(['status' => 'C']);

            return redirect()->route('daily.sales')->with('success', 'La venta fue cancelada correctamente, folio: '.$id);
        } else {
            return back()->with('error', 'La contraseña es incorrecta.');
        }
    }

    // Método para mostrar el formulario de cancelación
    public function ventaCancelar($id)
    {
        $venta = Venta::findOrFail($id);
        return view('pventa.cancelar_venta', ['venta' => $venta]);
    }    

} //class
