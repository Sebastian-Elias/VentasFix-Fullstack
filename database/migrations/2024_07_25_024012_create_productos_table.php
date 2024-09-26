<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('sku');
        $table->string('nombre');
        $table->string('descripcion_corta');
        $table->text('descripcion_larga');
        $table->string('imagen')->nullable();
        $table->decimal('precio_neto', 8, 2);
        $table->decimal('precio_venta', 8, 2);
        $table->integer('stock_actual');
        $table->integer('stock_minimo');
        $table->integer('stock_bajo');
        $table->integer('stock_alto');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
