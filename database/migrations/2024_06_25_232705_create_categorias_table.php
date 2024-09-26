<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Poblar la tabla con las categorías iniciales
        DB::table('categorias')->insert([
            ['nombre' => 'Alimentos y bebidas', 'descripcion' => 'Productos alimenticios y bebidas de consumo'],
            ['nombre' => 'Ropa y textiles', 'descripcion' => 'Prendas de vestir, textiles para el hogar y accesorios'],
            ['nombre' => 'Electrónica y electrodomésticos', 'descripcion' => 'Aparatos electrónicos y electrodomésticos para el hogar'],
            ['nombre' => 'Productos de limpieza y mantenimiento', 'descripcion' => 'Artículos para la limpieza y mantenimiento de espacios'],
            ['nombre' => 'Herramientas y ferretería', 'descripcion' => 'Herramientas, materiales de construcción y equipos de seguridad'],
            ['nombre' => 'Muebles y decoración', 'descripcion' => 'Mobiliario y artículos decorativos para hogar y oficina'],
            ['nombre' => 'Salud y bienestar', 'descripcion' => 'Productos farmacéuticos, de cuidado personal y suplementos'],
            ['nombre' => 'Papelería y artículos de oficina', 'descripcion' => 'Materiales de oficina, equipos y útiles escolares'],
            ['nombre' => 'Juguetes y entretenimiento', 'descripcion' => 'Juguetes para niños, videojuegos y artículos de entretenimiento'],
            ['nombre' => 'Automotriz', 'descripcion' => 'Repuestos y accesorios para vehículos, herramientas automotrices'],
            ['nombre' => 'Materiales y suministros industriales', 'descripcion' => 'Equipos industriales y materiales para manufactura'],
            ['nombre' => 'Belleza y cosmética', 'descripcion' => 'Productos de maquillaje, cuidado personal y fragancias'],
            ['nombre' => 'Jardinería y productos para el hogar', 'descripcion' => 'Herramientas y productos para la jardinería y el hogar'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
