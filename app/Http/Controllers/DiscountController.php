<?php



namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDiscount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function table(Product $product){
        $data = ProductDiscount::findProductAdmin($product)->get();

       return  response()->json($data);
    }


    public function store(Request $request){
        $request->validate([
            'percentage' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'product_id' => 'required',
        ]);

        ProductDiscount::create($request->all());
        return response()->json(['success' => 'se guardo correctmente los datos']);

    }


    public function destroy(ProductDiscount $discount){
        $discount->delete();
        return response()->json(['success' => 'se elimino correctmente los datos']);

    }
}
