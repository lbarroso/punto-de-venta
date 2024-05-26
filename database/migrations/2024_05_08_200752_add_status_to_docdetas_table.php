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
        Schema::table('docdetas', function (Blueprint $table) {
            // Agregar la columna 'status' con el valor por defecto 'A'
            $table->string('status')->default('A')->after('uuid'); // Asegúrate de reemplazar 'last_column_name' con el nombre de la última columna de la tabla.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('docdetas', function (Blueprint $table) {
            // Eliminar la columna 'status' si la migración se revierte
            $table->dropColumn('status');
        });
    }
};
