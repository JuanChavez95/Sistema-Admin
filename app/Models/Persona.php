<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Persona extends Authenticatable
{
    protected $table = 'personas';
    protected $fillable = ['nombre', 'apellido', 'usuario', 'correo', 'telefono', 'rol', 'password', 
    'estado'];
}

