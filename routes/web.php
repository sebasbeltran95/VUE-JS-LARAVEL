<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',function(){ return redirect('login'); })->name('login');


Auth::routes(['register' => false]);
// Auth::routes();


Route::group(['middleware' => ['auth']], function (){
    // dashbaord 
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    // User 
    Route::get('/usuarios', [UserController::class, 'index'])->name('vistaUser');
    Route::get('/consultarUser', [UserController::class, 'consultarUsuarios'])->name('consultarUser');
    Route::post('/createUser', [UserController::class, 'crearUsuario'])->name('createUser');
    Route::put('/editarUser/{id}', [UserController::class, 'editarUsuario'])->name('editarUser');
    Route::put('/editarPassword/{id}', [UserController::class, 'editarContraseña'])->name('editarPassword');
    Route::delete('/eliminarUser/{id}',[UserController::class, 'eliminarUsuario'])->name('eliminarUser');
    Route::get('/filtrarUsuarios', [UserController::class, 'filtrarUsuarios'])->name('filtrarUsuarios');
    // clientes 
    Route::get('/vistaCliente', [ClientesController::class, 'index'])->name('vistaCliente');
    // ventas 
    Route::get('/vistaVenta', [VentasController::class, 'index'])->name('vistaVenta');
    // productos 
    Route::get('/vistaProducto', [ProductosController::class, 'index'])->name('vistaProducto');



});


