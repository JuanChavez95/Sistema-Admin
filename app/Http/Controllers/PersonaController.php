<?php
namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonaController extends Controller
{
    // Vista 1: Rol Administrador, solo se ven usuarios con estado disponible.
    public function index()
    {
        $personas = Persona::where('estado', 'Disponible')->latest()->get();
        return view('admin.dashboard', compact('personas'));
    }
    // Vista 2: Rol Usuario y puede ver su perfil
    public function profile()
    {
        $persona = Auth::user();
        return view('personas.profile', compact('persona'));
    }

    // Alta de usuarios ADMIN
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'usuario' => 'required|unique:personas,usuario',
            'correo' => 'required|email:rfc,dns|unique:personas,correo',
            'telefono' => 'required|min:8',
            'password' => 'required|min:8', // Obligatorio y mínimo 8 caracteres
            'rol' => 'required',
            'estado' => 'required'
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'telefono.min' => 'El Teléfono debe tener al menos 8 caracteres.',
            'correo.email' => 'El formato del correo electrónico no es válido.'
        ]);
        
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        Persona::create($data);
        return back()->with('success', 'Usuario registrado con éxito.');
    }

    // Modificación de registros ADMIN
    public function update(Request $request, $id)
    {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'usuario' => 'required|unique:personas,usuario,' . $id,
            'correo' => 'required|email:rfc,dns|unique:personas,correo,' . $id,
            'telefono' => 'required',
            'rol' => 'required',
            'estado' => 'required'
        ];

        // La contraseña exige el mínimo de 8 caracteres
        if ($request->filled('password')) {
            $rules['password'] = 'min:8';
        }

        $request->validate($rules, [
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'correo.email' => 'El formato del correo electrónico no es válido.'
        ]);

        $persona = Persona::findOrFail($id);
        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        $persona->update($data);
        return back()->with('success', 'Usuario actualizado con éxito.');
    }

    // Baja Lógica ADMIN
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->update(['estado' => 'Bloqueado']);
        
        return back()->with('success', 'Usuario eliminado lógicamente con éxito.');
    }

    // Inicio de sesión con validación de estado "Disponible"
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'usuario' => 'required',
            'password' => 'required'
        ], [
            'usuario.required' => 'El campo usuario no puede estar vacío.',
            'password.required' => 'El campo contraseña no puede estar vacío.'
        ]);
        
        if (!Auth::attempt($credenciales)) {
            return back()->withErrors(['error' => 'Datos incorrectos. El usuario o la contraseña no coinciden.'])->withInput();
        }

        // Restricción: Si el usuario está Bloqueado, no puede acceder
        if (Auth::user()->estado !== 'Disponible') {
            Auth::logout();
            return back()->withErrors(['error' => 'Tu cuenta se encuentra bloqueada. Comunícate con el admin.']);
        }

        $request->session()->regenerate();
        // Control de redirección por roles exactos según roles
        if (Auth::user()->rol === 'administrador') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('user.profile');
    }
    // Cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
