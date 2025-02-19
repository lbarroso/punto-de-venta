<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    // activa carbon
    protected $dates = ['fecha'];
    protected $fillable = ['fecha', 'factura', 'total', 'prvcve', 'comentarios', 'user_name', 'status'];

    
}
