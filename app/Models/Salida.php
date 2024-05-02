<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;
    // activa carbon
    protected $dates = ['fecha'];

    protected $fillable = ['fecha', 'total', 'ctecve', 'comentarios', 'user_name', 'status'];
}
