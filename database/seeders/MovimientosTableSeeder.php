<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('movimientos')->insert([
            ['id' => 51, 'movdesc' => 'VENTAS MOSTRADOR'],
            ['id' => 52, 'movdesc' => 'ENTRADAS DE PROVEEDOR'],
            ['id' => 53, 'movdesc' => 'SALIDA DE MERCANCIA'],
            ['id' => 54, 'movdesc' => 'PEDIDO ALMACEN CENTRAL'],
            ['id' => 55, 'movdesc' => 'FACTURACION SAT']
        ]);
    }
}
