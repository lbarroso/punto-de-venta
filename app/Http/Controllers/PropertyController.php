<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductProperty;
use Illuminate\Http\Request;

class PropertyController extends Controller
{

    public function table(Product $product){
        $data = ProductProperty::where('product_id',$product->id)->get();

       return  response()->json($data);
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required',
        ]);

        ProductProperty::create($request->all());
        return response()->json(['success' => 'se guardo correctmente los datos']);

    }


    public function destroy(ProductProperty $property){
        $property->delete();
        return response()->json(['success' => 'se elimino correctmente los datos']);

    }    

} // class
