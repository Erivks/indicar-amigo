<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndicacaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('indicacao')->group(function () {
    Route::post(
        '/create', 
        [IndicacaoController::class, 'create']
    )->name("indicacao.create");

    Route::get(
        '/getAll',
        [IndicacaoController::class, 'getAll']
    )->name("indicacao.getAll");

    Route::delete(
        '/delete/{id}',
        [IndicacaoController::class, 'delete']
    )->name('indicacao.delete');

    Route::put(
        '/updateByID/{id}',
        [IndicacaoController::class, 'updateByID']
    )->name('indicacao.update');
});