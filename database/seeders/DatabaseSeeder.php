<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Persona;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Persona::create([
            'nombre' => 'Omar',
            'apellido' => 'Quispe Tapia',
            'usuario' => 'omarqm',
            'correo' => 'omarquispe@ejemplo.com',
            'telefono' => '71278342',
            'rol' => 'administrador',
            'password' => bcrypt('Omar411*'),
            'estado' => 'Disponible'
        ]);
        Persona::create([
            'nombre' => 'Juan Carlos',
            'apellido' => 'Chavez Machaca',
            'usuario' => 'juanpari',
            'correo' => 'juanchavez@ejemplo.com',
            'telefono' => '71979648',
            'rol' => 'usuario',
            'password' => bcrypt('User123*'),
            'estado' => 'Disponible'
        ]);
        Persona::create([
            'nombre' => 'Jose Miguel',
            'apellido' => 'Choque',
            'usuario' => 'josejose',
            'correo' => 'jose@ejemplo.com',
            'telefono' => '71234123',
            'rol' => 'usuario',
            'password' => bcrypt('User123*'),
            'estado' => 'Disponible'
        ]);
    }
}