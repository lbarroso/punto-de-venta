<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['numberid', 'store', 'rfc', 'nombre', 'postal_code', 'regimen', 'uuid', 'total', 'email'];    
}
