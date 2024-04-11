<?php
use App\Models\Category;
use App\Models\Proveedor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('artcve')->nullable(); 
            $table->string('artdesc')->unique();                                   
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores');            
            $table->string('artstatus',2)->default('A');
            
            // category_id relacion categories
            $table->foreignIdFor(Category::class)->constrained();
                        
            $table->string('codbarras',25)->nullable();
            $table->string('artmarca')->nullable();
            $table->string('artestilo')->nullable();
            $table->string('artcolor')->nullable();
            $table->string('artseccion')->nullable();
            $table->string('arttalla')->nullable();
            $table->integer('stock')->default(0);            
            $table->float('artprcosto')->unsigned()->default(0);
            $table->float('artprventa')->unsigned()->default(0);
            $table->string('artpesogrm',6)->default('1');
            $table->string('artpesoum',3)->default('PZA');
            $table->smallInteger('artganancia')->default(0);
            $table->longText('artdetalle')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

/***INICIAR INVENTARIO LA PIÑATA
CREATE VIEW products_ini AS
SELECT p.id, p.clave, p.descripcion, '1', p.stado, p.nfam, p.codigo, p.marca, '','','','', p.neto, 
t.costo, t.venta, p.gramaje, p.umedida, t.utilida, p.detalle, '2024-03-05','2024-03-05'
FROM productos p
INNER JOIN precios t ON p.id = t.id_pto
GROUP BY p.descripcion 
*/

/****
 * CARGAR CLAVES GENERICAS
SELECT codigo, id,gen_1,gen_2,gen_3,gen_4,gen_5,gen_6,gen_7,gen_8,gen_9,gen_10,gen_11,gen_12
FROM productos 
WHERE gen_1 !='NULL' AND
gen_2 !='NULL' AND
gen_3 !='NULL' AND
gen_4 !='NULL' AND
gen_5 !='NULL' AND
gen_6 !='NULL' AND
gen_7 !='NULL' AND
gen_8 !='NULL' AND
gen_9 !='NULL' AND
gen_10 !='NULL' AND
gen_11 !='NULL' AND
gen_12 !='NULL'
GROUP BY descripcion
 */