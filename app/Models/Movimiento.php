<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos'; // Asegurarse de que el nombre de la tabla esté correctamente especificado

    // Definir la relación con Docdeta
    public function docdetas()
    {
        return $this->hasMany(Docdeta::class, 'movcve', 'id');
    }
}