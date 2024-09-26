<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MantenedorController;
use App\Http\Controllers\PrivilegioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Ruta raíz para la API
Route::get('/', function () {
    return response()->json(['message' => 'API Home']);
});

// Rutas de autenticación
/*Route::prefix('auth')->group(function () {
    Route::post('/login', [UsuarioController::class, 'login'])->name('usuario.login');
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('usuario.logout');
    Route::post('/register', [UsuarioController::class, 'registrar'])->name('usuario.registrar');
});*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Api\UserController@register');
Route::post('/login', 'Api\UserController@login');

Route::get('/logout', 'Api\UserController@logout')->middleware('auth:api');

// Rutas de API
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('mantenedores', MantenedorController::class);
Route::apiResource('privilegios', PrivilegioController::class);
Route::apiResource('roles', RolController::class);
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('categorias', CategoriaController::class);

// Ruta de prueba para depuración
Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});