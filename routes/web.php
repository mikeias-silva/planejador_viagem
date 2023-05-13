<?php

use App\Http\Controllers\RotasController;
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

Route::resource('rotas', RotasController::class, ['names'=>'rotas']);

Route::post('/rotas/partida', [RotasController::class, 'storeParadas'])->name('rota.storeParadas');

Route::get('/rotas/roteirizar/{rota}', [ RotasController::class, 'roteirizar'])->name('rota.roteirizar');
Route::get('/rotas/edit/paradas/{rota}', [ RotasController::class, 'editParadas'])->name('rota.editParadas');
Route::get('/rotas/deletar/{rota}', [ RotasController::class, 'deletar'])->name('rota.deletar');
Route::delete('/rotas/excluir/{rota}', [ RotasController::class, 'destroy'])->name('rota.excluir');
