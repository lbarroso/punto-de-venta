<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Docdeta extends Model
{
    use HasFactory;
    
    protected $table = 'docdetas';

    protected $fillable = [ 'product_id', 'movcve', 'docord', 'artcve', 'codbarras', 'artdesc', 'artprcosto', 'artdescto', 'artprventa',
        'referencia', 'docimporte', 'artpesogrm', 'artpesoum', 'artganancia', 'doccant', 'docstatus', 'stock', 'docsession', 'numberid', 'user_id', 'uuid',
    ];

    // Definir la relación con Movimiento
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movcve', 'id');
    }    

}
