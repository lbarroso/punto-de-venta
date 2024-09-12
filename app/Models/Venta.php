<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Venta extends Model
{
    use HasFactory;
    
    protected $fillable = ['pvfecha', 'ctecve', 'pvtotal', 'pvcash', 'pvtipopago', 'user_id', 'user_name', 'uuid', 'pvstatus'];

    
    public function getDaysDifferenceFromNow()
    {
        
        // Configurar la zona horaria
        date_default_timezone_set('America/Mexico_City');
                
        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        // Obtener la fecha de emision del modelo
        $fechaEmision = Carbon::parse($this->attributes['pvfecha']);

        // Calcular la diferencia en dias
        $diferenciaEnDias = $fechaActual->diffInDays($fechaEmision);

        return $diferenciaEnDias;
    }  
    
    // Método para calcular la diferencia en horas
    public function getHoursDifferenceFromNow()
    {
        // Configurar la zona horaria
        date_default_timezone_set('America/Mexico_City');

        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        // Obtener la fecha de emisión del modelo
        $fechaEmision = Carbon::parse($this->attributes['created_at']);

        // Calcular la diferencia en horas
        $diferenciaEnHoras = $fechaActual->diffInHours($fechaEmision);

        return $diferenciaEnHoras;
    }

} // class
