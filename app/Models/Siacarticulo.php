<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siacarticulo extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
     // confirmar nombre de tabla
    protected $table = 'articulos';
    // desactivar timestamps
    public $timestamps = false;	    
    
}
