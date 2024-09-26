<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categorias_movimiento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Nombre de la categoría, ej. "Ingreso por compra", "Salida por venta"
            $table->timestamps();
        });

        // Agregar datos a la tabla recién creada
        DB::table('categorias_movimiento')->insert([
            ['nombre' => 'Ingreso por compra'],
            ['nombre' => 'Salida de venta'],
            ['nombre' => 'Ingreso por devolución'],
            ['nombre' => 'Salida por merma'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('categorias_movimiento');
    }
};
