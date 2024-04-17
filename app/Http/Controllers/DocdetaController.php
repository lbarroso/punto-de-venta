<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docdeta;
use App\Models\Product;

class DocdetaController extends Controller
{


    public function entradaIndex(Request $request)
    {

        if($request->ajax()){
            return response()->json(['data' => Docdeta::where('movcve', 52)
            ->where('docord', 0)
            ->get() ]);
        }

        return view('entradas.index');        
    }


    /******************************
     * buscar product->codbarras   *
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

    public function salidaIndex(Request $request)
    {

        return view('salidas.index');        
    }    

} // class
