<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use PhpOffice\PhpSpreadsheet\Cell;

use Illuminate\Support\Facades\DB;

use App\Models\Docdeta;
use App\Models\Venta;
use App\Models\Compra;

use Carbon\Carbon;

class DescendenteExport implements FromView, WithColumnFormatting
{

    protected $fechaInicio, $fechaFin, $movcve;

    public function __construct($fechaInicio, $fechaFin, $movcve)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->movcve = $movcve;
    }

    public function view():View
    {
        
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $this->fechaInicio)->startOfDay();
        $fechaFin = Carbon::createFromFormat('Y-m-d', $this->fechaFin)->endOfDay();
        $movcve = $this->movcve;

        // ventas mostrador
        if($movcve == 51){
            
            $docdetas = DB::select("SELECT docdetas.codbarras, docdetas.artdesc, docdetas.artprcosto, docdetas.artprventa, docdetas.artdescto, SUM(docdetas.doccant) cant, SUM(docdetas.docimporte) importe
            FROM ventas
            INNER JOIN docdetas ON docdetas.docord = ventas.id
            WHERE ventas.pvfecha BETWEEN '$fechaInicio' AND '$fechaFin' AND docdetas.movcve =51
            GROUP BY docdetas.codbarras ORDER BY importe Desc");

            $total = Venta::whereBetween('pvfecha', [$fechaInicio, $fechaFin])
            ->sum('pvtotal');

            $titulo ='VENTAS MOSTRADOR';
        }

        // entradas de proveedor
        if($movcve == 52){
            
            $docdetas = DB::select("SELECT docdetas.codbarras, docdetas.artdesc, docdetas.artprcosto, docdetas.artprventa, docdetas.artdescto, SUM(docdetas.doccant) cant, SUM(docdetas.docimporte) importe
            FROM compras
            INNER JOIN docdetas ON docdetas.docord = compras.id
            WHERE compras.fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND docdetas.movcve = 52
            GROUP BY docdetas.codbarras ORDER BY importe Desc");

            $total = Compra::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('total');

            $titulo ='ENTRADAS DE PROVEEDOR';
        }        
     
        $fecha_inicio = Carbon::parse($fechaInicio);
        $fecha_inicio = $fecha_inicio->format('d/m/Y');

        $fecha_fin = Carbon::parse($fechaFin);
        $fecha_fin = $fecha_fin->format('d/m/Y');
                
        return view('exports.descendente', [
            'docdetas' => $docdetas,
            'total' => $total,
            'fechaInicio' => $fecha_inicio,
            'fechaFin' =>  $fecha_fin,
            'titulo' => $titulo,
        ]);

    }



    public function columnFormats(): array
    {

        return [

            'A' => NumberFormat::FORMAT_NUMBER,

            'B' => NumberFormat::FORMAT_TEXT,

            'C' => NumberFormat::FORMAT_TEXT,

            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,  
            
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,  

        ];

    }

}