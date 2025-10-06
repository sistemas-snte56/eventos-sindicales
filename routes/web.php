<?php

use App\Livewire\EventosCrud;
use App\Livewire\ParticipantesCrud;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // 👉 Nueva ruta para gestión de eventos
    Route::get('/eventos', EventosCrud::class)->name('eventos.index');    
    Route::get('/participantes', ParticipantesCrud::class)->name('participantes.index');    
});
