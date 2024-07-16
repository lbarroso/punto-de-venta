<?php

namespace App\Models;

use App\Scope\ProductDiscountScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model 
{
    use HasFactory,ProductDiscountScope;

    protected $fillable = ['date_end','date_start','product_id','percentage'];

    protected function isActive(): Attribute{
        $dateNow = Carbon::now()->timezone('America/Mexico_City')->format('Y-m-d');
        $active = 'No';

        if($this->date_start <= $dateNow && $this->date_end >= $dateNow  ){
            $active = "Si";
        }

        return Attribute::make(
            get: fn ($value) => $active,
        );
    }
}
