<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Codigo
 *
 * @property $id
 * @property $product_id
 * @property $codigo
 * @property $created_at
 * @property $updated_at
 *
 * @property Product $product
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Codigo extends Model
{
    
    static $rules = [
		'product_id' => 'required',
    ];

    protected $perPage = 20;

    // desactivar timestamps
    public $timestamps = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id','codigo'];


    /**
    *public function product()
    *{
    *   return $this->hasOne('App\Models\Product', 'id', 'product_id');
    *}
    */


}
