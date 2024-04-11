<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    
    protected $table ='proveedores';

    protected $primaryKey = 'id';
    
    protected $fillable = ['prvrazon','prvdir','prvemail','prvtelefono'];

    // una categotia tiene muchos productos
    public function products(){
        return $this->hasMany(Product::class);
        
    }    



}
