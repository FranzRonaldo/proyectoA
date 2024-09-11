<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ConsumoController;
use App\Http\Controllers\PagoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
| Estas rutas son cargadas por el RouteServiceProvider dentro de un grupo 
| que contiene el middleware "web". ¡Crea algo genial!
|
*/

// Rutas de autenticación
Auth::routes();

// Ruta raíz
Route::get('/', [HomeController::class, 'root']);

// Rutas para la traducción de idiomas
Route::get('index/{locale}', [HomeController::class, 'lang']);

// Ruta para manejar formularios
Route::post('/formsubmit', [HomeController::class, 'FormSubmit'])->name('FormSubmit');

// Rutas para gestionar "personas"
Route::resource('personas', PersonaController::class);
Route::patch('personas/{persona}/inactivate', [PersonaController::class, 'inactivate'])->name('personas.inactivate');
Route::patch('personas/{persona}/activate', [PersonaController::class, 'activate'])->name('personas.activate');

// Rutas para gestionar "socios"
Route::resource('socios', SocioController::class);

// Rutas para gestionar "actividades"
Route::resource('actividades', ActividadController::class);

// Rutas para gestionar "consumos"
Route::resource('consumos', ConsumoController::class);
Route::get('/consumos/{id}/detalle', [ConsumoController::class, 'detalle'])->name('consumos.detalle');
Route::get('/consumos/socio/{id}', [ConsumoController::class, 'detallesPorSocio'])->name('consumos.detallesPorSocio');
Route::post('/consumos/{consumo}/calcular-monto', [ConsumoController::class, 'calcularMonto']);
Route::post('/consumos/{consumo}/marcar-pago/{estadoPago}', [ConsumoController::class, 'marcarPago']);

// Rutas para gestionar "asistencias"
Route::resource('asistencias', AsistenciaController::class);
Route::post('asistencias/registrar', [AsistenciaController::class, 'store'])->name('asistencias.store');

Route::resource('pagos', PagoController::class);


// Ruta de fallback para cualquier otra URL
Route::get('{any}', [HomeController::class, 'index'])->where('any', '.*');
