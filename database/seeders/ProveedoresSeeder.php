<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Limpiar la tabla antes de sembrar nuevos datos
       Proveedor::where('prvrazon')->delete();

        // Datos de ejemplo
        $data = [
            ['prvrazon' => 'TODOS LOS PROVEEDORES'],
        // Puedes agregar más 
        ];

        // Sembrar los datos en la tabla 
        Proveedor::insert($data);

    }
}
