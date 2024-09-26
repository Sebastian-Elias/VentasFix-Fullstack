<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Mantenedor;
use App\Models\Privilegio;
use App\Models\Rol;
use App\Models\RolMantenedorPrivilegio;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    private const SINGULAR_MIN = 'producto';
    private const SINGULAR_MAY = 'Producto';
    private const PLURAL_MIN = 'productos';
    private const PLURAL_MAY = 'Productos';

    private $properties = [
        'title' => [
            'genero' => 'm',
            'name' => self::SINGULAR_MAY,
            'singular' => self::SINGULAR_MAY,
            'plural' => self::PLURAL_MAY,
        ],
        'view' => [
            'index' => 'backoffice.mantenedor.' . self::PLURAL_MIN,
        ],
        'actions' => [
            'new' => '/backoffice/productos/new',
        ],
        'routes' => [
            'index' => self::PLURAL_MIN . '.index',
        ],
        'fields' => [
            [
                'id' => 1,
                'name' => 'codigo_barra',
                'label' => 'Código de Barra',
                'control' => 'input',
                'type' => 'text',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 2,
                'name' => 'sku',
                'label' => 'Sku',
                'control' => 'input',
                'type' => 'text',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 3,
                'name' => 'nombre',
                'label' => 'Nombre del ' . self::SINGULAR_MAY,
                'control' => 'input',
                'type' => 'text',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 4, 
                'name' => 'categoria',
                'label' =>  'Categoría',
                'control' => 'select', // Será un campo select
                'options' => [], // Aquí puedes cargar dinámicamente las opciones de categorías
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 5,
                'name' => 'precio_neto',
                'label' => 'Precio Neto',
                'control' => 'input',
                'type' => 'number',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 6,
                'name' => 'precio_venta',
                'label' => 'Precio de Venta',
                'control' => 'input',
                'type' => 'number',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 7,
                'name' => 'stock_actual',
                'label' => 'Stock Actual',
                'control' => 'input',
                'type' => 'number',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 8,
                'name' => 'stock_minimo',
                'label' => 'Stock Mínimo',
                'control' => 'input',
                'type' => 'number',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 9,
                'name' => 'stock_bajo',
                'label' => 'Stock Bajo',
                'control' => 'input',
                'type' => 'number',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 10,
                'name' => 'stock_alto',
                'label' => 'Stock Alto',
                'control' => 'input',
                'type' => 'number',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 11,
                'name' => 'descripcion_corta',
                'label' => 'Descripción Corta',
                'control' => 'input',
                'type' => 'text',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 12,
                'name' => 'descripcion_larga',
                'label' => 'Descripción Larga',
                'control' => 'textarea',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 13,
                'name' => 'imagen',
                'label' => 'Imagen del ' . self::SINGULAR_MAY,
                'control' => 'file',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 14,
                'control' => 'input',
                'label' => 'Detalles del ' . self::SINGULAR_MAY,
                'nombre' => 'Descripción',
                'listaDetalles' => [],
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => false, 
            ],
        ]
    ];
    

    public function index()
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        
        // Recupera todos los registros de productos
        $datos = Producto::all();

        // Recupera datos adicionales de cada producto
        foreach ($datos as $registro) {
            if ($registro->user_id_create) {
                $registro->user_id_create_nombre = User::findOrFail($registro->user_id_create)->nombre;
            }
            if ($registro->user_id_last_update) {
                $registro->user_id_last_update_nombre = User::findOrFail($registro->user_id_last_update)->nombre;
            }
        }

        // Obtiene el nombre del rol del usuario
        $user->rol_nombre = Rol::findOrFail($user->rol_id)->nombre;

        // Privilegios del rol en Mantenedor
        $allRolMantenedorPrivilegio = RolMantenedorPrivilegio::where('rol_id', $user->rol_id)->get();
        $rolMP = [];
        foreach ($allRolMantenedorPrivilegio as $rmp) {
            $rolMP[$rmp->mantenedor_id][$rmp->privilegio_id] = $rmp->activo;
        }

        // Recuperar las categorías para el formulario de productos
        $categorias = Categoria::all();

        return view($this->properties['view']['index'], [
            'user' => $user,
            'registros' => $datos,
            'action' => $this->properties['actions'],
            'titulo' => $this->properties['title'],
            'campos' => $this->properties['fields'],
            'mantenedor_id' => 4, // Ajusta según necesites
            'categorias' => $categorias,
            'mantenedores' => Mantenedor::all(),
            'privilegios' => Privilegio::all(),
            'rolMP' => $rolMP,
        ]);
    }

    public function getById($id = null)
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        if ($id === null) {
            // Si $id es nulo, obtén todos los productos
            $datos = Producto::all();
        } else {
            // Encuentra el producto por su ID
            $datos = Producto::findOrFail($id);
        }

        return response()->json([
            'data' => $datos
        ]);
    }

    public function enable($id)
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        $producto = Producto::findOrFail($id);
        $producto->activo = true; // Asegúrate de tener una columna 'activo' en tu tabla
        $producto->user_id_last_update = $user->id;

        try {
            $producto->save();
            return redirect()->route('productos.index')->with('success', 'Producto activado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al activar el producto: ' . $e->getMessage());
        }
    }

    public function disable($id)
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
    
        $producto = Producto::findOrFail($id);
        $producto->activo = false; // Asegúrate de tener una columna 'activo' en tu tabla
        $producto->user_id_last_update = $user->id;
    
        try {
            $producto->save();
            return redirect()->route('productos.index')->with('success', 'Producto desactivado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al desactivar el producto: ' . $e->getMessage());
        }
    }
    
    public function create(Request $_request)
    {
        
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        

        $_request->validate([
            'producto_codigo_barra' => 'required|string|max:255|unique:productos,codigo_barra',
            'producto_sku' => 'required|string|max:255|unique:productos,sku',
            'producto_nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'producto_precio_neto' => 'required|numeric',
            'producto_descripcion_corta' => 'nullable|string',
            'producto_descripcion_larga' => 'nullable|string',
            'producto_imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'producto_stock_actual' => 'required|integer',
            'producto_stock_minimo' => 'required|integer',
            'producto_stock_bajo' => 'required|integer',
            'producto_stock_alto' => 'required|integer',
        ], $this->mensajes);
        

        try {
            // Manejar la carga de la imagen
            $imagePath = $_request->file('producto_imagen')->store('images/products', 'public');
            
            Producto::create([
                'codigo_barra' => $_request->producto_codigo_barra,
                'sku' => $_request->producto_sku,
                'nombre' => $_request->producto_nombre,
                'precio_neto' => $_request->producto_precio_neto,
                'precio_venta' => $_request->producto_precio_venta,
                'descripcion_corta' => $_request->producto_descripcion_corta,
                'descripcion_larga' => $_request->producto_descripcion_larga,
                'activo' => true, 
                'imagen' => $imagePath,
                'categoria_id' => $_request->categoria_id,
                'stock_actual' => $_request->producto_stock_actual,
                'stock_minimo' => $_request->producto_stock_minimo,
                'stock_bajo' => $_request->producto_stock_bajo,
                'stock_alto' => $_request->producto_stock_alto,
                'user_id_create' => $user->id,
                'user_id_last_update' => $user->id,
            ]);
            
            return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el producto: ' . $e->getMessage());
           
        }
    }


    public function store(Request $request)
    {
        // Lógica para guardar un producto en la base de datos
    }

    public function show($id)
    {
        // Mostrar un producto específico
    }

    public function edit($id)
    {
        // Mostrar el formulario para editar un producto
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        $producto = Producto::findOrFail($id);

        $request->validate([
            'producto_codigo_barra' => 'required|string|max:255|unique:productos,codigo_barra,' . $producto->id,
            'producto_sku' => 'required|string|max:255|unique:productos,sku,' . $producto->id,
            'producto_nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'producto_precio_neto' => 'required|numeric',
            'producto_descripcion_corta' => 'nullable|string',
            'producto_descripcion_larga' => 'nullable|string',
            'producto_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'producto_stock_actual' => 'required|integer',
            'producto_stock_minimo' => 'required|integer',
            'producto_stock_bajo' => 'required|integer',
            'producto_stock_alto' => 'required|integer',
        ], $this->mensajes);

        try {
            // Actualiza los datos del producto
            $producto->codigo_barra = $request->producto_codigo_barra;
            $producto->sku = $request->producto_sku;
            $producto->nombre = $request->producto_nombre;
            $producto->precio_neto = $request->producto_precio_neto;
            $producto->descripcion_corta = $request->producto_descripcion_corta;
            $producto->descripcion_larga = $request->producto_descripcion_larga;
            $producto->stock_actual = $request->producto_stock_actual;
            $producto->stock_minimo = $request->producto_stock_minimo;
            $producto->stock_bajo = $request->producto_stock_bajo;
            $producto->stock_alto = $request->producto_stock_alto;
            $producto->user_id_last_update = $user->id;

            if ($request->hasFile('producto_imagen')) {
                // Manejar la carga de la nueva imagen
                $imagePath = $request->file('producto_imagen')->store('images/products', 'public');
                $producto->imagen = $imagePath;
            }

            $producto->save();

            return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Verificar si el usuario está autenticado
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        // Buscar el producto por su ID
        $producto = Producto::findOrFail($id);

        // Aquí puedes agregar una lógica similar para evitar la eliminación si es necesario
        // Por ejemplo, verificar si el producto está asociado con otras entidades

        try {
            // Eliminar el producto
            $producto->delete();
            return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

}
