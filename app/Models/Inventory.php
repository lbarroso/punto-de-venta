<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'inventories';

    // desactivar timestamps
    public $timestamps = false;    

    protected $fillable = ['product_id', 'quantity', 'entry_date'];
    
}
