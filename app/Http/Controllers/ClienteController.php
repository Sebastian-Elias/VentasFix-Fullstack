<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mantenedor;
use App\Models\Privilegio;
use App\Models\Rol;
use App\Models\RolMantenedorPrivilegio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;


class ClienteController extends Controller
{
    private const SINGULAR_MIN = 'cliente';
    private const SINGULAR_MAY = 'Cliente';
    private const PLURAL_MIN = 'clientes';
    private const PLURAL_MAY = 'Clientes';

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
            'new' => '/backoffice/clientes/new',
        ],
        'routes' => [
            'index' => self::PLURAL_MIN . '.index',
        ],
        'fields' => [
            [
                'id' => 1,
                'name' => 'rut_empresa',
                'label' => 'RUT de la Empresa',
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
                'name' => 'rubro',
                'label' => 'Rubro',
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
                'name' => 'razon_social',
                'label' => 'Razón Social',
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
                'name' => 'nombre_contacto',
                'label' => 'Nombre de Contacto',
                'control' => 'input',
                'type' => 'text',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 5,
                'name' => 'email_contacto',
                'label' => 'Email de Contacto',
                'control' => 'input',
                'type' => 'email',
                'required' => true,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 6,
                'name' => 'telefono',
                'label' => 'Teléfono',
                'control' => 'input',
                'type' => 'text',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
            [
                'id' => 7,
                'name' => 'direccion',
                'label' => 'Dirección',
                'control' => 'textarea',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,
                'inForm' => true,
            ],
        ]
    ];

    public function index()
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        
        // Recupera todos los registros de clientes
        $datos = Cliente::all();

        // Recupera datos adicionales de cada cliente
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

        return view($this->properties['view']['index'], [
            'user' => $user,
            'registros' => $datos,
            'action' => $this->properties['actions'],
            'titulo' => $this->properties['title'],
            'campos' => $this->properties['fields'],
            'mantenedor_id' => 2,
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
            // Si $id es nulo, obtén todos los clientes
            $datos = Cliente::all();
        } else {
            // Encuentra el cliente por su ID
            $datos = Cliente::findOrFail($id);
        }

        return response()->json([
            'data' => $datos
        ]);
    }

    public function enable($id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
    
        // Buscar el cliente por su ID
        $cliente = Cliente::findOrFail($id);
    
        // Verifica que el usuario no esté intentando habilitarse a sí mismo (si aplica)
        if ($cliente) { // Se puede agregar una condición aquí si es necesario
            $cliente->activo = true; // Habilitar cliente
            try {
                $cliente->save();
                return redirect()->route('clientes.index')->with('success', 'Cliente activado con éxito.');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Error al activar el cliente: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Cliente no encontrado.');
        }
    }
    
    public function disable($id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
    
        // Buscar el cliente por su ID
        $cliente = Cliente::findOrFail($id);
    
        // Verifica que el usuario no esté intentando deshabilitarse a sí mismo (si aplica)
        if ($cliente) { 
            $cliente->activo = false; // Deshabilitar cliente
            try {
                $cliente->save();
                return redirect()->route('clientes.index')->with('success', 'Cliente desactivado con éxito.');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Error al desactivar el cliente: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Cliente no encontrado.');
        }
    }
    
    

    public function create(Request $_request)
    {
        
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        
        // Validar la solicitud. Asegúrate de que los campos coincidan con tu modelo de Cliente
        $_request->validate([
            'cliente_rut_empresa' => 'required|string|max:255',
            'cliente_rubro' => 'required|string|max:255',
            'cliente_razon_social' => 'required|string|max:255',
            'cliente_nombre_contacto' => 'required|string|max:255',
            'cliente_email_contacto' => 'required|email|max:255|unique:clientes,email_contacto',
            'cliente_telefono' => 'nullable|string|max:15',
            'cliente_direccion' => 'nullable|string|max:255',
        ], $this->mensajes);

        try {
            // Insertar el registro en la base de datos

            Cliente::create([
                'rut_empresa' => $_request->cliente_rut_empresa,
                'rubro' => $_request->cliente_rubro,
                'razon_social' => $_request->cliente_razon_social,
                'nombre_contacto' => $_request->cliente_nombre_contacto,
                'email_contacto' => $_request->cliente_email_contacto,
                'telefono' => $_request->cliente_telefono,
                'direccion' => $_request->cliente_direccion,
                'activo' => true,
            ]);
            
            
            return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el cliente: ' . $e->getMessage());
        }
       
    }

    public function store(Request $request)
    {
        // Lógica para guardar un cliente en la base de datos
    }

    public function show($id)
    {
        // Mostrar un cliente específico
    }

    public function edit($id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        // Buscar el cliente por su ID
        $cliente = Cliente::findOrFail($id);

        // Obtiene el nombre del rol del usuario
        $user->rol_nombre = Rol::findOrFail($user->rol_id)->nombre;

        // Privilegios del rol en Mantenedor
        $allRolMantenedorPrivilegio = RolMantenedorPrivilegio::where('rol_id', $user->rol_id)->get();
        $rolMP = [];
        foreach ($allRolMantenedorPrivilegio as $rmp) {
            $rolMP[$rmp->mantenedor_id][$rmp->privilegio_id] = $rmp->activo;
        }

        return view('backoffice.mantenedor.clientes.edit', [
            'user' => $user,
            'cliente' => $cliente,
            'rolMP' => $rolMP,
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        // Buscar el cliente por su ID
        $cliente = Cliente::findOrFail($id);
       
        // Validar la solicitud. Asegúrate de que los campos coincidan con tu modelo de Cliente
        $request->validate([
            'cliente_rut_empresa' => 'required|string|max:255',
            'cliente_rubro' => 'required|string|max:255',
            'cliente_razon_social' => 'required|string|max:255',
            'cliente_nombre_contacto' => 'required|string|max:255',
            'cliente_email_contacto' => 'required|email|max:255|unique:clientes,email_contacto,' . $cliente->id,
            'cliente_telefono' => 'nullable|string|max:15',
            'cliente_direccion' => 'nullable|string|max:255',
        ], $this->mensajes);

        try {
            // Actualizar el registro en la base de datos
            $cliente->update([
                'rut_empresa' => $request->cliente_rut_empresa,
                'rubro' => $request->cliente_rubro,
                'razon_social' => $request->cliente_razon_social,
                'nombre_contacto' => $request->cliente_nombre_contacto,
                'email_contacto' => $request->cliente_email_contacto,
                'telefono' => $request->cliente_telefono,
                'direccion' => $request->cliente_direccion,
            ]);

            return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }


    public function delete($id)
{
    $user = Auth::user();
    if ($user == null) {
        return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
    }

    // Buscar el cliente por su ID
    $cliente = Cliente::findOrFail($id);

    // Aquí puedes agregar una lógica similar para evitar que se elimine a sí mismo si es necesario
    // En este caso, probablemente no sea relevante, pero puedes incluir lógica de negocio si corresponde

    try {
        // Eliminar el cliente
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito.');
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
    }
}


}
