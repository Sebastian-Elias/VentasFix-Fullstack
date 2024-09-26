<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Mantenedor;
use App\Models\Privilegio;
use App\Models\Rol;
use App\Models\RolMantenedorPrivilegio;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    private const SINGULAR_MIN = 'categoria';
    private const SINGULAR_MAY = 'Categoria';
    private const PLURAL_MIN = 'categorias';
    private const PLURAL_MAY = 'Categorias';

    private $properties = [
        'title' => [
            'genero' => 'f', 
            'name' => self::SINGULAR_MAY,
            'singular' => self::SINGULAR_MAY,
            'plural' => self::PLURAL_MAY,
        ],
        'view' => [
            'index' => 'backoffice.mantenedor.' . self::PLURAL_MIN,
        ],
        'actions' => [
            'new' => '/backoffice/categorias/new',
        ],
        'routes' => [
            'index' => self::PLURAL_MIN . '.index',
        ],
        'fields' => [
            [
                'id' => 1,
                'name' => 'nombre',
                'label' => 'Nombre de la ' . self::SINGULAR_MAY,
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
                'name' => 'descripcion',
                'label' => 'Descripción de la ' . self::SINGULAR_MAY,
                'control' => 'textarea',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 3,
                'control' => 'table',
                'label' => 'Detalles de la ' . self::SINGULAR_MAY,
                'headers' => [
                    [
                        'id' => 0,
                        'nombre' => 'Nombre'
                    ],
                    [
                        'id' => 1,
                        'nombre' => 'Descripción'
                    ],
                ],
                'listaDetalles' => [], // Aquí puedes incluir detalles si los hay
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => false,
            ],
        ],
    ];

    
    public function index()
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
    
        // Recupera todos los registros de categorías
        $categorias = Categoria::all();
    
        // Recupera datos adicionales de cada categoría
        foreach ($categorias as $categoria) {
            if ($categoria->user_id_create) {
                $categoria->user_id_create_nombre = User::findOrFail($categoria->user_id_create)->nombre;
            }
            if ($categoria->user_id_last_update) {
                $categoria->user_id_last_update_nombre = User::findOrFail($categoria->user_id_last_update)->nombre;
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
    
        return view($this->properties['view']['index'], [
            'user' => $user,
            'registros' => $categorias,
            'action' => $this->properties['actions'],
            'titulo' => $this->properties['title'],
            'campos' => $this->properties['fields'],
            'mantenedor_id' => 3, // Ajusta según necesites
            'mantenedores' => Mantenedor::all(),
            'privilegios' => Privilegio::all(),
            'rolMP' => $rolMP,
        ]);
    }
    

    public function create(Request $_request)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        
        $_request->validate([
            'categoria_nombre' => 'required|string|max:255|unique:categorias,nombre',
            'categoria_descripcion' => 'nullable|string',
        ], $this->mensajes);
        
        try {
            Categoria::create([
                'nombre' => $_request->categoria_nombre,
                'descripcion' => $_request->categoria_descripcion,
                'activo' => true, // Ajusta según tu lógica
                'user_id_create' => $user->id,
                'user_id_last_update' => $user->id,
            ]);
    
            return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la categoría: ' . $e->getMessage());
        }
    }
    


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        return response()->json($categoria);
    }

    public function getById($id)
    {
        $categoria = Categoria::findOrFail($id);
        return response()->json($categoria);
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada con éxito.']);
    }
}