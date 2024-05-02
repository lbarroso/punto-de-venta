<?php



namespace App\Exports;



use App\Models\Product;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use PhpOffice\PhpSpreadsheet\Cell;

use Illuminate\Support\Facades\DB;





class PosicionExport implements FromView, WithColumnFormatting

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function view():View

    {

        //$products = Product::all();
        $products = Product::select('products.artdetalle', 'products.id', 'products.codbarras', 'products.artdesc', 'products.artprcosto', 'products.artprventa', 'products.stock', 'products.artmarca','proveedores.prvrazon', 'artstatus')
        ->join('proveedores', 'proveedores.id', '=', 'products.proveedor_id') // Añadiendo el INNER JOIN
        //->where('products.stock', '>=', 0)
        ->orderBy('products.artdesc', 'asc')
        ->get();        
        

        $total_stock = Product::where('stock', '>', 0)->sum('stock');

        $total_costo = Product::where('stock', '>', 0)->sum(DB::raw('artprcosto * stock'));

        $total_venta = Product::where('stock', '>', 0)->sum(DB::raw('artprventa * stock'));

        return view('exports.posicion',['products' => $products, 'total_stock' => $total_stock, 'total_costo' => $total_costo, 'total_venta' => $total_venta ]);

    }

    

    public function columnFormats(): array

    {

        return [

            'A' => NumberFormat::FORMAT_NUMBER,

            'B' => NumberFormat::FORMAT_NUMBER,

            'C' => NumberFormat::FORMAT_TEXT,

            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,            

        ];

    }

}