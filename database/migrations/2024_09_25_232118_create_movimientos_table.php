<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade'); // Relación con el producto
            $table->foreignId('categoria_movimiento_id')->constrained('categorias_movimiento')->onDelete('cascade'); // Relación con la categoría de movimiento
            $table->integer('cantidad'); // Cantidad de productos en el movimiento
            $table->decimal('precio_unitario')->nullable(); // Precio por unidad (opcional)
            $table->string('codigo_barra')->nullable(); // Código de barra del producto
            $table->string('nombre')->nullable(); // Nombre del producto
            $table->dateTime('fecha_movimiento'); // Fecha del movimiento
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
};
