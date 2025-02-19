<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cierre extends Model
{
    use HasFactory;
    protected $fillable = ['entrada', 'salida', 'venta', 'saldo_actual', 'saldo_anterior'];
}
