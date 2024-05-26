<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->default(0);
            $table->decimal('quantity', 8, 2)->default(0.00);  
            $table->date('entry_date'); // Fecha de entrada para aplicar FIFO            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};

/*
CREATE VIEW history AS
SELECT 
    YEAR(f.fecha) AS year, 
    MONTH(f.fecha) AS mes, 
    f.fecha, 
    m.id_pto, 
    p.descripcion, 
    p.marca, 
    p.detalle, 
    p.codigo, 
    p.clave, 
    m.costo, 
    m.venta, 
    m.cant AS cantidad, 
    m.nfam 
FROM 
    facturacion f 
INNER JOIN 
    facturacion_mon m 
ON 
    f.id_vta = m.id_vta 
INNER JOIN 
    productos p 
ON 
    m.id_pto = p.id 
WHERE 
    f.fecha BETWEEN '2023-01-01' AND '2024-04-30';

    SELECT 
    *,
    SUM(CASE WHEN mes = 1 AND year = 2023 THEN cantidad ELSE 0 END) AS enero,
    SUM(CASE WHEN mes = 2 AND year = 2023 THEN cantidad ELSE 0 END) AS febrero,
    SUM(CASE WHEN mes = 3 AND year = 2023 THEN cantidad ELSE 0 END) AS marzo,
    SUM(CASE WHEN mes = 4 AND year = 2023 THEN cantidad ELSE 0 END) AS abril,
    SUM(CASE WHEN mes = 5 AND year = 2023 THEN cantidad ELSE 0 END) AS mayo,
    SUM(CASE WHEN mes = 6 AND year = 2023 THEN cantidad ELSE 0 END) AS junio,
    SUM(CASE WHEN mes = 7 AND year = 2023 THEN cantidad ELSE 0 END) AS julio,
    SUM(CASE WHEN mes = 8 AND year = 2023 THEN cantidad ELSE 0 END) AS agosto,
    SUM(CASE WHEN mes = 9 AND year = 2023 THEN cantidad ELSE 0 END) AS septiembre,
    SUM(CASE WHEN mes = 10 AND year = 2023 THEN cantidad ELSE 0 END) AS octubre,
    SUM(CASE WHEN mes = 11 AND year = 2023 THEN cantidad ELSE 0 END) AS noviembre,
    SUM(CASE WHEN mes = 12 AND year = 2023 THEN cantidad ELSE 0 END) AS diciembre,
	SUM(CASE WHEN mes = 1 AND year = 2024 THEN cantidad ELSE 0 END) AS ene,
	SUM(CASE WHEN mes = 2 AND year = 2024 THEN cantidad ELSE 0 END) AS feb,
	SUM(CASE WHEN mes = 3 AND year = 2024 THEN cantidad ELSE 0 END) AS mar,
	SUM(CASE WHEN mes = 4 AND year = 2024 THEN cantidad ELSE 0 END) AS abr
FROM 
    history
WHERE 
 fecha BETWEEN '2023-01-01' AND '2024-05-22'
GROUP BY id_pto´

-- DEMANDA MENSUAL--
SELECT a.id_pto, p.codbarras, p.artdesc, p.artdetalle, p.artmarca, p.artprcosto, p.artprventa, 
enero,
febrero,
marzo,
abril,
mayo,
junio,
julio,
agosto,
septiembre,
noviembre,
diciembre,
ene,
feb,
mar,
abr,
p.stock
FROM averages a
INNER JOIN products p ON a.id_pto = p.id

 */
