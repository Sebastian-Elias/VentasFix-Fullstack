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
        Schema::create('roles_mantenedores_privilegios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rol_id')->onDelete('cascade');;
            $table->unsignedBigInteger('mantenedor_id');
            $table->unsignedBigInteger('privilegio_id');
            $table->unsignedBigInteger('user_id_create');
            $table->unsignedBigInteger('user_id_last_update');
            $table->boolean('activo')->default(false);
            $table->foreign('user_id_create')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_last_update')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Agregar datos a la tabla recién creada
        DB::table('roles_mantenedores_privilegios')->insert([
            // Privilegios de Usuarios
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 1, //1-Usuarios
                'privilegio_id' => 1, //1-Acceder
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 1, //1-Usuarios
                'privilegio_id' => 2, //2-Crear
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 1, //1-Usuarios
                'privilegio_id' => 3, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 1, //1-Usuarios
                'privilegio_id' => 4, //4-Actualizar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 1, //1-Usuarios
                'privilegio_id' => 5, //5-Encender
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 1, //1-Usuarios
                'privilegio_id' => 6, //6-Apagar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 1, //1-Usuarios
                'privilegio_id' => 7, //7-Eliminar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Privilegios de Clientes
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 2, //2-Clientes
                'privilegio_id' => 1, //1-Acceder
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 2, //2-Clientes
                'privilegio_id' => 2, //2-Crear
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 2, //2-Clientes
                'privilegio_id' => 3, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 2, //2-Clientes
                'privilegio_id' => 4, //4-Actualizar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 2, //2-Clientes
                'privilegio_id' => 5, //5-Encender
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 2, //2-Clientes
                'privilegio_id' => 6, //6-Apagar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 2, //2-Clientes
                'privilegio_id' => 7, //7-Eliminar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Privilegios de Categorias
            [
                'rol_id' => 1,
                'mantenedor_id' => 3,
                'privilegio_id' => 1,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 3,
                'privilegio_id' => 2,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 3,
                'privilegio_id' => 3,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 3,
                'privilegio_id' => 4,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 3,
                'privilegio_id' => 5,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 3,
                'privilegio_id' => 6,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 3,
                'privilegio_id' => 7,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Privilegios de Productos
            [
                'rol_id' => 1,
                'mantenedor_id' => 4,
                'privilegio_id' => 1,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 4,
                'privilegio_id' => 2,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 4,
                'privilegio_id' => 3,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 4,
                'privilegio_id' => 4,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 4,
                'privilegio_id' => 5,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 4,
                'privilegio_id' => 6,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1,
                'mantenedor_id' => 4,
                'privilegio_id' => 7,
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Privilegios de Mantenedores
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 5, //Mantenedores
                'privilegio_id' => 1, //1-Acceder
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 5, //Mantenedores
                'privilegio_id' => 2, //2-Crear
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 5, //Mantenedores
                'privilegio_id' => 3, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 5, //Mantenedores
                'privilegio_id' => 4, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 5, //Mantenedores
                'privilegio_id' => 5, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 5, //Mantenedores
                'privilegio_id' => 6, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 5, //Mantenedores
                'privilegio_id' => 7, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            //Privilegios de Privilegios
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 6, //5-Privilegios
                'privilegio_id' => 1, //1-Acceder
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 6, //5-Privilegios
                'privilegio_id' => 2, //2-Crear
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 6, //5-Privilegios
                'privilegio_id' => 3, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 6, //5-Privilegios
                'privilegio_id' => 4, //4-Actualizar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 6, //5-Privilegios
                'privilegio_id' => 5, //5-Encender
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 6, //5-Privilegios
                'privilegio_id' => 6, //6-Apagar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 6, //5-Privilegios
                'privilegio_id' => 7, //7-Eliminar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            //Privilegios de Roles
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 7, //6-Roles
                'privilegio_id' => 1, //1-Acceder
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 7, //6-Roles
                'privilegio_id' => 2, //2-Crear
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 7, //6-Roles
                'privilegio_id' => 3, //3-Ver
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 7, //6-Roles
                'privilegio_id' => 4, //4-Actualizar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 7, //5-Roles
                'privilegio_id' => 5, //6-Roles
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 7, //6-Roles
                'privilegio_id' => 6, //6-Apagar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'rol_id' => 1, // D&P Admin
                'mantenedor_id' => 7, //6-Roles
                'privilegio_id' => 7, //7-Eliminar
                'user_id_create' => 1,
                'user_id_last_update' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_mantenedores_privilegios');
    }
};
