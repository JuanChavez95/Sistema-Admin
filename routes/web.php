<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;

// Vista del Formulario de Login Principal
Route::get('/', function () {
    return view('personas.index');
})->name('login');

// Procesamiento del formulario de Login 
Route::post('/login-auth', [PersonaController::class, 'login'])->name('login.post');

// Cierre de sesión
Route::post('/logout', [PersonaController::class, 'logout'])->name('logout');

// Vista 1: Panel del Administrador y operaciones ABM
Route::get('/admin/dashboard', [PersonaController::class, 'index'])->name('admin.dashboard');
Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
Route::put('/personas/{id}', [PersonaController::class, 'update'])->name('personas.update');
Route::delete('/personas/{id}', [PersonaController::class, 'destroy'])->name('personas.destroy');

// Vista 2: Perfil del Usuario común
Route::get('/user/profile', [PersonaController::class, 'profile'])->name('user.profile');