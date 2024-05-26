<?php

namespace App\Http\Controllers;
use App\Models\Docdeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CobroEsperaController extends Controller
{
    
    // id = cobro en espera
    public function cobroEspera(Request $request)
    {
        $id = !empty($request->id) ? (int)$request->id: 1;
        
        // id = 1
        $pventa = Docdeta::where('movcve', 51)
            ->where('docord', 0)
            ->where('user_id', Auth::user()->id)
            ->count();
        
        // id = 1, 2, 3
        $espera = Docdeta::where('movcve', 38)
            ->where('docord', $id)
            ->where('user_id', Auth::user()->id)
            ->count();		   
            
        if($pventa == 0 && $espera == 0) return redirect()->route('pvproducts.index', ['docord' => 0]);
        
        if($pventa > 0 && $espera == 0) $this->esperar($id);

        if($espera > 0 && $pventa == 0) $this->vender($id);

        if($pventa > 0 && $espera > 0){
            $this->esperar($id + 1); 
            $this->vender($id); 
            $this->cola($id + 1);
        } 
        
        return redirect()->route('pvproducts.index', ['docord' => 0]); 
    }

    public function esperar($id){
	
        Docdeta::where('movcve', 51)
        ->where('docord', 0)
        ->where('user_id', Auth::user()->id)
        ->update(['movcve' => 38, 'docord' => $id]);
    }    

    public function vender($id){
	
        Docdeta::where('movcve', 38)
        ->where('docord', $id)
        ->where('user_id', Auth::user()->id)
        ->update(['movcve' => 51, 'docord' => 0]);	
    }    

    public function cola($id){
	
        Docdeta::where('movcve', 38)
        ->where('docord', $id)
        ->where('user_id', Auth::user()->id)
        ->update(['docord' => $id - 1]);	
    }    


} // class
