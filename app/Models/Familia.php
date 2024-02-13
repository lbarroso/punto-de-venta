<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;
    // indicamos la tabla por convencionalismo
    //protected $table ='familias';

    // campos llenables
    protected $fillable = ['famdesc'];

    // desactivar timestamps
    // public $timestamps = false;

    // relacion articulos uno a muchos
    // un articulo tiene muchas familias
    public function articulos(){
        return $this->hasMany(Articulo::class);
    }      

}
