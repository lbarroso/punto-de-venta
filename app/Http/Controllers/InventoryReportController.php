<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docdeta;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class InventoryReportController extends Controller
{
    public function index()
    {
        $codbarras = '';
        $month = date('m');

        // Asume que la columna de fecha se llama 'fecha'
        $movimientos = Docdeta::where('codbarras', $codbarras)
        ->whereMonth('created_at', $month)
        ->orderBy('id')
        ->get(['docord','doccant','movcve','codbarras', 'artdesc', 'created_at']);

        return view('reports.movimientos', compact('movimientos'));
    }

    public function result(Request $request){
       
        // Recuperar los valores del formulario
        $year = $request->input('year');
        $month = $request->input('month');
        $month = 3;
        $codbarras = !empty($request->input('codbarras')) ? trim($request->input('codbarras')) : 0;

        $product = Product::where('codbarras', $codbarras)
        ->orWhere('artcve', $codbarras)
        ->orWhere('id', $codbarras)
        ->first();

        $movimientos = Docdeta::join('movimientos', 'docdetas.movcve', '=', 'movimientos.id')
        ->where('docdetas.created_at', '>=', '2024-01-01 00:00:00')
        ->where('docdetas.status', 'A')
        ->where('docdetas.docord', '>', 0)
        ->where('docdetas.product_id', $product->id)
        ->orderBy('docdetas.created_at')
        ->orderBy('docdetas.id')
        ->get(['docdetas.created_at', 'docdetas.referencia', 'docdetas.docord', 'docdetas.movcve', 'docdetas.doccant', 'movimientos.movdesc']);

        // Opcional: pasar los resultados a una vista para visualizarlos
        return view('reports.movimientos', compact('movimientos','product'));        

    }

} // class
