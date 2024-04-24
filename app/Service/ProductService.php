<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductService{

    /*
    'artdesc' => [ 
        'required',
        Rule::unique('products')
    ],
    */

    public function validationStore(Request $request){
        $validator = Validator::make($request->all(),[
            'artdecs' => 'required',            
            'artprventa' => 'required',
            'category_id' => 'required',
        ]);

        return $validator;
    }

}