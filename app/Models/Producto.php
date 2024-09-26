<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_barra', // Código de barras único
        'sku', // SKU único
        'nombre', // Nombre del producto
        'descripcion_corta', // Descripción corta del producto
        'descripcion_larga', // Descripción larga del producto
        'imagen', // Ruta de la imagen del producto
        'precio_neto', // Precio sin impuestos
        'precio_venta', // Precio de venta con impuestos (IVA 19%)
        'stock_actual', // Stock actual del producto
        'stock_minimo', // Stock mínimo permitido
        'stock_bajo', // Umbral para stock bajo
        'stock_alto', // Umbral para stock alto
        'activo', // Estado activo/inactivo
        'user_id_create', // ID del usuario que creó el producto
        'user_id_last_update', // ID del último usuario que actualizó
        'categoria_id', // Clave foránea para la categoría
    ];

    // Relación: Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Mutador para calcular el precio de venta (con IVA)
    public function getPrecioVentaAttribute()
    {
        return $this->precio_neto * 1.19; // Aplicar el 19% de IVA
    }
}