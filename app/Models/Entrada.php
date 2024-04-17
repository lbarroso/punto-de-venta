<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'compras';

    // Especifica los campos que pueden ser asignados masivamente
    protected $fillable = ['fecha', 'total', 'status', 'prvcve', 'comentarios'];

    // Si tienes campos de tipo date o datetime puedes especificarlos aquí
    protected $dates = ['fecha'];

    // Aquí puedes definir relaciones, métodos o comportamientos adicionales
        
}
